<main id="main" class="main">

    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard/product">Products</a></li>
                <li class="breadcrumb-item  <?php if ($this->uri->segment(2) == 'product') echo 'active' ?>">Add Stock</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-6">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $product['menu_nama'] ?></h5>

                        <?= $this->session->flashdata('message_name'); ?>

                        <!-- Vertical Form -->
                        <form class="row g-3" action="<?= base_url('dashboard/product/add_stock/' . $slug) ?>" method="POST">
                            <div class="col-12">
                                <label for="product_stock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="product_stock" name="product_stock" placeholder="0" autofocus>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                        <!-- Vertical Form -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->