<?php view('shared.site.header', [
    'title' => 'Home'
]); ?>
<?php if (!empty($message['all-error'])) { ?>
    <div class="alert alert-danger" style="margin-bottom: 0;" id="all-error">
        <button onclick="document.getElementById('all-error').style.display='none'" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $message['all-error'] ?? '' ?>
    </div>
<?php } ?>
<?php if (!empty($message['success-login'])) { ?>
    <div class="alert alert-success" style="margin-bottom: 0;" id="success-login">
        <button onclick="document.getElementById('success-login').style.display='none'" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $message['success-login'] ?? '' ?>
    </div>
<?php } ?>
<?php if (!empty($success['add_to_cart'])) { ?>
    <div class="alert alert-warning" style="margin-bottom: 0;" id="success-add-to-cart">
        <button onclick="document.getElementById('success-add-to-cart').style.display='none'" type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $success['add_to_cart'] ?? '' ?>
    </div>
<?php } ?>

<?php view('site.home.main', [
    'latest_products8'  => $latest_products8,
    'latest_products4' => $latest_products4,
    'categories' => $categories,
    'banners' => $banners,
    'offer_pro' => $offer_pro
]); ?>

<?php view('shared.site.footer'); ?>