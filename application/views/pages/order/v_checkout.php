<!-- Start All Title Box -->
<div class="all-title-box">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<h2>Checkout</h2>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Shop</a></li>
					<li class="breadcrumb-item active">Checkout</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<!-- End All Title Box -->

<!-- Start Cart  -->
<div class="cart-box-main">
	<div class="container">
		<form class="needs-validation" novalidate action="<?= base_url('order/send_order') ?>" method="POST">
			<div class="row">
				<div class="col-sm-6 col-lg-6 mb-3">
					<div class="checkout-address">
						<div class="title-left">
							<h3>Billing address</h3>
						</div>
						<div class="mb-3">
							<label for="firstName">First name *</label>
							<!-- <input type="text" class="form-control" id="firstName" placeholder="" value="<?= $user['name'] ?>" readonly>
							<div class="invalid-feedback"> Valid first name is required. </div> -->
							<select name="id_pemesan" id="id_pemesan" class="form-control selectpicker" data-live-search="true" required>
								<option value="">--Pilih member</option>
								<?php
								foreach ($members as $m) {
								?>
									<option value="<?= $m->id_karyawan ?>"><?= $m->name ?> (<?= $m->nama_perusahaan ?>)</option>
								<?php
								}
								?>
							</select>
							<?= form_error('id_pemesan', '<small class="text-danger">', '</small>'); ?>
						</div>
						<div class="mb-3">
							<label for="username">Username *</label>
							<div class="input-group">
								<input type="text" class="form-control" id="username" placeholder="" value="<?= $user['username'] ?>" readonly>
								<div class="invalid-feedback" style="width: 100%;"> Your username is required. </div>
							</div>
						</div>
						<div class="mb-3">
							<label for="email">Email Address *</label>
							<input type="email" class="form-control" id="email" placeholder="" value="<?= $user['email'] ?>" readonly>
							<div class="invalid-feedback"> Please enter a valid email address for shipping updates. </div>
						</div>
						<hr class="mb-1">
					</div>
				</div>
				<div class="col-sm-6 col-lg-6 mb-3">
					<div class="row">
						<div class="col-md-12 col-lg-12">
							<div class="odr-box">
								<div class="title-left">
									<h3>Shopping cart</h3>
								</div>
								<div class="rounded p-2 bg-light">
									<?php
									foreach ($cart_content as $value) {
									?>
										<div class="media mb-2 border-bottom">
											<div class="media-body"> <a href="detail.html"> <?= $value['name'] ?></a>
												<div class="small text-muted">Harga: Rp<?= number_format($value['price'], 2, ',', '.') ?> <span class="mx-2">|</span> Qty: <?= number_format($value['qty']) ?> <span class="mx-2">|</span> Subtotal: Rp<?= number_format($value['subtotal'], 2, ',', '.') ?></div>
											</div>
										</div>
									<?php
									}
									?>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-lg-12">
							<div class="order-box">
								<div class="title-left">
									<h3>Your order</h3>
								</div>
								<div class="d-flex">
									<div class="font-weight-bold">Product</div>
									<div class="ml-auto font-weight-bold">Total</div>
								</div>
								<hr class="my-1">
								<div class="d-flex">
									<h4>Sub Total</h4>
									<div class="ml-auto font-weight-bold"> Rp<?= $total ?> </div>
								</div>
								<hr>
								<div class="d-flex gr-total">
									<h5>Grand Total</h5>
									<div class="ml-auto h5"> Rp<?= $total ?> </div>
								</div>
								<hr>
							</div>
						</div>
						<div class="col-md-12 col-lg-12 d-flex shopping-box ">
							<button type="submit" class="btn-cart ml-auto btn hvr-hover">Place order</button>
						</div>
					</div>
				</div>
			</div>
		</form>

		<button class="btn hvr-hover toastrDefaultSuccess">Test</button>

	</div>
</div>
<!-- End Cart -->