<!-- Start All Title Box -->
<div class="all-title-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Akun Saya</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Akun</a></li>
                    <li class="breadcrumb-item active">Akun Saya</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End All Title Box -->
<div class="cart-box-main">
    <div class="container">
        <form class="needs-validation" novalidate action="<?= base_url('profile/update/' . $user['username']) ?>" method="POST">
            <div class="row">
                <div class="col-sm-6 col-lg-6 mb-3">
                    <div class="checkout-address">
                        <div class="title-left">
                            <h3>Akun saya</h3>
                        </div>
                        <div class="mb-3">
                            <label for="firstName">Nama *</label>
                            <input type="text" class="form-control" name="name" placeholder="" value="<?= $user['name'] ?>">
                            <div class="invalid-feedback"> Valid first name is required. </div>
                        </div>
                        <div class="mb-3">
                            <label for="username">Username *</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="username" placeholder="" value="<?= $user['username'] ?>">
                                <div class="invalid-feedback" style="width: 100%;"> Your username is required. </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email">Alamat Email *</label>
                            <input type="email" class="form-control" name="email" placeholder="" value="<?= $user['email'] ?>">
                            <div class="invalid-feedback"> Please enter a valid email address for shipping updates. </div>
                        </div>
                        <!-- <hr class="mb-1"> -->
                    </div>
                    <div class="d-flex shopping-box" style="float: right;">
                        <a href="<?= base_url('/') ?>" class="btn hvr-hover ">Beranda</a>
                        <button type="submit" class="btn-cart  btn hvr-hover">Perbarui</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>