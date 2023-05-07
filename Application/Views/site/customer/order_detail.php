<?php view('shared.site.header', [
    'title' => 'Order history'
]); ?>

<style>
    .cart-banner {
        background-image: url("./public/uploads/<?= $banners[0]['image'] ?>");
    }
</style>

<section class="banner order-success-banner">
    <div class="container-fluid banner-title">
        <div class="row">
            <div class="col-md-12">
                <h2 id="motto">Order #<?= $order['id'] ?> detail</h2>

            </div>

        </div>
    </div>
    <div class="container-fluid banner-share">
        <div class="row">
            <span>Share this page:</span>
            <div class="banner-social">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-google-plus-g"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
        </div>

    </div>
</section>

<section class="checkout p-50">
    <div class="container">
        <div class="row">

            <div class="col-md-7">

                <div class="bill-form-block">
                    <h2>
                        Order details
                    </h2>


                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="fname">First name <span class="asterisk">*</span></label>
                            <input value="<?= $order['fname'] ?>" type="text" name="fname" id="fname" class="form-control" aria-describedby="helpId" disabled>

                        </div>

                        <div class="col-md-6">
                            <label for="lname">Last name <span class="asterisk">*</span></label>
                            <input value="<?= $order['lname'] ?>" type="text" name="lname" id="lname" class="form-control" aria-describedby="helpId" disabled>



                        </div>

                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="email">Email address <span class="asterisk">*</span></label>
                            <input value="<?= $order['email'] ?>" type="text" name="email" id="email" class="form-control" aria-describedby="helpId" disabled>

                        </div>

                        <div class="col-md-6">
                            <label for="phone">Phone number <span class="asterisk">*</span></label>
                            <input value="<?= $order['phone'] ?>" type="text" name="phone" id="phone" class="form-control" aria-describedby="helpId" disabled>

                            <div>

                            </div>

                        </div>

                    </div>




                    <div class="form-group">
                        <label for="province">Province/City <span class="asterisk">*</span></label>
                        <select class="form-control" id="province" name="province" disabled>

                            <option value="<?= $order['province'] ?>"><?= $order['province'] ?></option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="address">Address <span class="asterisk">*</span></label>

                        <input value="<?= $order['address'] ?>" type="text" name="address" id="address" class="form-control" aria-describedby="helpId" disabled>

                    </div>

                    <div class="form-group">
                        <label for="note">Order note</label>

                        <textarea class="form-control" name="note" rows="5" placeholder="Notes on your order" disabled><?= $order['note'] ?></textarea>

                    </div>



                    <h2 style="margin-top: 2.5rem;">Shipping method</h2>
                    <div class="form-group">
                        <label for="delivery">Select delivery method</label>

                        <select class="form-control" id="delivery" name="delivery" disabled>
                            <option value="<?= $order['delivery'] ?>"><?= $order['delivery'] ?></option>
                        </select>

                    </div>

                    <h2 style="margin-top: 2.5rem;">Payment method</h2>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label for="payment">Payment method</label>

                        <select class="form-control" id="payment" name="payment" disabled>
                            <option value="<?= $order['payment'] ?>"><?= $order['payment'] ?> </option>
                        </select>

                    </div>



                </div>

            </div>


            <div class="col-md-5">
                <h2>Your order</h2>
                <table class="table checkout-table">

                    <tbody>
                        <?php foreach ($products_in_order as $item) : ?>
                            <tr class="checkout-pro">
                                <td class="checkout-pro-title">
                                    <img src="./public/uploads/<?= $item['image'] ?>" width="100">
                                    <div class="checkout-pro-info">

                                        <h6><?= $item['name'] ?></h6>

                                        <p>$<?= number_format($item['price_sum'], 2, '.', '') ?></p>
                                    </div>

                                </td>

                                <td class="checkout-pro-quantity text-right">
                                    X<?= $item['quantity'] ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                        <tr class="order-subtotal">

                            <td>
                                <div class="checkout-pro-info p-0">
                                    <p>Sub total (<?= $order['quantity'] ?> items):</p>
                                    <?php if ($order['coupon'] != 0) : ?>
                                        <p>Discount: </p>
                                    <?php endif; ?>
                                    <!-- <p>Tax:</p> -->
                                    <p>Shipping fee:</p>
                                </div>

                            </td>
                            <td>
                                <div class="checkout-fee text-right">
                                    <p>
                                        $<?= number_format($order['total'], 2, '.', '') ?>
                                    </p>
                                    <?php if ($order['coupon'] != 0) : ?>
                                        <p>
                                            - $<?= number_format($order['total'] * ($order['coupon']), 2, '.', '') ?>
                                        </p>
                                    <?php endif; ?>

                                    <p>
                                        $2.00
                                    </p>
                                </div>
                            </td>

                        </tr>
                    </tbody>

                    <tr class="order-total">
                        <td>
                            <h2>Order total</h2>
                        </td>

                        <td>
                            <h2 class="price">$<?= number_format($order['total'] * (1 - $order['coupon']) + 2, 2, '.', '') ?></h2>
                        </td>
                    </tr>

                    <form action="./?controller=customer&action=cancelOrder&id=<?= $order['id'] ?>" method="POST" role="form">


                        <tr>
                            <td colspan="2" style="padding-top: 7px">

                                <div class="form-group">
                                    <label for="status">Status</label>

                                    <select class="form-control" id="status" name="status" disabled>
                                        <option value="<?= $order['status'] ?>">
                                            <?php
                                            if ($order['status'] == 0) {
                                                echo 'Delivered';
                                            } else if ($order['status'] == 1) {
                                                echo 'Pending';
                                            } else if ($order['status'] == 2) {
                                                echo 'Delivering';
                                            } else if ($order['status'] == 3) {
                                                echo 'Cancelled';
                                            }
                                            ?>
                                        </option>
                                    </select>
                                </div>

                            </td>
                        </tr>
                        <?php if ($order['status'] == 1) : ?>
                            <tr>

                                <td colspan="2" style="border: none; padding-top: 20px">
                                    <div class="form-group">
                                        <input type="submit" class="btn-root border-root place-order-btn btn-cancel" value="Cancel order">
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </form>

                    <tfoot>

                        <tr>
                            <td colspan="2">
                                You have a question ? or need help to complete your order
                                <p> <i class="discount fas fa-phone-alt mr-2" style="font-size: 13px;"></i>(898) 325
                                    2548
                                    <i class="discount far fa-envelope ml-4 mr-2"></i>bakery@support.com
                                </p>
                            </td>
                        </tr>
                    </tfoot>
                </table>

            </div>


        </div>
    </div>
</section>
<?php view('shared.site.footer'); ?>