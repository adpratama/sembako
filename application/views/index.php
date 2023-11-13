<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

    <!-- title -->
    <title><?= $title ?> - Bandes Rekayasa Digital</title>

    <?php if (isset($style)) $this->load->view($style); ?>

</head>

<body>

    <!-- Start Main Top -->
    <header class="main-header">
        <!-- Start Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-default bootsnav">
            <div class="container">
                <!-- Start Header Navigation -->
                <div class="navbar-header">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-menu" aria-controls="navbars-rs-food" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a class="navbar-brand" href="<?= base_url(); ?>">
                        <p class=" font-weight-bold">Bandes Rekayasa Digital</p>
                    </a>
                </div>
                <!-- End Header Navigation -->

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <ul class="nav navbar-nav ml-auto" data-in="fadeInDown" data-out="fadeOutUp">
                        <li class="nav-item 
                            <?php
                            if (!$this->uri->segment(1)) {
                                echo  'active';
                            } ?>">
                            <a class="nav-link" href="<?= base_url(); ?>">Beranda</a>
                        </li>
                        <li class="nav-item 
                            <?php
                            if ($this->uri->segment(1) == "product") {
                                echo  'active';
                            } ?>">
                            <a class="nav-link" href="<?= base_url('product'); ?>">Produk</a>
                        </li>
                        <li class="nav-item 
                            <?php
                            if ($this->uri->segment(1) == "about") {
                                echo  'active';
                            } ?>">
                            <a class="nav-link" href="<?= base_url('about'); ?>">Tentang Kami</a>
                        </li>
                        <?php
                        if (empty($this->session->userdata('username'))) {
                        ?>
                            <li class="nav-item">

                                <a href="<?= base_url('auth') ?>" class="nav-link">
                                    <i class="fa fa-user s_color"></i>
                                    <span>&nbsp;</span>
                                    Masuk
                                </a>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li class="dropdown">
                                <!-- <a href="<?= base_url('dashboard/dashboard') ?>" class="nav-link dropdown-toggle arrow" data-toggle="dropdown">
                                    <i class="fa fa-user s_color"></i>
                                    <span>&nbsp;</span>
                                    Hi, <?= $this->session->userdata('username'); ?>
                                </a> -->
                                <a href="#" class="nav-link" data-toggle="dropdown">
                                    <i class="fa fa-user"></i>
                                    <span>&nbsp;</span>
                                    Hi, <?= $this->session->userdata('username'); ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php
                                    if ($this->session->userdata('role_id') == '1') {
                                    ?>
                                        <li><a href="<?= base_url('dashboard/dashboard') ?>" target="_blank">Dashboard</a></li>
                                    <?php
                                    }
                                    ?>
                                    <li><a href="<?= base_url('profile') ?>">Akun Saya</a></li>
                                    <li><a href="<?= base_url('transaction') ?>">Riwayat Belanja</a></li>
                                    <li><a href="<?= base_url('auth/logout') ?>">Keluar</a></li>
                                </ul>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->

                <!-- Start Atribute Navigation -->
                <div class="attr-nav">
                    <ul>
                        <!-- <li class="search"><a href="#"><i class="fa fa-search"></i></a></li> -->
                        <li class="side-menu">
                            <a href="<?= base_url('order'); ?>">
                                <i class="fa fa-shopping-bag"></i>
                                <span class="badge"><?= $jml_item ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- End Atribute Navigation -->
            </div>
            <!-- Start Side Menu -->
            <div class="side">
                <a href="#" class="close-side"><i class="fa fa-times"></i></a>
                <li class="cart-box">
                    <ul class="cart-list">
                        <?php
                        if (empty($jml_item)) {
                        ?>
                            <li>
                                <h3 class="text-center font-weight-bold">Cart is empty</h3>
                            </li>
                            <?php
                        } else {
                            foreach ($cart_content as $key => $value) {
                                $id_gambar = $value['id'];
                                $image_order = $this->M_Product->product_image($id_gambar);

                                $gambar = $image_order->menu_foto;

                            ?>
                                <li>
                                    <h6><a href="#"><?= $value["name"] ?></a></h6>
                                    <a href="#" class="photo"><img src="<?= base_url() ?>/assets/img/products/<?= $gambar ?>" class="cart-thumb" alt="" /></a>
                                    <p class="text-right"><?= $value["qty"] ?> x - <span class="price"> Rp<?= number_format($value["price"]) ?></span></p>
                                    <p class="text-right font-weight-bold">Rp<?= number_format($value["subtotal"]) ?></p>
                                </li>
                            <?php
                            }
                            ?>

                            <li class="total">
                                <a href="<?= base_url('order'); ?>" class="btn btn-default hvr-hover btn-cart">VIEW CART</a>
                                <span class="float-right"><strong>Total</strong>: Rp<?= $total ?></span>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </li>
            </div>
            <!-- End Side Menu -->
        </nav>
        <!-- End Navigation -->
    </header>
    <!-- End Main Top -->

    <!-- Start Top Search -->
    <div class="top-search">
        <div class="container">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search">
                <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
            </div>
        </div>
    </div>
    <!-- End Top Search -->

    <?php if (isset($pages)) $this->load->view($pages); ?>


    <!-- Start Footer  -->
    <footer>
        <div class="footer-main">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-widget">
                            <h4>About Bandes Rekayasa Digital</h4>
                            <p>Bandes Rekayasa Digital adalah sebuah koperasi karyawan yang didirikan oleh para karyawan di dalam perusahaan Bandes. Koperasi ini bertujuan untuk memberikan manfaat dan kesejahteraan bagi anggota karyawan. Bandes Rekayasa Digital menawarkan berbagai layanan kepada anggotanya, seperti simpan pinjam, program tabungan, asuransi, dan bantuan keuangan.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-widget">
                            <h4>Business Time</h4>
                            <ul class="list-time">
                                <li>Monday - Friday: 08.00am to 05.00pm</li>
                                <li>Saturday: 10.00am to 08.00pm</li>
                                <li>Sunday: <span>Closed</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12">
                        <div class="footer-link-contact">
                            <h4>Contact Us</h4>
                            <ul>
                                <li>
                                    <p><i class="fas fa-map-marker-alt"></i>Alamat: Halim Perdana Kusuma,<br> KS 67213 </p>
                                </li>
                                <li>
                                    <p><i class="fas fa-phone-square"></i>Phone: <a href="tel:+1-888705770">+1-888 705 770</a></p>
                                </li>
                                <li>
                                    <p><i class="fas fa-envelope"></i>Email: <a href="mailto:contactinfo@gmail.com">contactinfo@gmail.com</a></p>
                                </li>
                            </ul>
                        </div>
                        <div class="footer-top-box">
                            <ul>
                                <li><a href="#"><i class="fab fa-facebook" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-google-plus" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fa fa-rss" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-pinterest-p" aria-hidden="true"></i></a></li>
                                <li><a href="#"><i class="fab fa-whatsapp" aria-hidden="true"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer  -->

    <!-- Start copyright  -->
    <div class="footer-copyright">
        <p class="footer-company">All Rights Reserved. &copy;
            <script>
                document.write(new Date().getFullYear());
            </script>
            <a href="#">Bandes Rekayasa Digital</a>
        </p>
    </div>
    <!-- End copyright  -->

    <a href="#" id="back-to-top" title="Back to top" style="display: none;">
        <i class="feather-arrow-up-circle"></i>
    </a>

    <?php if (isset($script)) $this->load->view($script); ?>

</body>

</html>