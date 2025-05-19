<?php
include './Application/Views/shared/site/header.php';
require './Config/province.php';
?>

<section class="banner checkout-banner">
    <div class="container-fluid banner-title">
        <div class="row">
            <div class="col-md-12">
                <h2 id="motto">Thông tin tài khoản</h2>
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
            <div class="col-md-8 mx-auto">
                <?php if (isset($success)): ?>
                <div class="alert alert-success">
                    <?= $success ?>
                </div>
                <?php endif; ?>
                
                <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?= $error ?>
                </div>
                <?php endif; ?>
                
                <div class="bill-form-block">
                    <div style="margin-bottom: 1.5rem">
                        <h2 style="display: inline">
                            Thông tin tài khoản
                        </h2>

                        <h5 style="display: inline; margin-top: 12px; float:right">Trạng thái: &nbsp;
                            <?php if ($user['status'] == 0) : ?>
                                <span class="invalid-error">Bị khóa</span>
                            <?php else : ?>
                                <span style="color: #28a745;">Đang hoạt động</span>
                            <?php endif; ?>
                        </h5>
                    </div>
                    
                    <form method="POST" action="?controller=verify&action=updateProfile" name="profileForm" onsubmit="return validateProfileForm();">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="fname">Họ <span class="asterisk">*</span></label>
                                <input type="text" value="<?= htmlentities($user['fname']) ?>" name="fname" id="pf-ud-fname" class="form-control" aria-describedby="helpId" onkeyup="validateName(this, 'First name')">
                                <small id="pf-ud-fname-err"></small>
                            </div>

                            <div class="col-md-6">
                                <label for="lname">Tên <span class="asterisk">*</span></label>
                                <input type="text" value="<?= htmlentities($user['lname']) ?>" name="lname" id="pf-ud-lname" class="form-control" aria-describedby="helpId" onkeyup="validateName(this, 'Last name')">
                                <small id="pf-ud-lname-err"></small>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="email">Email <span class="asterisk">*</span></label>
                                <input type="text" value="<?= htmlentities($user['email']) ?>" name="email" id="pf-ud-email" class="form-control" readonly>
                                <small class="form-text text-muted">Email không thể thay đổi</small>
                            </div>

                            <div class="col-md-6">
                                <label for="phone">Số điện thoại <span class="asterisk">*</span></label>
                                <input type="text" value="<?= htmlentities($user['phone']) ?>" name="phone" id="pf-ud-phone" class="form-control" aria-describedby="helpId" onkeyup="validatePhone(this)">
                                <small id="pf-ud-phone-err"></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="province">Tỉnh/Thành phố <span class="asterisk">*</span></label>
                            <select class="form-control" id="province" name="province">
                                <?php foreach ($provinces as $province) : ?>
                                    <option value="<?= $province['value'] ?>" <?= $user['province'] == $province['value'] ? 'selected' : '' ?>>
                                        <?= $province['province'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="address">Địa chỉ <span class="asterisk">*</span></label>
                            <input value="<?= htmlentities($user['address'] ?? ''); ?>" type="text" name="address" id="pf-ud-address" class="form-control" aria-describedby="helpId" onkeyup="validateNotEmpty(this, 'Address')">
                            <small id="pf-ud-address-err"></small>
                        </div>

                        <div class="form-group d-flex justify-content-between" style="border-top: 1px solid lightgray; padding-top: 1.5rem;">
                            <button type="submit" class="btn-root border-root place-order-btn">Cập nhật thông tin</button>
                            <a href="?controller=verify&action=changePassword" class="btn btn-outline-primary">Đổi mật khẩu</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include './Application/Views/shared/site/footer.php'; ?> 