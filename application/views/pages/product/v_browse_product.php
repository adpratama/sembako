<!-- Start All Title Box -->
<div class="all-title-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Shop</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End All Title Box -->

<div class="flash-data" data-flashdata="<?= $this->session->flashdata('message_name') ?>"></div>

<!-- Start Shop Page  -->
<div class="shop-box-inner">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-sm-6 col-xs-6 shop-content-right">
                <div class="right-product-box">
                    <div class="product-item-filter row">
                        <div class="col-lg-8"></div>
                        <div class="col-lg-4 col-sm-6 text-right align-items-end">
                            <div class="toolbar-sorter-right">
                                <form action="#">
                                    <input class="form-control" placeholder="Search here..." type="text">
                                    <!-- <button type="submit"> <i class="fa fa-search"></i> </button> -->
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- List Product -->
                    <div class="product-categorie-box">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade show active" id="grid-view">
                                <div class="row">
                                    <?php
                                    foreach ($products as $b) {

                                        $stok = $b->menu_stok - $b->menu_jual;
                                    ?>
                                        <div class="col-sm-3 col-md-3 col-lg-2 col-xl-2">
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
                                            ?>
                                            <div class="products-single fix">
                                                <div class="box-img-hover">
                                                    <div class="type-lb">
                                                        <p class="sale">Rp<?= number_format($b->menu_harga) ?></p>
                                                    </div>
                                                    <img src="<?= base_url() ?>assets/img/products/<?= $menu_foto ?>" class="img-fluid" alt="Image">
                                                    <div class="mask-icon">
                                                        <ul>
                                                            <li>
                                                                <a href="<?= base_url('product/show/' . $b->menu_seo) ?>" data-toggle="tooltip" data-placement="right" title="View">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <button class="cart" id=""> Add to Cart</button>
                                                        ?>
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
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-sm-6 col-xs-6 text-center">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item">
                            <a class="page-link pagination-button" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link pagination-button" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- End Shop Page -->