<main id="main" class="main">

    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard/product">Products</a></li>
                <li class="breadcrumb-item  <?php if ($this->uri->segment(2) == 'product') echo 'active' ?>">Detail Product of <?= $product["menu_nama"] ?></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message_name') ?>"></div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="card-title"><?= $product["menu_nama"] ?></h5>
                            </div>
                            <div class="col-lg-6 text-end">

                                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#basicModal">
                                    Add new
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope=" col">#</th>
                                        <th scope="col">Nama produk</th>
                                        <th scope="col">Harga modal</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = "1";


                                    // print_r($details);
                                    // foreach ($details as $d) {
                                    //     echo $d->id_produk . '<br>';
                                    // }
                                    // exit;

                                    if (!empty($details)) {
                                        foreach ($details as $d) {
                                            $id = $d->id_produk;
                                            $item = $this->M_Product->detail_product_id($id);
                                    ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $item["menu_nama"] ?></td>
                                                <td>Rp<?= number_format($item["harga_modal"]) ?></td>
                                                <td><?= $d->qty ?>pc(s)</td>
                                                <td>Button</td>
                                            </tr>
                                        <?php
                                            $no++;
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="5">Tidak ada</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->
<div class="modal fade" id="basicModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Vertical Form -->
                <form class="row g-3" action="<?= base_url('dashboard/product/add_package/' . $product["menu_seo"]) ?>" method="POST" enctype="multipart/form-data">
                    <div class="col-12">
                        <label for="id_product" class="form-label">Product Name</label>
                        <select name="id_product" id="" class="form-control">
                            <option value="">--Choose product</option>
                            <?php
                            foreach ($products as $p) {
                            ?>
                                <option value="<?= $p->menu_id ?>"><?= $p->menu_nama ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="inputType" class="form-label">Qty</label>
                        <input type="number" name="qty" id="qty" class="form-control">
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form><!-- Vertical Form -->
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->