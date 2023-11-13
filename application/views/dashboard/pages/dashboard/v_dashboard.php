<main id="main" class="main">

    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item  <?php if ($this->uri->segment(2) == 'dashboard') echo 'active' ?>">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard contact">

        <div class="row gy-4">

            <div class="col-xl-12">
                <?php

                $status_payment = 0;

                foreach ($payments as $p) {
                    if ($p->status == "0") {
                        $status_payment = $order;
                        $link = base_url('dashboard/order');
                    } else if ($p->status == "1") {
                        $status_payment = $packing;
                        $link = base_url('dashboard/report/excel/shopping-list');
                    } else if ($p->status == "2") {
                        $status_payment = $unpaid;
                        $link = base_url('dashboard/report/tanda_terima');
                    } else if ($p->status == "3") {
                        $status_payment = $received;
                        $link = "#";
                    } else if ($p->status == "4") {
                        $status_payment = $paid;
                        $link = "#";
                    } ?>
                    <a href="<?= $link ?>" class="btn btn-<?= $p->color ?> btn-sm mb-2">
                        <?= $p->nama_status ?>
                        <span class="badge bg-white text-<?= $p->color ?>"><?= $status_payment ?></span>
                    </a>
                <?php
                } ?>

                <!-- <div class="row">
                    <div class="col-lg-3">
                        <div class="info-box card">
                            <i class="bi bi-geo-alt"></i>
                            <h3>Sedang dikemas</h3>
                            <p><?= number_format($packing) ?> pesanan</p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="info-box card">
                            <i class="bi bi-telephone"></i>
                            <h3>Belum diterima</h3>
                            <p><?= number_format($unpaid) ?> pesanan</p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="info-box card">
                            <i class="bi bi-envelope"></i>
                            <h3>Sudah diterima</h3>
                            <p><?= number_format($received) ?> pesanan</p>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="info-box card">
                            <i class="bi bi-clock"></i>
                            <h3>Lunas</h3>
                            <p><?= number_format($paid) ?> pesanan</p>
                        </div>
                    </div>
                </div> -->

            </div>

        </div>
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Sales Card -->
                    <!-- <div class="col-xxl-4 col-md-4">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Sales</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-cart"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $dashboard['total_item'] ?> pc(s)</h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> -->
                    <!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <!-- <div class="col-xxl-4 col-md-4">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Revenue</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="">Rp</i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= number_format($dashboard['subtotal']) ?></h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div> -->
                    <!-- End Revenue Card -->

                    <!-- Customers Card -->
                    <!-- <div class="col-xxl-4 col-md-8">

                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Members</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6><?= $customer ?> member(s)</h6>
                                        <span class="text-success small pt-1 fw-bold"><?= $admin ?></span> <span class="text-muted small pt-2 ps-1">Administrator(s)</span><br>
                                        <span class="text-success small pt-1 fw-bold"><?= $member ?></span> <span class="text-muted small pt-2 ps-1">Member(s)</span>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div> -->
                    <!-- End Customers Card -->

                </div>
            </div><!-- End Left side columns -->
        </div>
    </section>

</main><!-- End #main -->