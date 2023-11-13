<main id="main" class="main">

    <div class="pagetitle">
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url(); ?>dashboard/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item  <?php if ($this->uri->segment(2) == 'report') echo 'active' ?>">Report</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Report</h5>
                        <form class="" action="<?= base_url('dashboard/report/download') ?>" method="POST">
                            <div class="row g-3">
                                <div class="col-lg-4">
                                    <label for="" class="form-label">Jenis</label>
                                    <select name="jenis" id="jenis" class="form-control">
                                        <option value="">--Pilih jenis</option>
                                        <!-- <option value="belanja">Belanja</option> -->
                                        <option value="tagihan">Tagihan</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="" class="form-label">Perusahaan</label>
                                    <select name="perusahaan" id="perusahaan" class="form-control">
                                        <option value="">--Pilih perusahaan</option>
                                        <?php
                                        foreach ($partners as $p) {
                                        ?>
                                            <option value="<?= $p->Id ?>"><?= $p->nama ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <label for="" class="form-label">Bulan</label>
                                    <input type="month" name="bulan" id="bulan" class="form-control">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-12 text-end">
                                    <label for="" class="form-label"></label>
                                    <button type="submit" class="btn btn-primary">Unduh</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script></script>