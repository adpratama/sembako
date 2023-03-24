	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
	    <div class="container">
	        <div class="row">
	            <div class="col-lg-8 offset-lg-2 text-center">
	                <div class="breadcrumb-text">
	                    <p>See more Details</p>
	                    <h1><?= $product_detail['menu_nama'] ?></h1>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- end breadcrumb section -->

	<!-- single product -->
	<div class="single-product mt-150 mb-150">
	    <div class="container">
	        <div class="row">
	            <div class="col-md-5">
	                <div class="single-product-img">
	                    <img src="<?= base_url() ?>assets/img/menu_folder/<?= $product_detail['menu_foto'] ?>" alt="">
	                </div>
	            </div>
	            <div class="col-md-7">
	                <div class="single-product-content">
	                    <h3><?= $product_detail['menu_nama'] ?></h3>
	                    <p class="single-product-pricing"><span>Per Item</span> Rp<?= number_format($product_detail['menu_harga'], 2, ',', '.') ?></p>
	                    <p><?= $product_detail['menu_deskripsi'] ?></p>
	                    <div class="single-product-form">
	                        <?php

                            echo form_open('order/add');
                            echo form_hidden('id', $product_detail['menu_id']);
                            // echo form_hidden('qty', 1);
                            echo form_hidden('price', $product_detail['menu_harga']);
                            echo form_hidden('name', $product_detail['menu_nama']);
                            echo form_hidden('redirect_page', str_replace('index.php/', '', current_url())); ?>
	                        <input type="number" name="qty" placeholder="0" min="1" required>
	                        <p><strong>Categories: </strong><?= $product_detail['kategori_nama'] ?></p>
	                        <!-- <a href="cart.html" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</a> -->
                            <button type="submit" class="btn btn-primary"><i class="fas fa-shopping-cart"></i>Add to Cart</button>

	                        <?php
                            echo form_close(); ?>
	                    </div>
	                    <h4>Share:</h4>
	                    <ul class="product-share">
	                        <li><a href=""><i class="fab fa-facebook-f"></i></a></li>
	                        <li><a href=""><i class="fab fa-twitter"></i></a></li>
	                        <li><a href=""><i class="fab fa-google-plus-g"></i></a></li>
	                        <li><a href=""><i class="fab fa-linkedin"></i></a></li>
	                    </ul>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- end single product -->

    <!-- product section -->
    <div class="product-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">Best</span> Seller</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, fuga quas itaque eveniet beatae optio.</p>
                    </div>
                </div>
            </div>

            <div class="row">


                <?php
                foreach ($best as $b) {

                ?>
                    <div class="col-lg-4 col-md-6 text-center">
                        <?php

                        echo form_open('order/add');
                        echo form_hidden('id', $b->menu_id);
                        echo form_hidden('qty', 1);
                        echo form_hidden('price', $b->menu_harga);
                        echo form_hidden('name', $b->menu_nama);
                        echo form_hidden('redirect_page', str_replace('index.php/', '', current_url())); ?>
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="product/show/<?=$b->menu_seo?>"><img src="<?= base_url(); ?>assets/img/menu_folder/<?= $b->menu_foto ?>" alt=""></a>
                            </div>
                            <h3><?= $b->menu_nama ?></h3>
                            <p class="product-price"><span>Per Kg</span> Rp<?= number_format($b->menu_harga, 2, ',', '.') ?> </p>
                            <button class="btn btn-primary toastrDefaultSuccess" id=""><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                        </div>

                        <?php
                        echo form_close(); ?>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-6 offset-md-3 offset-lg-0 text-center">
                    <a href="<?= base_url('product');?>" class="cart-btn"><i class="fas fa-shopping-cart"></i>Browse Other Menus...</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end product section -->