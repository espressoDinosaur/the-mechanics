@include('includes.head')

<body>
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <!-- Right Container: Form Section -->
            <div class="col" id="entry_container">
                <div class="container p-5">
                    <div class="h3 mb-4 fw-bold" style="color: #800000">THE MECHANICS</div>
                    <!-- Navigation -->
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active fw-semibold" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                                <span style="color: #800000;">LOGIN</span>
                            </button>
                            <button class="nav-link fw-semibold" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                                <span style="color: #800000;">CREATE NEW ACCOUNT</span>
                            </button>
                        </div>
                    </nav>
                    <!-- Tab Content -->
                    <div class="tab-content" id="nav-tabContent">
                        <!-- Login Tab -->
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
                            <div class="h1 mt-4 fw-bolder" style="color: #800000">Login to your account</div>
                            <p class="text-secondary">Please enter your login details to access your account.</p>
                            <form action=" {{ route('login.perform') }} " method="post">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input type="email" name="email" class="form-control" id="floatingInput email" placeholder="Email Address" required>
                                    <label for="floatingInput">Email Address</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" name="password" class="form-control" id="floatingPassword password" placeholder="Password" required>
                                    <label for="floatingPassword">Password</label>
                                </div>
                                <input type="submit" name="login_account" value="LOGIN" class="btn mb-3 mt-3" id="create_btn" style="background-color: #800000; color:white;">
                                <hr>
                                <div class="row text-center">
                                    <small>
                                        <p>or continue with</p>
                                    </small>
                                    <div class="row">
                                        <!-- Google Login -->
                                        <a class="col btn api-btn mx-3" href="{{ route('login.google') }}">
                                            <img src=" {{ asset('assets/google.png') }} " alt="Google" style="width: 30px; height: 30px;">
                                            <small class="ms-2">Google</small>
                                        </a>

                                        <!-- Facebook Login -->
                                        <a class="col btn api-btn ms-3" href="{{ route('login.facebook') }}">
                                            <img src=" {{ asset('assets/facebook.png') }} " alt="Facebook" style="width: 30px; height: 30px;">
                                            <small class="ms-2">Facebook</small>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- Create Account Tab -->
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">
                            <div class="h1 mt-4 fw-bolder" style="color: #800000">Create your new account</div>
                            <p class="text-secondary">Please fill out the following to create a new account.</p>
                            <form action="{{ route('register.perform') }}" method="post">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input type="text" name="name" class="form-control" id="floatingInputName" placeholder="Name" required>
                                    <label for="floatingInputName">Complete Name</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="email" name="email" class="form-control" id="floatingInputEmail" placeholder="Email Address" required>
                                    <label for="floatingInputEmail">Email Address</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                                    <label for="floatingPassword">Password</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" name="password_confirmation" class="form-control" id="floatingConfirmPassword" placeholder="Confirm Password" required>
                                    <label for="floatingConfirmPassword">Confirm Password</label>
                                </div>
                                <input type="submit" value="CREATE AN ACCOUNT" class="btn" id="create_btn" style="background-color: #800000; color:white;">
                                <hr>
                                <div class="row text-center">
                                    <small>
                                        <p>or continue with</p>
                                    </small>
                                    <div class="row">
                                        <!-- Google Login -->
                                        <a class="col btn api-btn mx-3" href="{{ route('login.google') }}">
                                            <img src="{{ asset('assets/google.png') }}" alt="Google" style="width: 30px; height: 30px;">
                                            <small class="ms-2">Google</small>
                                        </a>
                                        <!-- Facebook Login -->
                                        <a class="col btn api-btn ms-3" href="{{ route('login.facebook') }}">
                                            <img src="{{ asset('assets/facebook.png') }}" alt="Facebook" style="width: 30px; height: 30px;">
                                            <small class="ms-2">Facebook</small>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Left Container: Logo Section -->
            <div class="col d-flex justify-content-center align-items-center" id="left-logo-container" style="background: linear-gradient(155deg, #800000 19.48%, #1A0000 100%);">
                <img src=" {{ asset('assets/mechanics.png') }} " alt="The Mechanics Logo" class="img-fluid" style="width: 500px;">
            </div>
        </div>
    </div>
</body>