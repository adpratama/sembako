<main id="main" class="main">

    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item  <?php if ($this->uri->segment(2) == 'setting') echo 'active' ?>">Transactions</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="card-title">List of transaction</h5>
                            </div>
                            <!-- <div class="col-lg-6 text-end">
                                <a href="<?= base_url('dashboard/report/excel/shopping-list') ?>" class="btn btn-primary mt-3">
                                    <span class="badge bg-white text-primary"><i class="bi bi-download"></i></span>
                                    Daftar belanja
                                </a>
                                <a href="<?= base_url('dashboard/report/tanda_terima') ?>" class="btn btn-primary mt-3">
                                    <span class="badge bg-white text-primary"><i class="bi bi-check"></i></span>
                                    Tanda terima
                                </a>
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <?php

                                $status_payment = "";
                                $link = "";

                                foreach ($payments as $p) {
                                    if ($p->status == "0") {
                                        $status_payment = $order;
                                        $link = base_url('dashboard/order');
                                    }
                                    if ($p->status == "1") {
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
                                }
                                ?>
                            </div>
                        </div>
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>No. Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>Item</th>
                                    <th>Total</th>
                                    <th>Pemesan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($transactions as $t) {
                                    $status = $this->M_Setting->payment_status($t->payment_status);
                                    $pemesan = $this->M_Auth->cek_user_id($t->id_pemesan);

                                ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $t->no_invoice ?></td>
                                        <td><?= format_indo($t->order_time)  ?></td>
                                        <td><?= $t->total_item ?></td>
                                        <td class="text-end">Rp<?= number_format($t->subtotal) ?></td>
                                        <td><?= $pemesan['name'] ?></td>
                                        <td><?= $status['nama_status'] ?></td>
                                        <td>


                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="<?= base_url('dashboard/transaction/view/' . $t->Id) ?>" class="btn btn-primary" title="Lihat Rincian">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <?php
                                                if ($t->payment_status == "1") {
                                                ?>
                                                    <a href="<?= base_url('dashboard/transaction/packing_done/' . $t->Id) ?>" class="btn btn-warning btn-process" title="Selesai pengemasan">
                                                        <i class="bi bi-check"></i>
                                                    </a>
                                                <?php
                                                } else if ($t->payment_status == "2") {
                                                ?>
                                                    <a href="<?= base_url('dashboard/transaction/received/' . $t->Id) ?>" class="btn btn-info btn-process" title="Lunas">
                                                        <i class="bi bi-check"></i>
                                                    </a>
                                                <?php

                                                } else if ($t->payment_status == "3") {
                                                ?>
                                                    <a href="<?= base_url('dashboard/transaction/paid/' . $t->Id) ?>" class="btn btn-info btn-process" title="Lunas">
                                                        <i class="bi bi-check"></i>
                                                    </a>
                                                <?php
                                                }

                                                if ($t->payment_status != "0") {
                                                ?>
                                                    <a href="<?= base_url('dashboard/transaction/print_label/' . $t->Id) ?>" class="btn btn-secondary" title="Cetak label">
                                                        <i class="bi bi-printer"></i>
                                                    </a>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->