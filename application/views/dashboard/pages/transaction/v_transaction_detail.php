<main id="main" class="main">

    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard/transaction">Transaction</a></li>
                <li class="breadcrumb-item  <?php if ($this->uri->segment(2) == 'setting') echo 'active' ?>">Transaction Details</li>
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
                            <div class="col-lg-6 text-end">
                                <a href="<?= base_url('dashboard/transaction') ?>" class="btn btn-primary mt-3">Back</a>
                            </div>
                        </div>
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>Product Name</th>
                                    <th>Qty(s)</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;

                                foreach ($details as $d) {
                                    $id = $d->id_product;
                                    $item = $this->M_Product->detail_product_id($id);
                                ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td>
                                            <?= $item["menu_nama"] ?>
                                        </td>
                                        <td class="price-pr text-center"><?= $d->jumlah ?> pc(s)</td>
                                        <td class="text-end">Rp<?= number_format($d->harga_satuan) ?></td>
                                        <td class="text-end">Rp<?= number_format($d->subtotal) ?></td>
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