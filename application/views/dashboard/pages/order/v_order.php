<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<main id="main" class="main">

    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item  <?php if ($this->uri->segment(2) == 'setting') echo 'active' ?>">Orders</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">List of Orders</h5>
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
                                            <a href="<?= base_url('dashboard/transaction/view/' . $t->Id) ?>" class="btn btn-primary" title="Lihat Rincian">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('dashboard/transaction/process/' . $t->Id) ?>" class="btn btn-success btn-process" title="Proses pesanan">
                                                <i class="bi bi-check"></i>
                                            </a>
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

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    var tableProduct = '#table-product';

    new DataTable(tableProduct, {
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            <?php
            if ($this->uri->segment(2) == "product") {
            ?> "url": "<?= base_url('dashboard/product/getData'); ?>",
            <?php
            } else if ($this->uri->segment(2) == "packet") {
            ?> "url": "<?= base_url('dashboard/packet/getData'); ?>",
            <?php
            }
            ?> "type": "POST",
        },
        "columnDefs": [-1],
        "orderable": false
    });
</script>