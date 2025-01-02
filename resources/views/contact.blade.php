@include('includes.head')

<body>
    @include('components.navbar')
    <div class="container" style="margin-top: 85px;">
        <div class="row pt-5">
            <h3 class="head text-start fw-bold mb-3">
                <span style="color: maroon">CONTACT THE</span>
                <span>MECHANICS</span>
            </h3>
            <form action="" method="post">
                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Ex: Juan Dela Cruz">
                            <label for="floatingInput">Complete Name</label>
                        </div>
                    </div>
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
                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                            <label for="floatingTextarea2">Comments/Suggestions/Recommendations</label>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn text-light fw-bold p-3" style="background-color: maroon;">SUBMIT MESSAGE</button>
                </div>
            </form>
        </div>
        <div class="row pt-5">
            <h3 class="head text-start fw-bold mb-3">
                <span style="color: maroon">BE A MECHANICS,</span>
                <span>JOIN US NOW</span>
            </h3>
            <!-- <img src=" {{ asset('assets/themechmembers_cropped.jpg') }} " alt="" class="img-fluid rounded mb-3"> -->
            <form action="" method="post">
                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" placeholder="Ex: Juan Dela Cruz">
                            <label for="floatingInput">Complete Name</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" placeholder="Ex: email@example.com">
                            <label for="floatingInput">Email Address</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                <option selected>Please select</option>
                                <option value="Bachelor of Science in Agricultural and Biosystems Engineering">Bachelor of Science in Agricultural and Biosystems Engineering (BSABE)</option>
                                <option value="Bachelor of Science in Civil Engineering">Bachelor of Science in Civil Engineering (BSCE)</option>
                                <option value="Bachelor of Science in Information Technology (BSIT)">Bachelor of Science in Information Technology (BSIT)</option>
                            </select>
                            <label for="floatingSelect">Program</label>
                        </div>
                    </div>
                    <div class="col mb-3">
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
                    <div class="col mb-3">
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
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn text-light fw-bold p-3" style="background-color: maroon;">SUBMIT APPLICATION</button>
                </div>
            </form>
        </div>
    </div>
    @include('components.footer')
</body>