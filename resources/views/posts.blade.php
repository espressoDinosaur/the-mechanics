@include('includes.head')

<body>
    @include('components.navbar')
    <div style="padding-left: 400px; padding-right: 400px; margin-top:100px;">
        <div class="container p-3">
            <div class="row mb-4">
                <div class="col">
                    <form action="" method="post" class="row">
                        <div class="col">
                            <input class="form-control" type="text" name="search-item" id="search-item" placeholder="Search a post here...">
                        </div>
                        <div class="col-4">
                            <select class="form-select" id="categoryFilter" aria-label="Default select example">
                                <option selected>Filter by Category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Post Container: The filtered posts will be injected here -->
            <div id="postsContainer">
                @foreach ($posts as $post)
                <!-- This is the original post HTML -->
                <div class="row mb-3">
                    <a href="{{ route('posts.show', $post->id) }}">
                        <div class="card p-0" style="box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);">
                            <div class="card-body">
                                <div class="row d-flex align-items-center mb-3">
                                    <div class="col-1 p-1">
                                        <img src="{{ asset('assets/mechanics.png') }}" height="60" alt="" loading="lazy" />
                                    </div>
                                    <div class="col">
                                        <p class="fs-5 fw-semibold" style="margin-bottom: 0px;">{{ $post->user->name ?? 'Unknown Author' }}</p>
                                        <p>{{ $post->created_at->format('F j, Y \a\t g:i A') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="fw-bold h5">
                                        <span style="color: maroon;">{{ $post->category }}</span> |
                                        <span>{{ $post->title }}</span>
                                    </div>
                                    <p>{!! nl2br(substr($post->content, 0, 250)) !!}... <a style="color: maroon;" class="fw-medium" href="{{ route('posts.show', $post->id) }}">Read more</a></p>
                                </div>
                            </div>
                            <img src="{{ asset('storage/' . $post->image) }}" class="card-img" alt="..." style="margin-top: -15px;">
                            <div class="row ps-3 px-3 pt-2 pb-2">
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
                                    <a href=""><span><small>{{ $post->comments()->count() }} Comments</small></span></a>
                                </div>
                            </div>
                            <div class="card-footer p-0">
                                <div class="container-fluid border">
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
                                            <a href="{{ route('posts.show', $post->id) }}" class="btn text-light" style="background-color: maroon;">COMMENT</a>
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
                @endforeach
            </div>
        </div>
    </div>

    @include('components.footer')
</body>

<script>
    $(document).ready(function() {
        // Handle search and filter changes
        $('#search-item, #categoryFilter').on('input change', function() {
            const searchItem = $('#search-item').val();
            const category = $('#categoryFilter').val();

            $.ajax({
                url: "{{ route('posts.filter') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    search_item: searchItem,
                    category: category
                },
                success: function(response) {
                    $('#postsContainer').html(response.html); // Replace the posts container with new HTML
                },
                error: function(error) {
                    alert('Something went wrong while filtering posts.');
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