<?php view('shared.admin.header', [
    'title' => 'Edit Coupon'
]); ?>
<?php if (!empty($message['success-edit'])) { ?>
    <div class="alert alert-success" id="success-edit-coupon">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="document.getElementById('success-edit-coupon').style.display='none'">&times;</button>
        <?= $message['success-edit'] ?? '' ?>
    </div>
<?php } ?>

<div class="container">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="margin: 0 auto">
            <form action="./?module=admin&controller=coupon&action=update&id=<?= $_GET['id'] ?>" method="POST" role="form" name="couponForm" onsubmit="return validateCouponForm();">

                <div class="form-group">
                    <label for="coupon-id">Coupon Name</label>
                    <small id="coupon-id-err"></small>
                    <input type="text" class="form-control" name="id" placeholder="Input coupon name" value="<?= $coupon['id'] ?>" id="coupon-id" onkeyup="validateNotEmpty(this, 'Coupon name'); this.value = this.value.toUpperCase();">
                    <?php if (!empty($message['error-name'])) : ?>
                        <small class="help-block invalid-error"><?= $message['error-name'] ?></small>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="coupon-value">Discount value (%)</label>
                    <small id="coupon-value-err"></small>
                    <input type="number" class="form-control" step="0.1" name="coupon_value" value="<?= $coupon['coupon_value'] * 100 ?>" placeholder="Input discount value" id="coupon-value" onkeyup="validateFloat(this, 'Discount', 1);">
                </div>

                <div class="form-group">
                    <label for="coupon-use">Available uses</label>
                    <small id="coupon-use-err"></small>
                    <input type="number" class="form-control" step="1" name="used_times" value="<?= $coupon['used_times'] ?>" placeholder="Input value of available uses" id="coupon-use" onkeyup="validateInt(this, 'Available use');">
                </div>

                <div class="form-group">
                    <label for="status">Status</label>

                    <select name="status" class="form-control" id="status">
                        <option value="1" <?= $coupon['status'] == '1' ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= $coupon['status'] == '0' ? 'selected' : '' ?>>Expired</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Save Data</button>
            </form>
        </div>

    </div>

</div>




<?php view('shared.admin.footer'); ?>