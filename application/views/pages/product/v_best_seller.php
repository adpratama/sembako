<!-- Start Products  -->
<div class="products-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title-all text-center">
                    <h1>Best Seller</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet lacus enim.</p>
                </div>
            </div>
        </div>
        <div class="featured-products-box owl-carousel owl-theme">
            <?php
            foreach ($best as $b) {
            ?>
                <div class="item">
                    <?php

                    echo form_open('order/add');
                    echo form_hidden('id', $b->menu_id);
                    echo form_hidden('qty', 1);
                    echo form_hidden('price', $b->menu_harga);
                    echo form_hidden('name', $b->menu_nama);
                    echo form_hidden('redirect_page', str_replace('index.php/', '', current_url()));

                    if (empty($b->menu_foto)) {
                        $menu_foto = "no-image-icon.jpg";
                    } else {
                        $menu_foto = $b->menu_foto;
                    }

                    $stok = $b->menu_stok - $b->menu_jual;
                    ?>
                    <div class="products-single fix">
                        <div class="box-img-hover">
                            <div class="type-lb">
                                <p class="sale">Rp<?= number_format($b->menu_harga) ?></p>
                            </div>
                            <img src="<?= base_url() ?>/assets/img/products/<?= $menu_foto ?>" class="img-fluid" alt="Image">
                            <div class="mask-icon">
                                <ul>
                                    <li><a href="#" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                    <li><a href="#" data-toggle="tooltip" data-placement="right" title="Compare"><i class="fas fa-sync-alt"></i></a></li>
                                    <li><a href="#" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                </ul>
                                <button class="cart" id=""> Add to Cart</button>
                            </div>
                        </div>
                        <div class="why-text">
                            <a href="<?= base_url('product/show/' . $b->menu_seo) ?>">
                                <h4><?= $b->menu_nama ?></h4>
                            </a>
                        </div>
                    </div>

                    <?php
                    echo form_close(); ?>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!-- End Products  -->