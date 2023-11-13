<!-- Start All Title Box -->
<div class="all-title-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2>Cart</h2>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Shop</a></li>
                    <li class="breadcrumb-item active">Cart</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End All Title Box -->

<!-- Start Cart  -->
<div class="cart-box-main">
    <div class="container">
        <?php echo form_open('order/update'); ?>
        <div class="row">
            <div class="col-lg-9">
                <div class="table-main table-responsive">


                    <table class="table">
                        <thead>
                            <tr>
                                <th>Images</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $i = 1;

                            foreach ($cart_content as $item) {
                                $id_gambar = $item['id'];

                                $image_order = $this->M_Product->product_image($id_gambar);

                                $gambar = $image_order->menu_foto;
                                $stok = $image_order->menu_stok;
                                $menu_seo = $image_order->menu_seo; ?>
                                <tr>
                                    <td class="thumbnail-img">
                                        <a href="#">
                                            <img class="img-fluid" src="<?= base_url(); ?>assets/img/products/<?= $gambar ?>" alt="" />
                                        </a>
                                    </td>
                                    <td class="name-pr">
                                        <a href="<?= base_url('product/show/' . $menu_seo) ?>"><?= $item['name'] ?></a>
                                    </td>
                                    <td class="price-pr">
                                        <p>Rp<?= number_format($item['price'], 2, ',', '.') ?></p>
                                    </td>
                                    <td class="quantity-box">
                                        <?php

                                        echo
                                        form_input(array(
                                            'name' => $i . '[qty]',
                                            'value' => $item['qty'],
                                            'maxlength' => '3',
                                            'size' => '5',
                                            'type' => 'number',
                                            'class' => 'center',
                                            'min' => '0'
                                        ));
                                        ?>
                                    </td>
                                    <td class="total-pr">
                                        <p>Rp<?= number_format($item['subtotal'], 2, ',', '.') ?></p>
                                    </td>
                                    <td class="remove-pr">
                                        <a href="<?= base_url('order/delete/' . $item['rowid']) ?>">
                                            <i class="far fa-window-close"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                                $i++;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12">
                <div class="order-box">
                    <h3>Order summary</h3>
                    <div class="d-flex">
                        <h4>Sub Total</h4>
                        <div class="ml-auto font-weight-bold">Rp<?= number_format($subtotal, 2, ',', '.') ?></div>
                    </div>
                    <div class="d-flex">
                        <h4>Shipping Cost</h4>
                        <div class="ml-auto font-weight-bold"> Free </div>
                    </div>
                    <hr>
                    <div class="d-flex gr-total">
                        <h5>Grand Total</h5>
                        <div class="ml-auto h5">Rp<?= number_format($subtotal, 2, ',', '.') ?></div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-lg-9">

                <div class="update-box align-items-end">
                    <?php
                    $button = array(
                        'name' => 'button',
                        'value' => 'Update cart',
                        'type' => 'submit',
                    );
                    echo form_submit($button);
                    ?>
                </div>
                <div class="shopping-box mr-1">
                    <a href="<?= base_url('order/clear') ?>" class="ml-auto btn hvr-hover">Clear Cart</a>
                    <a href="<?= base_url('order/checkout') ?>" class="ml-auto btn hvr-hover">Checkout</a>
                </div>
            </div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>
<!-- End Cart -->