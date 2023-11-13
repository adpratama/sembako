<!-- Start All Title Box -->
<div class="all-title-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Riwayat Transaksi</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Akun</a></li>
                    <li class="breadcrumb-item active">Transaksi</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End All Title Box -->

<!-- Start Wishlist  -->
<div class="wishlist-box-main">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div id="accordion">
                    <?php
                    if ($transactions == NULL) {
                    ?>
                        <h3 class="text-center font-weight-bold mb-4">Tidak ada riwayat belanja</h3>
                        <p class="text-center"><a class="btn hvr-hover text-white" href="<?= base_url('product') ?>">Shop Now</a></p>
                        <?php
                    } else {
                        $no = 1;
                        foreach ($transactions as $t) {
                        ?>
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="mb-0 text-black"><?= $t->no_invoice ?></h5>
                                        </div>
                                        <div class="col-lg-6 text-right">

                                            <h5 class="mb-0 text-black">
                                                <button class="btn btn-link" data-toggle="collapse" data-target="#<?= $t->Id ?>" aria-expanded="true" aria-controls="<?= $t->Id ?>">
                                                    <strong><?= format_indo($t->order_time)  ?></strong>
                                                </button>
                                            </h5>
                                        </div>
                                    </div>
                                </div>

                                <div id="<?= $t->Id ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body table-main table-responsive">
                                        <table class="table">
                                            <thead>
                                                <th>Nama Produk</th>
                                                <th>Jumlah</th>
                                                <th>Harga Satuan</th>
                                                <th>Subtotal</th>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $id = $t->Id;
                                                $details = $this->M_Order->transaction_detail($id);

                                                foreach ($details as $d) {
                                                    $id = $d->id_product;
                                                    $item = $this->M_Product->detail_product_id($id);

                                                    // print_r($item);
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <a href="<?= base_url() ?>">
                                                                <?= $item["menu_nama"] ?>
                                                            </a>
                                                        </td>
                                                        <td class="price-pr text-center"><?= $d->jumlah ?> pc(s)</td>
                                                        <td class="text-right"><?= $d->harga_satuan ?></td>
                                                        <td class="text-right"><?= number_format($d->subtotal) ?></td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                                <tr>
                                                    <td colspan="3" class="font-weight-bold text-center">Total</td>
                                                    <td class="text-right">
                                                        Rp<?= number_format($t->subtotal) ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                    <?php
                            $no++;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>