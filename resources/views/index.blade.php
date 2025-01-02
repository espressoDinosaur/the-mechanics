<?php

use Illuminate\Support\Facades\Auth;
?>

@include('includes.head')

<body>
    @include('components.navbar')
    <!-- Shows if the session is active -->
    @if (Auth::check())
    <div class="container-fluid p-3 text-end" style="margin-top: 85px; background-color: #F3B218">
        <div class="container">
            <span class="fw-bold fs-5">Welcome, {{ auth()->user()->name }}!</span>
        </div>
    </div>
    @endif
    <div class="container-fluid">
        <div class="row p-0">
            <img src=" {{ asset('assets/themechbg.jpg') }} " alt="" class=" img-fluid">
        </div>
    </div>
    <div class="container">
        <div class="row mt-3">
            <h1 class="head text-center fw-bold mb-3">
                <span style="color: maroon">DISCOVER </span>
                <span>ENGINEERING</span>
            </h1>
        </div>
        <div class="row d-flex justify-content-center whats-new">
            @foreach($randomPosts as $post)
            <div class="col">
                <a href=" {{ route('posts.show', $post->id) }} ">
                    <div class="card">
                        <img src=" {{ asset('storage/' . $post->image) }} " class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="mb-3 fw-bold    ">
                                <span style="color: maroon;">{{ $post->category }} | </span>
                                <span>{{ $post->title }}</span>
                            </div>
                            <small>
                                <p>{{ $post->created_at->format('F j, Y \a\t g:i A') }}</p>
                            </small>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="row mt-5">
            <div class="col">
                <h3 class="head fw-bold mb-3">
                    <span style="color: maroon">LATEST</span>
                    <span>NEWS</span>
                </h3>
                <div class="container">
                    @foreach($posts->take(3) as $post)
                    <div class="row mb-3">
                        <div class="card p-0">
                            <img src=" {{ asset('storage/' . $post->image) }} " class="card-img-top" alt="...">
                            <div class="card-body">
                                <div class="text-center fw-bold mb-2">
                                    <span style="color: maroon;">{{ $post->category }}</span> |
                                    <span style="color: maroon;">{{ $post->user->name ?? 'Unknown Author' }}</span>
                                </div>
                                <h5 class="fw-bold text-center">
                                    {{ $post->title }}
                                </h5>
                                <p>{!! nl2br(substr($post->content, 0, 250)) !!}...</p>
                                <a href=" {{ route('posts.show', $post->id) }} " class="btn text-light" style="text-decoration: none; background-color: maroon">Keep Reading</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="row text-center">
                        <a href="/posts" class="btn text-light fw-medium" style="background-color: maroon;">VIEW ALL POSTS</a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <h3 class="head fw-bold mt-3">
                    <span style="color: maroon">FREQUENTLY ASK</span>
                    <span>QUESTIONS</span>
                </h3>
                <div class="div">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    How to be a member of The Mechanics?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col fw-bold text-center">
                                            <img src=" {{ asset('assets/themechmembers.jpg') }} " alt="" class=" img-fluid rounded mb-3">
                                            <p style="color: maroon;">Want to be part of a vibrant community of passionate journalist? Join Mechanics Now!</p>
                                        </div>
                                    </div>
                                    <form action="" method="post">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="floatingInput" placeholder="Ex: Juan Dela Cruz">
                                                    <label for="floatingInput">Complete Name</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <input type="email" class="form-control" id="floatingInput" placeholder="Ex: email@example.com">
                                                    <label for="floatingInput">Email Address</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-floating mb-3">
                                                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                                        <option selected>Please select</option>
                                                        <option value="Bachelor of Science in Agricultural and Biosystems Engineering">Bachelor of Science in Agricultural and Biosystems Engineering (BSABE)</option>
                                                        <option value="Bachelor of Science in Civil Engineering">Bachelor of Science in Civil Engineering (BSCE)</option>
                                                        <option value="Bachelor of Science in Information Technology (BSIT)">Bachelor of Science in Information Technology (BSIT)</option>
                                                    </select>
                                                    <label for="floatingSelect">Program</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col">
                                                <div class="form-floating">
                                                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                                        <option selected>Please select</option>
                                                        <option value="1">1st Year</option>
                                                        <option value="2">2nd Year</option>
                                                        <option value="3">3rd Year</option>
                                                        <option value="4">4th Year</option>
                                                        <option value="5">5th Year</option>
                                                        <option value="6">6th Year</option>
                                                    </select>
                                                    <label for="floatingSelect">Year</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-floating">
                                                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                                        <option selected>Please select</option>
                                                        <option value="1">Block 1</option>
                                                        <option value="2">Block 2</option>
                                                        <option value="3">Block 3</option>
                                                        <option value="4">Block 4</option>
                                                        <option value="5">Block 5</option>
                                                        <option value="6">Block 6</option>
                                                        <option value="7">Block 7</option>
                                                    </select>
                                                    <label for="floatingSelect">Block</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="d-flex justify-content-center">
                                                    <button type="submit" class="btn text-light fw-bold" style="background-color: maroon;">SUBMIT APPLICATION</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    What is the purpose of The Mechanics?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>The Mechanics serves as an official student publication of the College of Engineering. Its primary purpose is to:</p>
                                    <ol>
                                        <li><strong>Inform and Educate:</strong> To provide students with relevant news, articles, and features about engineering topics, current events, and industry trends.</li>
                                        <li><strong>Inspire and Motivate:</strong> To inspire future engineers by showcasing the achievements of students, faculty, and alumni, as well as highlighting the innovative work being done in the field.</li>
                                        <li><strong>Foster Community:</strong> To create a sense of community among engineering students by providing a platform for them to share their ideas, experiences, and perspectives.</li>
                                        <li><strong>Showcase Talent:</strong> To showcase the creative and technical skills of engineering students through articles, artwork, and design.</li>
                                        <li><strong>Promote Engineering:</strong> To promote the field of engineering and encourage students to pursue careers in this exciting and dynamic field.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    How much time commitment is required to be a member of The Mechanics?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>The time commitment required to be a member of The Mechanics can vary depending on the specific role and responsibilities you take on. However, generally speaking, being a member requires a moderate level of dedication.</p>
                                    <ul>
                                        <li>
                                            <strong>Writers and Editors:</strong>
                                            <ul>
                                                <li>Regular article submission</li>
                                                <li>Editing and proofreading</li>
                                                <li>Attending editorial meetings</li>
                                            </ul>
                                        </li>
                                        <li>
                                            <strong>Designers and Artists:</strong>
                                            <ul>
                                                <li>Creating visual content for articles and features</li>
                                                <li>Designing layouts for the publication</li>
                                                <li>Attending editorial meetings</li>
                                            </ul>
                                        </li>
                                        <li>
                                            <strong>Social Media Managers:</strong>
                                            <ul>
                                                <li>Creating and scheduling social media posts</li>
                                                <li>Engaging with the audience</li>
                                                <li>Monitoring analytics</li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h3 class="head fw-bold mt-3">
                    <span style="color: maroon">THE MECHANICS</span>
                    <span>GALLERY</span>
                </h3>
                <div class="container-fluid">
                    <div class="row mb-3">
                        <div class="col">
                            <img src=" {{ asset('assets/mech1.jpg') }} " alt="" class="img-fluid rounded">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <img src=" {{ asset('assets/mech2.jpg') }} " alt="" class="img-fluid rounded">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <img src=" {{ asset('assets/mech3.jpg') }} " alt="" class="img-fluid rounded">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <img src=" {{ asset('assets/mech4.jpg') }} " alt="" class="img-fluid rounded">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.footer')
</body>

<style>
    .whats-new .card-img-top,
    .discover-img {
        width: 100%;
        aspect-ratio: 1 / 1;
        object-fit: cover;
    }
</style>