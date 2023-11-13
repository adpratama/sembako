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
                        <form action="<?= base_url('dashboard/transaction/check_tanda_terima') ?>" method="post">
                            <div class="row">
                                <div class="col-lg-6">

                                    <h5 class="card-title">Penerimaan barang</h5>
                                </div>
                                <div class="col-lg-6 text-end">
                                    <button type="submit" class="btn btn-primary mt-3 btn-confirm" id="btn-submit">Proses Terima</button>
                                </div>
                            </div>

                            <!-- Default Table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <input class="form-check-input" type="checkbox" onClick="toggle(this)">
                                        </th>
                                        <th scope="col">#</th>
                                        <th scope="col">No. Transaksi</th>
                                        <th scope="col">Pemesan</th>
                                        <th scope="col">Item</th>
                                        <th scope="col" class="text-end">Total</th>
                                        <!-- <th scope="col">Start Date</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    if (!$unpaid) {
                                    ?>
                                        <tr>
                                            <td colspan="6">Tidak ada data yang ditampilkan</td>
                                        </tr>
                                        <?php
                                    } else {
                                        foreach ($unpaid as $u) {
                                            $pemesan = $this->M_Auth->cek_user_id($u->id_pemesan);
                                        ?>
                                            <tr>
                                                <th>
                                                    <input class="form-check-input" type="checkbox" id="check" name="check[]" value="<?= $u->Id ?>">
                                                </th>
                                                <th scope="row"><?= $no ?></th>
                                                <td><?= $u->no_invoice ?></td>
                                                <td><?= $pemesan['name'] ?></td>
                                                <td><?= $u->total_item ?> pc(s)</td>
                                                <td class="text-end">Rp<?= number_format($u->grand_total) ?></td>
                                            </tr>
                                    <?php
                                            $no++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </form>
                        <!-- End Default Table Example -->
                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->

<script>
    function toggle(source) {
        checkboxes = document.getElementsByName('check[]');
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = source.checked;
        }
    }
</script>