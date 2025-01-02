@include('includes.head')

<body>
    @include('components.navbar')
    <div class="container" style="margin-top: 85px;">
        <div class="row pt-5">
            <h3 class="head text-start fw-bold mb-3">
                <span style="color: maroon">ABOUT THE </span>
                <span>MECHANICS</span>
            </h3>
        </div>
        <img src=" {{ asset('assets/themechmembers_cropped.jpg') }} " alt="The Mechanics" class="img-fluid mb-3">
        <div class="row mb-3">
            <h3 class="head text-center fw-bold mb-3">
                <span style="color: maroon">OUR </span>
                <span>VISION</span>
            </h3>
            <p class="text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi porro cumque accusamus quidem esse, in aspernatur veniam, nulla quis, vitae officia eos eum eligendi ab unde. Et modi corrupti exercitationem architecto maxime repudiandae rerum ea iure dolorum reiciendis. Eveniet numquam ab fuga facilis nostrum consequuntur rerum a hic ea labore enim atque repudiandae fugiat vitae, minima voluptas velit doloremque quam earum sed, temporibus ut? Quos eos, ipsam doloremque iure soluta temporibus, id quo alias delectus, ipsum a vero ipsa error expedita sunt? Aspernatur, magnam voluptas laudantium repellendus molestias, odio illum culpa ducimus eveniet maxime esse commodi ad harum? Quam, facilis?</p>
        </div>
        <div class="row mb-3">
            <h3 class="head text-center fw-bold mb-3">
                <span style="color: maroon">OUR </span>
                <span>MISSION</span>
            </h3>
            <p class="text-center">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam repellendus ipsum sed id perspiciatis quasi eius, voluptatum hic totam qui blanditiis minima dolor ea architecto sunt consequatur facere eveniet cumque aliquam numquam saepe minus cum fuga. Vitae earum excepturi sequi ex doloremque aperiam debitis sit dolorum explicabo dolores voluptates, rerum quam nulla fuga impedit suscipit fugit perspiciatis inventore repellendus deleniti eligendi veniam vero? Laborum vel dicta nisi nostrum aliquam. Natus ipsam totam facere optio quidem laboriosam voluptatum tempore nobis mollitia, velit eveniet nemo, ipsa impedit laborum aliquid architecto exercitationem quae deleniti facilis corporis doloremque corrupti modi doloribus. Labore, minus animi.
            </p>
        </div>
    </div>
    @include('components.footer')
</body>