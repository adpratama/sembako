<!-- Start All Title Box -->
<div class="all-title-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Shop Detail</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    <li class="breadcrumb-item active">Shop Detail </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End All Title Box -->

<!-- Start Shop Detail  -->
<div class="shop-detail-box-main">
    <div class="container">
        <div class="row">
            <?php
            if (empty($product_detail["menu_foto"])) {
                $menu_foto = "no-image-icon.jpg";
            } else {
                $menu_foto = "products/" . $product_detail['menu_foto'];
            }
            ?>
            <div class="col-xl-5 col-lg-5 col-md-6">
                <div id="carousel-example-1" class="single-product-slider " data-ride="carousel">
                    <img class="d-block w-100 img-fluid" src="<?= base_url() ?>assets/img/<?= $menu_foto ?>" alt="" />
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 col-md-6">
                <div class="single-product-details">
                    <?php

                    echo form_open('order/add');
                    echo form_hidden('id', $product_detail['menu_id']);
                    // echo form_hidden('qty', 1);
                    echo form_hidden('price', $product_detail['menu_harga']);
                    echo form_hidden('name', $product_detail['menu_nama']);
                    echo form_hidden('redirect_page', str_replace('index.php/', '', current_url())); ?>
                    <h2><?= $product_detail['menu_nama'] ?></h2>
                    <h5> Rp<?= number_format($product_detail['menu_harga'], 2, ',', '.') ?></h5>
                    <p class="available-stock"><span> Stok <?= $product_detail["menu_stok"] ?> / <a href="#">Terjual <?= $product_detail["menu_jual"] ?> </a></span>
                    <p>
                    <h4>Short Description:</h4>
                    <p><?= $product_detail['menu_deskripsi'] ?> </p>
                    <ul>
                        <li>
                            <div class="form-group quantity-box">
                                <label class="control-label">Quantity</label>
                                <input type="number" name="qty" placeholder="0" min="0" max="<?= $product_detail['menu_stok'] ?>" value="" required>
                            </div>
                        </li>
                    </ul>

                    <div class="price-box-bar">
                        <div class="cart-and-bay-btn">
                            <?php
                            if ($product_detail["menu_stok"] < 1) {
                            ?>
                                <a href="#" class="btn-cart">Stok habis</a>
                            <?php
                            } else {
                            ?>
                                <button class="cart" id="" type="submit">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart</button>
                            <?php
                            } ?>
                            <!-- <button class="cart" id="" type="submit"><i class="fas fa-shopping-cart"></i> Add to Cart</button> -->
                        </div>
                    </div>
                    <?php
                    echo form_close(); ?>
                </div>
            </div>
        </div>

        <!-- Related Producst -->
        <?php if (isset($related_product)) $this->load->view($related_product); ?>

    </div>
</div>
<!-- End Cart -->