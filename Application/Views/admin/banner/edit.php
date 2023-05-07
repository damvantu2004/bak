<?php view('shared.admin.header', [
    'title' => 'Edit Banner'
]); ?>
<?php if (!empty($message)) { ?>
    <div class="alert alert-success" id="success-update-banner">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="document.getElementById('success-update-banner').style.display='none'">&times;</button>
        <?= $message ?? '' ?>
    </div>
<?php } ?>

<form action="./?module=admin&controller=banner&action=update&id=<?= $_GET['id'] ?>" method="POST" role="form" name="bannerForm" enctype="multipart/form-data" onsubmit="return validateBannerEditForm();">

    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="ad-bn-ed-name">Name</label>
                <small id="ad-bn-ed-name-err"></small>
                <input type="text" class="form-control" id='ad-bn-ed-name' name="name" placeholder="Input name" value="<?= $banner['name'] ?>" onkeyup="validateNotEmpty(this, 'Banner name');">

            </div>

            <div class="form-group">
                <label for="ad-bn-ed-site">Site</label>
                <select name="site" class="form-control" id='ad-bn-ed-site'>
                    <option value="Home" <?= $banner['site'] == 'Home' ? 'selected' : ''  ?>>Home</option>
                    <option value="About" <?= $banner['site'] == 'About' ? 'selected' : ''  ?>>About</option>
                    <option value="Blog" <?= $banner['site'] == 'Blog' ? 'selected' : ''  ?>>Blog</option>
                    <option value="Blog Detail" <?= $banner['site'] == 'Blog Detail' ? 'selected' : ''  ?>>Blog Detail</option>
                    <option value="Product" <?= $banner['site'] == 'Product' ? 'selected' : ''  ?>>Product</option>
                    <option value="Product Detail" <?= $banner['site'] == 'Product Detail' ? 'selected' : ''  ?>>Product Detail</option>
                    <option value="Contact" <?= $banner['site'] == 'Contact' ? 'selected' : ''  ?>>Contact</option>
                    <option value="Cart" <?= $banner['site'] == 'Cart' ? 'selected' : ''  ?>>Cart</option>
                    <option value="Checkout" <?= $banner['site'] == 'Checkout' ? 'selected' : ''  ?>>Checkout</option>
                </select>
            </div>

            <div class="form-group">
                <label for="ad-bn-ed-description">Description</label>
                <textarea class="form-control" id="ad-bn-ed-description" name="description" placeholder="Banner description" style="height: 46px;"><?= $banner['description'] ?></textarea>

            </div>
        </div>


        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <label for="ad-bn-ed-status">Status</label>
                <select name="status" class="form-control" id='ad-bn-ed-status'>
                    <option value="1" <?= $banner['status'] == 1 ? 'selected' : ''  ?>>Visible</option>
                    <option value="0" <?= $banner['status'] == 0 ? 'selected' : ''  ?>>Hidden</option>
                </select>
            </div>

            <div class="form-group">
                <label for="ad-bn-ed-priority">Priority</label>
                <small id="ad-bn-ed-priority-err"></small>
                <input type="number" id="ad-bn-ed-priority" class="form-control" name="priority" placeholder="Input priority" min="1" value="<?= $banner['priority'] ?>" onkeyup="validateInt(this, 'Priority');">

            </div>

            <div class="form-group">
                <label for=""> Banner Image</label>
                <small id="actual-btn-err"></small>
                <br>
                <input type="file" name="image" id="actual-btn" hidden onchange="readURL(this);">



                <div class="input-group">
                    <span class="form-control" id="file-chosen"><?= $banner['image'] ?></span>

                    <input type="hidden" name="current-image" id="" class="form-control" value="<?= $banner['image'] ?>">

                    <div class="input-group-append">


                        <label for="actual-btn" id='file-label' class="btn btn-sm btn-danger"><i class="fa fa-folder-open"></i></label>


                    </div>
                </div>

            </div>




        </div>
        <?php if (isset($banner['image'])) : ?>
            <div class="row">

                <img src="./public/uploads/<?= $banner['image'] ?>" alt="" id="blah" style="width:100%; padding: 15px">

            </div>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary">Save Data</button>
</form>


<?php view('shared.admin.footer'); ?>