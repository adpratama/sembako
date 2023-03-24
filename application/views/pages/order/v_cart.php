<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Fresh and Organic</p>
                    <h1>Cart</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end breadcrumb section -->

<!-- cart -->
<div class="cart-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <div class="cart-table-wrap">
                    
                    <?php echo form_open('order/add'); ?>
                    <table class="cart-table">
                        <thead class="cart-table-head">
                            <tr class="table-head-row">
                                <th class="product-image">Product Image</th>
                                <th class="product-name">Name</th>
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-total">Total</th>
                                <th class="product-remove"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $item_order = $this->cart->contents();
                            $jml_item = 0;

                            foreach ($item_order as $key => $value) {
                                $jml_item = $jml_item + $value['qty'];
                            }
                            $i = 1;

                            foreach ($item_order as $item) {
                                $id_gambar = $item['id'];
                                $image_order = $this->db->select('menu_foto')->where('menu_id', $id_gambar)->get('v_menu')->row();
                                // $image_order = $this->db->select('menu_foto')->from('v_menu')->where('menu_id', $id_gambar)->get()->return();

                                $gambar = $image_order->menu_foto;
                                ?>
                                <tr class="table-body-row">
                                    <td class="product-image"><img src="<?= base_url(); ?>assets/img/menu_folder/<?= $gambar ?>" alt=""></td>
                                    <td class=""><?= $item['name'] ?></td>
                                    <td class="product-price right">Rp<?= number_format($item['price'], 2, ',', '.') ?></td>
                                    <td class="product-quantity right">
                                        <?php 
                                        echo 
                                        form_input(array(
                                            'name' => $i . '[qty]',
                                            'value' => $item['qty'],
                                            'maxlength' => '3',
                                            'size' => '5',
                                            'type' => 'number',
                                            'class' => 'center'
                                        )); ?>    
                                    </td>
                                    <td class="product-total right">Rp<?= number_format($item['subtotal'], 2, ',', '.') ?></td>
                                    <td class="product-remove"><a href="#"><i class="far fa-window-close"></i></a></td>
                                </tr>
                                <?php
                                $i++;
                            } ?>
                        </tbody>
                    </table>
                    <div class="cart-buttons right">
                        <?php
                        echo form_submit('', 'Update cart')
                        ?>
                        <!-- <button type="submit" class="btn btn-primary">Update cart</button> -->
                        <a href="checkout.html" class="boxed-btn black">Check Out</a>
                    </div>
                    
                    <?php echo form_close(); ?>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="total-section">
                    <table class="total-table">
                        <thead class="total-table-head">
                            <tr class="table-total-row">
                                <th>Total</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $subtotal = $this->cart->total();
                            $ppn = $subtotal * 0.1;
                            $grandtotal = $subtotal + $ppn;
                            ?>
                            <tr class="total-data">
                                <td><strong>Subtotal: </strong></td>
                                <td class="right">Rp<?= number_format($subtotal, 2, ',', '.') ?></td>
                            </tr>
                            <tr class="total-data">
                                <td><strong>PPn: </strong></td>
                                <td class="right">Rp<?= number_format($ppn, 2, ',', '.')?></td>
                            </tr>
                            <tr class="total-data">
                                <td><strong>Total: </strong></td>
                                <td class="right">Rp<?=number_format($grandtotal, 2, ',', '.')?></td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- <div class="cart-buttons">
                        <a href="cart.html" class="boxed-btn">Update Cart</a>
                        <a href="checkout.html" class="boxed-btn black">Check Out</a>
                    </div> -->
                </div>

                <!-- <div class="coupon-section">
                    <h3>Apply Coupon</h3>
                    <div class="coupon-form-wrap">
                        <form action="index.html">
                            <p><input type="text" placeholder="Coupon"></p>
                            <p><input type="submit" value="Apply"></p>
                        </form>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
<!-- end cart -->