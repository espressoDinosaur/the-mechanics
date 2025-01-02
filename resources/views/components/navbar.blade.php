@include('includes.head')

<nav class="navbar navbar-expand-lg fixed-top navbar-scroll">
    <div class="container">
        <img src=" {{ asset('assets/mechanics.png') }} " height="70" alt="" loading="lazy" />
        <div class="collapse navbar-collapse" id="navbarExample01">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item active m-2">
                    <a class="nav-link text-light" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item m-2">
                    <a class="nav-link text-light" aria-current="page" href="/posts">Posts</a>
                </li>
                <li class="nav-item m-2">
                    <a class="nav-link text-light" aria-current="page" href="/about">About</a>
                </li>
                <!-- <li class="nav-item m-2">
                    <a class="nav-link text-light" aria-current="page" href="/contact">Contact</a>
                </li> -->
                <!-- Check if logged in and admin or student -->
                @if (Auth::check() && Auth::user()->role == 1)
                <li class="nav-item m-2">
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addPostModal">Add Post</button>
                </li>
                @endif
                <!-- Decide whether the session is active -->
                @if (Auth::check())
                <li class="nav-item m-2">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-light">Logout</button>
                    </form>
                </li>
                @else
                <li class="nav-item m-2">
                    <a href="{{ route('login') }}"><button type="button" class="btn btn-light">Login</button></a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@if(session('success'))
<div class="alert alert-success" role="alert">
    <span>{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger" role="alert">
    <span>{{ session('error') }}</span>
</div>
@endif

<button id="scrollToTopBtn" class="scroll-to-top-btn rounded btn fw-semibold" onclick="scrollToTop()">
    Back to Top
</button>

<!-- ALL MODAL HERE -->
<!-- Not login modal -->
<div class="modal fade" id="notloginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h1 class="modal-title fs-5 fw-bold w-100" id="exampleModalLabel">
                    PLEASE <span style="color: maroon;">LOGIN FIRST</span>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('assets/close.png') }}" class="mb-3" height="50">
                <div class="h5 mb-3">Please login to add gear and<br>comment to a post!</div>
                <a href="/login" class="btn text-light" style="background-color: maroon;">Login</a>
            </div>
        </div>
    </div>
</div>

<!-- Add Post Modal -->
<div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="addPostForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-header text-center">
                    <h1 class="modal-title fs-5 fw-bold w-100" id="exampleModalLabel">
                        CREATE <span style="color: maroon;">POST</span>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body container">
                    <div class="row d-flex align-items-center mb-3">
                        <div class="col-2 text-end fw-semibold">Category</div>
                        <div class="col">
                            <input type="text" name="category" id="category" class="form-control" placeholder="eg. Sports" required>
                        </div>
                    </div>
                    <div class="row d-flex align-items-center mb-3">
                        <div class="col-2 text-end fw-semibold">Title</div>
                        <div class="col">
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <!-- Updated: Remove the 'required' attribute, TinyMCE will manage the content -->
                            <textarea class="form-control" name="content" id="content" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <!-- This is your image input field -->
                                <input class="form-control" name="image" type="file" id="formFile" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col" id="image-preview">
                            <!-- Image preview will appear here -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn text-light fw-medium" style="background-color: maroon;">Create Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
        // Add post request starts
        $('#addPostForm').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Trigger save to update the content from TinyMCE to the original textarea
            tinymce.triggerSave();

            // Manually validate content (check if content is empty)
            var content = $('#content').val();
            if (content.trim() === '') {
                alert('Content is required.');
                return; // Prevent form submission if content is empty
            }

            let formData = new FormData(this); // Collect all form data (including the image)

            $.ajax({
                url: "{{ route('create-post') }}", // Your route for storing posts
                type: "POST",
                data: formData,
                processData: false, // Required for file uploads
                contentType: false, // Required for file uploads
                success: function(response) {
                    // Handle success
                    $('#addPostModal').modal('hide'); // Hide the modal

                    const successAlert = document.createElement('div');
                    successAlert.classList.add('alert', 'alert-success');
                    successAlert.innerText = 'Post created successfully!';
                    document.body.appendChild(successAlert); // Append success alert to body

                    // Fade-out alert after 5 seconds
                    setTimeout(() => {
                        successAlert.classList.add('fade-out');
                        setTimeout(() => {
                            successAlert.remove(); // Remove the alert after fade-out
                        }, 1000); // Wait for fade-out animation to finish before removal
                    }, 5000); // 5 seconds

                    // Reload the page after post creation
                    location.reload();
                },
                error: function(xhr) {
                    // Handle errors
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = "Failed to create the post:\n";
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
        // Add post request ends
    });

    // Image Preview Starts
    document.getElementById('formFile').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('image-preview');
        previewContainer.innerHTML = '';

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Preview';
                img.classList.add('img-fluid');
                img.classList.add('rounded');
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        }
    });
    // Image Preview Ends

    // Scroll to top starts
    var scrollToTopBtn = document.getElementById("scrollToTopBtn");

    window.onscroll = function() {
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
            scrollToTopBtn.style.display = "block";
        } else {
            scrollToTopBtn.style.display = "none";
        }
    };

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    }
    // Scroll to top ends

    // Alert script starts
    // document.addEventListener('DOMContentLoaded', function() {
    //     const successAlert = document.querySelector('.alert-success');
    //     const errorAlert = document.querySelector('.alert-danger');

    //     if (successAlert) {
    //         setTimeout(() => {
    //             successAlert.classList.add('fade-out');
    //         }, 5000); // 5 seconds
    //     }

    //     if (errorAlert) {
    //         setTimeout(() => {
    //             errorAlert.classList.add('fade-out');
    //         }, 5000); // 5 seconds
    //     }
    // });
    // Alert script ends

    document.addEventListener('DOMContentLoaded', () => {
        const copyLinkButton = document.getElementById('copyLinkButton');

        copyLinkButton.addEventListener('click', () => {
            // Get the current page URL
            const pageUrl = window.location.href;

            // Copy the URL to the clipboard
            navigator.clipboard.writeText(pageUrl)
                .then(() => {
                    // Optional: Provide feedback to the user
                    alert('Link copied to clipboard!');
                })
                .catch(err => {
                    console.error('Failed to copy link: ', err);
                });
        });
    });
</script>

<style>
    .navbar-scroll .nav-link,
    .navbar-scroll .fa-bars,
    .navbar-scroll .navar-brand {
        color: #4f4f4f;
    }

    .navbar-scroll .nav-link:hover {
        color: #1266f1;
    }

    .navbar-scrolled .nav-link,
    .navbar-scrolled .fa-bars,
    .navbar-scrolled .navar-brand {
        color: #4f4f4f;
    }

    .navbar-scroll,
    .navbar-scrolled {
        background-color: maroon;
    }

    .navbar.navbar-scroll.navbar-scrolled {
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .scroll-to-top-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        color: maroon;
        border: 2px solid maroon;
        display: none;
        cursor: pointer;
        z-index: 9;
    }

    /* ALERT */
    .alert {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1050;
        transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
        transform: translateY(20px);
    }

    .alert.fade-out {
        opacity: 0;
        transform: translateY(100px);
        /* Moves the alert further down to disappear */
    }
</style>

<!-- Share Post Modal -->
<div class="modal fade" id="sharePostModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h1 class="modal-title fs-5 fw-bold w-100" id="exampleModalLabel">
                    SHARE <span style="color: maroon;">POST</span>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <p class="fw-semibold">Share to</p>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col">
                        <button type="button" class="btn btn-secondary" id="copyLinkButton">
                            <span><i class="bi bi-copy"></i></span>
                            <span><small>Copy Link</small></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>