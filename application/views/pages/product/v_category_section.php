<!-- Start Categories  -->

<div class="instagram-box mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-all text-center">
                    <h1 class="text-primary">Categories</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet lacus enim.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="main-instagram owl-carousel owl-theme">
        <?php
        foreach ($categories as $c) {
        ?>
            <div class="item">
                <div class="ins-inner-box">
                    <img src="<?= base_url() ?>assets/img/products/<?= $c->kategori_icon ?>" alt="" class="img-category" />

                    <div class="hov-in">
                        <a href="<?= base_url('product/category/' . $c->kategori_seo) ?>">
                            <?= $c->kategori_nama ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>