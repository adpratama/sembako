<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<main id="main" class="main">

    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item  <?php if ($this->uri->segment(2) == 'product') echo 'active' ?>"><?= $title ?></li>
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
                                <h5 class="card-title">List of <?= $title ?></h5>
                            </div>
                            <div class="col-lg-6 text-end">
                                <a href="<?= base_url('dashboard/product/add') ?>" class="btn btn-primary mt-3">Add new</a>
                            </div>
                        </div>
                        <!-- Table with stripped rows -->
                        <div class=" mb-3">
                            <table class="table" id="table-product">
                                <thead>
                                    <tr>
                                        <th scope=" col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
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