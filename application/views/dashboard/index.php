<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- <title>Dashboard - NiceAdmin Bootstrap Template</title> -->
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- title -->
    <title><?= $title ?> - Bandes Rekayasa Digital</title>

    <?php if (isset($style)) $this->load->view($style); ?>
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="<?= base_url(); ?>" class="logo d-flex align-items-center" target="blank">
                <img src="<?= base_url('assets/dashboard/img/logo.png') ?>" alt="">
                <span class="d-none d-lg-block">BRD</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <?php

        $role = $this->M_Auth->role($this->session->userdata('role_id'));
        ?>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item dropdown">

                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number"> <?= $order ?></span>
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have <?= $order ?> unprocessed orders
                            <a href="<?= base_url('dashboard/order') ?>"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <?php
                        foreach ($orders as $o) {


                        ?>
                            <li class="notification-item">
                                <i class="bi bi-exclamation-circle text-warning"></i>
                                <div>
                                    <h4><?= $o->no_invoice ?></h4>
                                    <!-- <p>Quae dolorem earum veritatis oditseno</p> -->
                                    <p><?= format_indo($o->order_time)  ?></p>
                                </div>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        <?php
                        }
                        ?>
                        <li class="dropdown-footer">
                            <a href="<?= base_url('dashboard/order') ?>">Show all notifications</a>
                        </li>

                    </ul><!-- End Notification Dropdown Items -->

                </li><!-- End Notification Nav -->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="<?= base_url('assets/dashboard/img/profile/') . $user['image']; ?>" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?= $user['name'] ?></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?= $user['name'] ?></h6>
                            <span><?= $role['role'] ?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a href="<?= base_url('auth/logout') ?>" class="dropdown-item d-flex align-items-center btn-logout">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <?php
        if ($this->session->userdata('role_id') == "1") {
        ?>
            <ul class="sidebar-nav" id="sidebar-nav">
                <li class="nav-heading">Pages</li>

                <li class="nav-item">
                    <a class="nav-link <?php if ($this->uri->segment(2) != 'dashboard') echo 'collapsed' ?>" href="<?= base_url() ?>dashboard/dashboard">
                        <i class="bi bi-box"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-heading">Transaction</li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($this->uri->segment(2) != 'order') echo 'collapsed' ?>" href="<?= base_url() ?>dashboard/order">
                        <i class="bi bi-journal-check"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($this->uri->segment(2) != 'transaction') echo 'collapsed' ?>" href="<?= base_url() ?>dashboard/transaction">
                        <i class="bi bi-journal-check"></i>
                        <span>Transaction</span>
                    </a>
                </li>
                <li class="nav-heading">Products</li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($this->uri->segment(2) != 'category') echo 'collapsed' ?>" href="<?= base_url() ?>dashboard/category">
                        <i class="bi bi-list-check"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($this->uri->segment(2) != 'product') echo 'collapsed' ?>" href="<?= base_url() ?>dashboard/product">
                        <i class="bi bi-archive"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($this->uri->segment(2) != 'packet') echo 'collapsed' ?>" href="<?= base_url() ?>dashboard/packet">
                        <i class="bi bi-archive"></i>
                        <span>Packet</span>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link <?php if ($this->uri->segment(2) != 'package') echo 'collapsed' ?>" href="<?= base_url() ?>dashboard/package">
                        <i class="bi bi-list-check"></i>
                        <span>Packages</span>
                    </a>
                </li> -->
                <li class="nav-heading">Report</li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($this->uri->segment(2) != 'report') echo 'collapsed' ?>" href="<?= base_url() ?>dashboard/report">
                        <i class="bi bi-list-check"></i>
                        <span>Report</span>
                    </a>
                </li>
                <li class="nav-heading">Configuration</li>
                <!-- <li class="nav-item">
                    <a class="nav-link <?php if ($this->uri->segment(2) != 'setting') echo 'collapsed' ?>" href="<?= base_url() ?>dashboard/setting">
                        <i class="bi bi-archive"></i>
                        <span>Settings</span>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link <?php if ($this->uri->segment(2) != 'user') echo 'collapsed' ?>" href="<?= base_url() ?>dashboard/user">
                        <i class="bi bi-archive"></i>
                        <span>User Management</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('auth/logout') ?>" class="nav-link btn-logout <?php if ($this->uri->segment(2) != 'logout') echo 'collapsed' ?>">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Sign Out</span>
                    </a>
                </li>

            </ul>
        <?php
        } else if ($this->session->userdata('role_id') == "0") {
        ?>
            <ul class="sidebar-nav" id="sidebar-nav">
                <li class="nav-heading">Pages</li>

                <li class="nav-item">
                    <a class="nav-link <?php if ($this->uri->segment(2) != 'dashboard') echo 'collapsed' ?>" href="<?= base_url() ?>dashboard/dashboard">
                        <i class="bi bi-box"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php if ($this->uri->segment(2) != 'payment') echo 'collapsed' ?>" href="<?= base_url() ?>dashboard/payment">
                        <i class="bi bi-box"></i>
                        <span>Payment Status</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('auth/logout') ?>" class="nav-link btn-logout <?php if ($this->uri->segment(2) != 'logout') echo 'collapsed' ?>">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Sign Out</span>
                    </a>
                </li>

            </ul>
        <?php
        }
        ?>


    </aside><!-- End Sidebar-->

    <?php if (isset($pages)) $this->load->view($pages); ?>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Bandes Rekayasa Digital</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <?php if (isset($script)) $this->load->view($script); ?>

</body>

</html>