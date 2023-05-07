<?php view('shared.site.header', [
    'title' => 'Edit Profile'
]);
require './Config/province.php'; ?>

<?php if (!empty($message['all-error'])) { ?>
    <div class="alert alert-danger" style="margin-bottom: 0;" id="all-error">
        <button onclick="document.getElementById('all-error').style.display='none'" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $message['all-error'] ?? '' ?>
    </div>
<?php } ?>
<?php if (!empty($message['success-update-profile'])) { ?>
    <div class="alert alert-success" style="margin-bottom: 0;" id="success-update-profile">
        <button onclick="document.getElementById('success-update-profile').style.display='none'" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $message['success-update-profile'] ?? '' ?>
    </div>
<?php } ?>

<style>
    .checkout-banner {
        background-image: url("./public/uploads/<?= $banners[0]['image'] ?>");
    }
</style>
<section class="banner checkout-banner">
    <div class="container-fluid banner-title">
        <div class="row">
            <div class="col-md-12">
                <h2 id="motto">Profile</h2>

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

            <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7" style="margin: 0 auto">

                <div class="bill-form-block">

                    <div style="margin-bottom: 1.5rem">
                        <h2 style="display: inline">
                            Profile details
                        </h2>

                        <h5 style="display: inline; margin-top: 12px; float:right">Status: &nbsp;
                            <?php if ($user['status'] == 0) : ?>
                                <span class="invalid-error">Blocked</span>
                            <?php else : ?>
                                <span style="color: #28a745;  ">Active</span>
                            <?php endif; ?>
                        </h5>

                    </div>
                    <form method="POST" action="?controller=customer&action=updateProfile" name="profileForm" onsubmit="return validateProfileForm();">


                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="fname">First name <span class="asterisk">*</span></label>
                                <input type="text" value="<?= htmlentities($_SESSION['user']['fname']) ?>" name="fname" id="pf-ud-fname" class="form-control" aria-describedby="helpId" onkeyup="validateName(this, 'First name')">
                                <small id="pf-ud-fname-err"></small>

                            </div>

                            <div class="col-md-6">
                                <label for="lname">Last name <span class="asterisk">*</span></label>
                                <input type="text" value="<?= htmlentities($_SESSION['user']['lname']) ?>" name="lname" id="pf-ud-lname" class="form-control" aria-describedby="helpId" onkeyup="validateName(this, 'Last name')">
                                <small id="pf-ud-lname-err"></small>


                            </div>


                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="email">Email address <span class="asterisk">*</span></label>
                                <input type="text" value="<?= htmlentities($_SESSION['user']['email']) ?>" name="email" id="pf-ud-email" class="form-control" aria-describedby="helpId" onkeyup="validateEmail(this)">
                                <small id="pf-ud-email-err"></small>

                            </div>

                            <div class="col-md-6">
                                <label for="phone">Phone number <span class="asterisk">*</span></label>
                                <input type="text" value="<?= htmlentities($_SESSION['user']['phone']) ?>" name="phone" id="pf-ud-phone" class="form-control" aria-describedby="helpId" onkeyup="validatePhone(this)">
                                <small id="pf-ud-phone-err"></small>


                            </div>


                        </div>




                        <div class="form-group">
                            <label for="province">Province/City <span class="asterisk">*</span></label>
                            <select class="form-control" id="province" name="province">
                                <?php foreach ($provinces as $province) : ?>
                                    <option value="<?= $province['value'] ?>" <?= $_SESSION['user']['province'] == $province['value'] ? 'selected' : '' ?>>
                                        <?= $province['province'] ?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="address">Address <span class="asterisk">*</span></label>
                            <input value="<?= htmlentities($_SESSION['user']['address']); ?>" type="text" name="address" id="pf-ud-address" class="form-control" aria-describedby="helpId" onkeyup="validateNotEmpty(this, 'Address')">
                            <small id="pf-ud-address-err"></small>


                        </div>

                        <div class="form-group">
                            <label for="password">Current Password <span class="asterisk">*</span></label>
                            <input id="pf-ud-password" type="password" class="form-control" name="current_password" autocomplete="current-password" onkeyup="validateNotEmpty(this, 'Password')">
                            <small id="pf-ud-password-err"></small>
                        </div>




                        <div class="form-group" style="border-top: 1px solid lightgray; padding-top: 1.5rem;">
                            <button type="submit" class="btn-root border-root place-order-btn">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>


            <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                <div class="bill-form-block" style="border: none; padding-left: 2rem; padding-right:0">
                    <h2>
                        Password update
                    </h2>

                    <form method="POST" action="?controller=customer&action=updatePassword" name="passwordUpdateForm" onsubmit="return validatePasswordUpdateForm();">



                        <div class="form-group">
                            <label for="password">Current Password <span class="asterisk">*</span></label>


                            <input id="psw-ud-password" type="password" class="form-control" name="current_password" autocomplete="current-password" onkeyup="validateNotEmpty(this, 'Current password');">
                            <small id="psw-ud-password-err"></small>

                        </div>

                        <div class="form-group">
                            <label for="password">New Password <span class="asterisk">*</span></label>


                            <input id="psw-ud-new_password" type="password" class="form-control" name="new_password" autocomplete="current-password" onkeyup="validatePassword(this);">
                            <small id="psw-ud-new_password-err"></small>

                        </div>

                        <div class="form-group">
                            <label for="password">New Confirm Password <span class="asterisk">*</span></label>


                            <input id="psw-ud-new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password" onkeyup="validateConfirmPassword(this, 'psw-ud-new_password');">
                            <small id="psw-ud-new_confirm_password-err"></small>

                        </div>


                        <div class="form-group" style="border-top: 1px solid lightgray; padding-top: 1.5rem;">
                            <button type="submit" class="btn-root border-root place-order-btn">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php view('shared.site.footer'); ?>