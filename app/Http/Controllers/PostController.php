<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->orderBy('created_at', 'desc')->get();
        $randomPosts = Post::with('user')->inRandomOrder()->take(4)->get();
        $categories = Post::distinct()->pluck('category');

        if (request()->routeIs('home')) {
            return view('index', compact('posts', 'randomPosts', 'categories'));
        }

        foreach ($posts as $post) {
            $usersWhoGeared = $post->gears;

            // Randomly select one user (if any)
            $randomUser = $usersWhoGeared->isNotEmpty() ? $usersWhoGeared->random() : null;

            // Get the count of other users (excluding the randomly selected one)
            $othersCount = $usersWhoGeared->count() - 1;

            // Add the random user and others count to the post
            $post->randomUser = $randomUser;
            $post->othersCount = $othersCount;
        }

        return view('posts', compact('posts', 'categories'));
    }

    public function show($id)
    {
        $post = Post::with('user', 'gears')->findOrFail($id);
        $usersWhoGeared = $post->gears;
        $randomUser = $usersWhoGeared->isNotEmpty() ? $usersWhoGeared->random() : null;
        $othersCount = $usersWhoGeared->count() - 1;
        return view('viewPost', compact('post', 'randomUser', 'othersCount'));
    }

    public function store(Request $request)
    {
        // Clean the content to prevent XSS or other vulnerabilities
        $cleanContent = Purify::clean($request->content);

        // Validate the incoming request
        $request->validate([
            'category' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required|string', // You can remove 'required' validation on the frontend as it's handled by JS
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file
        ]);

        // Store the image in the 'posts' directory on the 'public' disk
        $imagePath = $request->file('image')->store('posts', 'public');

        // Create the post record in the database
        $post = Post::create([
            'category' => strtoupper($request->category),
            'content' => $cleanContent, // Store cleaned content
            'image' => $imagePath,
            'title' => $request->title,
            'user_id' => Auth::id(), // Assumes user is authenticated
        ]);

        // If the request is an AJAX request, return a JSON response
        if ($request->ajax()) {
            return response()->json(['success' => 'Post created successfully!']);
        }

        // Redirect back with success message if not AJAX
        return redirect()->back()->with('success', 'Post created successfully!');
    }

    public function update(Request $request, $id)
    {
        // Clean the content to prevent XSS or other vulnerabilities
        $cleanContent = Purify::clean($request->content);

        $request->validate([
            'category' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = Post::findOrFail($id);

        $post->category = strtoupper($request->category);
        $post->title = $request->title;
        // $post->content = $request->content;
        $post->content = $cleanContent;

        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image = $imagePath;
        }

        $post->save();

        // Return JSON response instead of redirect
        return response()->json([
            'message' => 'Post updated successfully!',
            'post' => $post,
        ]);
    }

    public function deletePost($id)
    {
        $post = Post::findOrFail($id);

        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        // return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully!',
            'postId' => $id
        ]);
    }

    public function storeComment(Request $request, $postId)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $post = Post::findOrFail($postId);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->post_id = $post->id;
        $comment->comment = $request->input('comment');
        $comment->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment added successfully!',
                'comment' => [
                    'user' => Auth::user()->name,
                    'text' => $comment->comment,
                ],
            ]);
        }

        return back()->with('success', 'Comment added successfully!');
    }

    public function gearPost(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);
        $user = Auth::user(); // Get the authenticated user

        // Toggle gear: If user already geared (liked) the post, remove it, else add it
        if ($post->gears->contains($user)) {
            // Remove gear (unlike the post)
            $post->gears()->detach($user);
        } else {
            // Add gear (like the post)
            $post->gears()->attach($user);
        }

        // Get the updated random user (the most recent user who geared the post) and count
        $randomUser = $post->gears()->latest()->first();
        $randomUserName = $randomUser ? $randomUser->name : null;

        $othersCount = $post->gears()->count() - 1; // Subtract 1 to exclude the current user if they are included

        // Return the response as JSON
        return response()->json([
            'geared' => $post->gears->contains($user), // True if the user has geared the post, false otherwise
            'randomUser' => $randomUserName,
            'othersCount' => $othersCount
        ]);
    }

    public function filterPosts(Request $request)
    {
        // Start with the query to fetch posts
        $query = Post::query();

        // Apply the search filter if it's provided
        if ($request->has('search_item') && $request->search_item != '') {
            $query->where('title', 'like', '%' . $request->search_item . '%')
                ->orWhere('category', 'like', '%' . $request->search_item . '%'); // Only search title and category
        }

        // Apply the category filter if it's provided
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Get the filtered posts
        $posts = $query->get();

        // Generate the HTML for the posts
        $html = '';
        foreach ($posts as $post) {
            $html .= '
                <div class="row mb-3">
                <a href="' . route('posts.show', $post->id) . '">
                <div class="card p-0" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);">
                <div class="card-body">
                <div class="row d-flex align-items-center mb-3">
                <div class="col-1 p-1">
                <img src="' . asset('assets/mechanics.png') . '" height="60" alt="" loading="lazy" />
                </div>
                <div class="col">
                <p class="fs-5 fw-semibold" style="margin-bottom: 0px;">' . ($post->user->name ?? 'Unknown Author') . '</p>
                <p>' . $post->created_at->format('F j, Y \a\t g:i A') . '</p>
                </div>
                </div>
                <div class="row">
                <h5 class="fw-bold mb-3">
                <span style="color: maroon;">' . $post->category . '</span> |
                <span>' . $post->title . '</span>
                </h5>
                <p>' . nl2br(e(Str::limit($post->content, 250))) . ' <a style="color: maroon;" class="fw-medium" href="' . route('posts.show', $post->id) . '">Read more</a></p>
                </div>
                </div>
                <img src="' . asset('storage/' . $post->image) . '" class="card-img" alt="...">
                <div class="row ps-3 px-3 pt-2 pb-2">
                <div class="col">
                <a href="">
                <span style="color: maroon;"><i class="bi bi-gear-fill"></i></span>
                <span>
                <small>' . ($post->randomUser ? $post->randomUser->name . ' and ' . $post->othersCount . ' others' : 'No one has geared this post yet.') . '</small>
                </span>
                </a>
                </div>
                <div class="col text-end">
                <a href=""><span><small>' . $post->comments()->count() . ' Comments</small></span></a>
                <span>•</span>
                <a href=""><span><small>20 Shares</small></span></a>
                </div>
                </div>
                <div class="card-footer p-0">
                <div class="container-fluid border">
                <div class="row">
                <div class="col btn fw-semibold">
                ' . (!$post->gears->contains(Auth::user()) ? '
                <form action="' . route('posts.gear', $post->id) . '" method="POST">
                <button type="submit" class="btn text-light" style="background-color: maroon;">Gear</button>
                </form>' : '
                <form action="' . route('posts.gear', $post->id) . '" method="POST">
                <button type="submit" class="btn text-light" style="background-color: maroon;">Geared</button>
                </form>') . '
                </div>
                <div class="col btn fw-semibold">
                <a href="' . route('posts.show', $post->id) . '" class="btn text-light" style="background-color: maroon;">COMMENT</a>
                </div>
                <div class="col btn fw-semibold">
                <button type="button" data-bs-toggle="modal" data-bs-target="#sharePostModal" class="btn text-light" style="background-color: maroon;">SHARE</button>
                </div>
                </div>
                </div>
                </div>
                </div>
                </a>
                </div>
            ';
        }

        // Return the generated HTML as a response
        return response()->json(['html' => $html]);
    }
}
