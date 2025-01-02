@include('includes.head')

<body>
    @include('components.navbar')
    <div class="container pt-4" style="margin-top: 85px;">
        <div class="card border-0 p-0">
            <!-- POST HEAD -->
            <div class="row d-flex align-items-center">
                <div class="col">
                    <div class="h4 fw-bold">{{ $post->category }}</div>
                    <div class="h1 fw-bold" style="color: maroon;">{{ $post->title }}</div>
                </div>
                <div class="col-2">
                    @if (Auth::check() && Auth::user()->role == 1)
                    <div class="col text-end">
                        <button type="button" class="btn text-warning" data-bs-toggle="modal" data-bs-target="#updatePostModal">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-pencil-fill"></i>
                                <small><span>Edit</span></small>
                            </div>
                        </button>
                        <button type="button" class="btn text-danger" data-bs-toggle="modal" data-bs-target="#deletePostModal">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-trash-fill"></i>
                                <small><span>Delete</span></small>
                            </div>
                        </button>
                    </div>
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <div class="col fs-6">
                    <span style="color: maroon;"><i class="bi bi-vector-pen"></i></span> |
                    <span class="fw-medium" style="color: maroon;">{{ $post->user->name ?? 'Unknown Author' }}</span>
                </div>
                <div class="col text-end">
                    <span class="fw-medium" style="color: #b5b5b5">{{ $post->created_at->format('F j, Y \a\t g:i A') }}</span><br>
                </div>
            </div>
            <!-- POST IMAGE -->
            <div class="row mb-3">
                <div class="col">
                    <img src=" {{ asset('storage/' . $post->image) }} " alt="" class=" img-fluid w-100">
                </div>
            </div>
            <!-- GEAR AND COMMENT INFO -->
            <div class="row ps-3 px-3">
                <div class="col">
                    <a href="#" id="gear-info-{{ $post->id }}" data-post-id="{{ $post->id }}">
                        <span style="color: maroon;"><i class="bi bi-gear-fill"></i></span>
                        <span>
                            <small>
                                @if ($post->randomUser)
                                {{ $post->randomUser->name }} and {{ $post->othersCount }} others
                                @else
                                No one has geared this post yet.
                                @endif
                            </small>
                        </span>
                    </a>
                </div>
                <div class="col text-end">
                    <span><small>{{ $post->comments()->count() }} Comments</small></span>
                </div>
            </div>
            <hr>
            <!-- GEAR AND SHARE -->
            <div class="row">
                <div class="col btn fw-semibold">
                    @if (Auth::check())
                    <button
                        class="btn text-light gear-button"
                        style="background-color: maroon;"
                        data-post-id="{{ $post->id }}"
                        id="gear-button-{{ $post->id }}">
                        @if(!$post->gears->contains(auth()->user()))
                        Gear
                        @else
                        Geared
                        @endif
                    </button>
                    @else
                    <button
                        type="button"
                        class="btn text-light"
                        style="background-color: maroon;"
                        data-bs-toggle="modal"
                        data-bs-target="#notloginModal">
                        Gear
                    </button>
                    @endif
                </div>
                <div class="col btn fw-semibold">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#sharePostModal" class="btn text-light" style="background-color: maroon;">SHARE</button>
                </div>
            </div>
            <hr>
            <!-- POSTS CONTENT -->
            <div class="row ms-5 mx-5">
                <div class="col ms-5 mx-5">
                    <p class="ms-5 mx-5">{!! nl2br($post->content) !!}</p>
                </div>
            </div>
            <!-- POST COMMENTS -->
            <div class="row">
                <div class="col">
                    <h3 class="head fw-bold mb-3">
                        <span style="color: maroon">POST'S</span>
                        <span>COMMENTS</span>
                    </h3>
                </div>
            </div>
            @foreach ($post->comments as $comment)
            <div class="row ms-5">
                <div class="col">
                    <div class="card border-0">
                        <div class="d-flex">
                            <img src="{{ Auth::user()->avatar ?? asset('assets/default-image.jpg') }}" height="60" alt="" loading="lazy" class="me-3" />
                            <div>
                                <span class="fw-semibold">{{ $comment->user->name }}</span> <br>
                                <span><small>{{ $comment->created_at->format('F j, Y \a\t g:i A') }}</small></span>
                                <p>{{ $comment->comment }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- POST COMMENTS FORM -->
            @if (Auth::check())
            <div class="row ms-5">
                <div class="col d-flex">
                    <form class="d-flex w-100" id="comment-form">
                        <!-- action="{{ route('post.comment', $post->id) }}" method="POST"  -->
                        @csrf
                        <input type="hidden" id="post-id" value="{{ $post->id }}">
                        <input type="text" name="comment" id="comment" class="form-control me-2" placeholder="Write your comment...">
                        <input type="submit" value="Comment" class="btn text-light" style="background-color: maroon;">
                    </form>
                </div>
            </div>
            @else
            <div class="row ms-5">
                <div class="col d-flex w-100">
                    <input type="text" name="comment" id="comment" class="form-control me-2" placeholder="Please login first to add comment." disabled>
                    <a href="{{ route('login') }}" class="btn text-light" style="background-color: maroon;">Login</a>
                </div>
            </div>
            @endif
        </div>
    </div>
    @include('components.footer')
</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        tinymce.init({
            selector: '#content', // Target the textarea with id="content"
            height: 300, // Adjust the editor height
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | \
              alignleft aligncenter alignright alignjustify | \
              bullist numlist outdent indent | removeformat | help',
            branding: false // Removes TinyMCE branding from the editor
        });
    });

    $(document).ready(function() {
        // Update post request starts
        $('#updatePostForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Trigger save to update the content from TinyMCE to the original textarea
            tinymce.triggerSave();

            let formData = new FormData(this); // Collect all form data including file

            $.ajax({
                url: "{{ route('posts.update', $post->id) }}", // Your route for updating the post
                type: "POST",
                data: formData,
                processData: false, // Required for file uploads
                contentType: false, // Required for file uploads
                success: function(response) {
                    // Handle success
                    const successAlert = document.createElement('div');
                    successAlert.classList.add('alert', 'alert-success');
                    successAlert.innerText = response.message; // Success message from server
                    document.body.appendChild(successAlert); // Append success alert to body

                    // Fade-out alert after 5 seconds
                    setTimeout(() => {
                        successAlert.classList.add('fade-out');
                        setTimeout(() => {
                            successAlert.remove(); // Remove the alert after fade-out
                        }, 1000); // Wait for fade-out animation to finish before removal
                    }, 5000); // 5 seconds

                    // Reload the page to reflect updated post data
                    window.location.reload(); // This will reload the page and reflect the changes
                },
                error: function(xhr) {
                    // Handle errors
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = "Failed to update the post:\n";
                    for (let error in errors) {
                        errorMessage += errors[error][0] + "\n";
                    }

                    const errorAlert = document.createElement('div');
                    errorAlert.classList.add('alert', 'alert-danger');
                    errorAlert.innerText = errorMessage;
                    document.body.appendChild(errorAlert); // Append error alert to body

                    // Fade-out alert after 5 seconds
                    setTimeout(() => {
                        errorAlert.classList.add('fade-out');
                        setTimeout(() => {
                            errorAlert.remove(); // Remove the alert after fade-out
                        }, 1000); // Wait for fade-out animation to finish before removal
                    }, 5000); // 5 seconds
                }
            });
        });
        // Update post request ends

        // Delete post request starts
        $('#deletePostForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Get the form action URL (route for deleting the post)
            let deleteUrl = $(this).attr('action'); // Form action contains the delete URL

            $.ajax({
                url: deleteUrl, // Your route for deleting the post
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}", // CSRF token
                    _method: 'DELETE' // Use DELETE method since we're deleting a post
                },
                success: function(response) {
                    // Handle success
                    const successAlert = document.createElement('div');
                    successAlert.classList.add('alert', 'alert-success');
                    successAlert.innerText = response.message; // Success message from server
                    document.body.appendChild(successAlert); // Append success alert to body

                    // Fade-out alert after 5 seconds
                    setTimeout(() => {
                        successAlert.classList.add('fade-out');
                        setTimeout(() => {
                            successAlert.remove(); // Remove the alert after fade-out
                        }, 1000); // Wait for fade-out animation to finish before removal
                    }, 5000); // 5 seconds

                    // Close the modal after deletion
                    const deleteModal = new bootstrap.Modal(document.getElementById('deletePostModal'));
                    deleteModal.hide(); // Close the delete modal

                    // Optionally, remove the deleted post from the UI dynamically
                    $('#post-' + response.postId).remove(); // Remove post element by ID (use response.postId to identify)

                    // Redirect to the main page after deletion (optional)
                    window.location.href = "{{ route('posts.index') }}"; // Redirect to posts index page or any other page
                },
                error: function(xhr) {
                    // Handle errors
                    let errorMessage = "Failed to delete the post.";

                    // If the error has a message, append it
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    const errorAlert = document.createElement('div');
                    errorAlert.classList.add('alert', 'alert-danger');
                    errorAlert.innerText = errorMessage;
                    document.body.appendChild(errorAlert); // Append error alert to body

                    // Fade-out alert after 5 seconds
                    setTimeout(() => {
                        errorAlert.classList.add('fade-out');
                        setTimeout(() => {
                            errorAlert.remove(); // Remove the alert after fade-out
                        }, 1000); // Wait for fade-out animation to finish before removal
                    }, 5000); // 5 seconds
                }
            });
        });
        // Delete post request ends

        // Image preview for update post
        document.getElementById('updateformFile').addEventListener('change', function(event) {
            const previewContainer = document.getElementById('update-image-preview');
            const file = event.target.files[0]; // Get the selected file

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    let img = document.getElementById('currentImage');
                    if (!img) {
                        img = document.createElement('img');
                        img.id = 'currentImage';
                        img.className = 'img-fluid rounded';
                        img.style.width = '100%';
                        previewContainer.innerHTML = '';
                        previewContainer.appendChild(img);
                    }
                    img.src = e.target.result; // Set the src to the loaded file
                };

                reader.readAsDataURL(file); // Read the file as a Data URL
            }
        });

        $('#comment-form').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            let formData = new FormData(this); // Collect form data

            $.ajax({
                url: "{{ route('post.comment', $post->id) }}", // Route to store comment
                type: "POST",
                data: formData,
                processData: false, // Required for file uploads
                contentType: false, // Required for file uploads
                success: function(response) {
                    // Handle success (if needed)
                    const successAlert = document.createElement('div');
                    successAlert.classList.add('alert', 'alert-success');
                    successAlert.innerText = response.message; // Success message from server
                    document.body.appendChild(successAlert); // Append success alert to body

                    // Fade-out alert after 5 seconds
                    setTimeout(() => {
                        successAlert.classList.add('fade-out');
                        setTimeout(() => {
                            successAlert.remove(); // Remove the alert after fade-out
                        }, 1000); // Wait for fade-out animation to finish before removal
                    }, 5000); // 5 seconds

                    // Reload the page to reflect the new comment
                    window.location.reload(); // This will reload the page and reflect the new comment
                },
                error: function(xhr) {
                    // Handle errors (if needed)
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = "Failed to post the comment:\n";
                    for (let error in errors) {
                        errorMessage += errors[error][0] + "\n";
                    }

                    const errorAlert = document.createElement('div');
                    errorAlert.classList.add('alert', 'alert-danger');
                    errorAlert.innerText = errorMessage;
                    document.body.appendChild(errorAlert); // Append error alert to body

                    // Fade-out alert after 5 seconds
                    setTimeout(() => {
                        errorAlert.classList.add('fade-out');
                        setTimeout(() => {
                            errorAlert.remove(); // Remove the alert after fade-out
                        }, 1000); // Wait for fade-out animation to finish before removal
                    }, 5000); // 5 seconds
                }
            });
        });
    });

    $(document).on('click', '.gear-button', function(e) {
        e.preventDefault(); // Prevent default form submission

        var button = $(this);
        var postId = button.data('post-id'); // Get the post ID from the data attribute

        // Initially disable the button to prevent multiple clicks
        button.prop('disabled', true);

        // First, toggle the gear (gear/un-gear action)
        $.ajax({
            url: '/posts/' + postId + '/gear', // Send to the appropriate URL for toggling gear
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Include CSRF token for security
            },
            success: function(response) {
                // Once we get the response, re-enable the button
                button.prop('disabled', false);

                // Update the gear button text based on the response (whether geared or not)
                if (response.geared) {
                    button.text('Gear');
                } else {
                    button.text('Geared');
                }

                // Update the gear info display (user and count) by replacing only the gear info div
                var gearInfo = $('#gear-info-' + postId); // Get the gear info element

                // Replace the content of the gear info div with the updated data from the server
                if (response.randomUser && response.othersCount >= 0) {
                    gearInfo.html('<span style="color: maroon;"><i class="bi bi-gear-fill"></i></span><span><small> ' + response.randomUser + ' and ' + response.othersCount + ' others</small></span>');
                } else {
                    gearInfo.html('<span style="color: maroon;"><i class="bi bi-gear-fill"></i></span><span><small> No one has geared this post yet.</small></span>');
                }
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);

                // Re-enable the button if there was an error
                button.prop('disabled', false);
            }
        });
    });
</script>

<!-- UPDATE AND DELETE MODAL -->
<!-- Update Post Modal -->
<div class="modal fade" id="updatePostModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="updatePostForm" enctype="multipart/form-data">
                <!-- action=" {{ route('posts.update', $post->id) }} " method="post" -->
                @csrf
                @method('PUT')
                <div class="modal-header text-center">
                    <h1 class="modal-title fs-5 fw-bold w-100" id="exampleModalLabel">
                        UPDATE <span style="color: maroon;">POST</span>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body container">
                    <div class="row d-flex align-items-center mb-3">
                        <div class="col-2 fw-semibold text-end">Category</div>
                        <div class="col">
                            <input type="text" name="category" value="{{ $post->category }}" id="category" class="form-control" placeholder="eg. Sports" required>
                        </div>
                    </div>
                    <div class="row d-flex align-items-center mb-3">
                        <div class="col-2 fw-semibold text-end">Title</div>
                        <div class="col">
                            <input type="text" name="title" value="{{ $post->title }}" id="title" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <!-- <textarea class="form-control" name="content" id="content" placeholder="What's on your mind, Richard?" rows="10" required>{{ $post->content }}</textarea> -->
                            <textarea class="form-control" name="content" id="content" rows="5">{{ $post->content }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <input class="form-control" name="image" type="file" id="updateformFile">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col" id="update-image-preview">
                            @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Current Image" class="img-fluid rounded">
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn text-light fw-medium" style="background-color: maroon;" data-bs-dismiss="modal">Update Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Post Modal -->
<div class="modal fade" id="deletePostModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h1 class="modal-title fs-5 fw-bold w-100" id="exampleModalLabel">
                    DELETE <span style="color: maroon;">POST</span>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="row">
                    <div class="col">
                        <p class="fw-medium fs-5">Are you sure you want to delete this post?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCEL</button>
                <form id="deletePostForm" method="post">
                    <!-- action=" {{ route('posts.delete', $post->id) }} " -->
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">DELETE</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- UPDATE AND DELETE MODAL -->