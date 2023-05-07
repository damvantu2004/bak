<?php view('shared.admin.header', [
    'title' => 'Coupon List'
]); ?>
<?php if (!empty($message['error-delete'])) { ?>
    <div class="alert alert-danger" id="error-delete-coupon">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="document.getElementById('error-delete-coupon').style.display='none'">&times;</button>
        <?= $message['error-delete'] ?? '' ?>
    </div>
<?php } ?>
<?php if (!empty($message['success-delete'])) { ?>
    <div class="alert alert-success" id="success-delete-coupon">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="document.getElementById('success-delete-coupon').style.display='none'">&times;</button>
        <?= $message['success-delete'] ?? '' ?>
    </div>
<?php } ?>
<form action="./?module=admin&controller=coupon&action=searchCouponFull" class="form-inline" method="post">

    <div class="form-group">
        <input class="form-control search-input" name="couponSearch" placeholder="Search By Name..">
    </div>

    <button type="submit" class="btn btn-root search-btn">
        <i class="fas fa-search"></i>
    </button>
</form>
<hr>
<table class="table table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Discount value</th>
            <th>Available use</th>
            <th>Status</th>
            <th class="text-center">Created Date</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $model) : ?>
            <tr>
                <td><?= $model['id'] ?></td>
                <td>
                    <span class="badge badge-warning"> <?= $model['coupon_value'] * 100 ?>%</span>
                </td>
                <td><?= $model['used_times'] ?></td>

                <td>
                    <?php if ($model['status'] == 0) : ?>
                        <span class="badge badge-danger">Expired</span>
                    <?php else : ?>
                        <span class="badge badge-success">Active</span>
                    <?php endif; ?>
                </td>
                <td class="text-center"><?= $model['created_at'] ?></td>

                <td class="text-center">


                    <a href="./?module=admin&controller=coupon&action=edit&id=<?= $model['id'] ?>" class="btn btn-sm btn-success">
                        <i class="fas fa-edit"></i>
                    </a>

                    <a href="./?module=admin&controller=coupon&action=delete&id=<?= $model['id'] ?>" class="btn btn-sm btn-danger btndelete" onclick="return confirm('Are you sure to delete this coupon ?')">
                        <i class="fas fa-trash"></i>
                    </a>

                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<hr>
<?= $pagination ?>
<!-- Pagination -->

<?php view('shared.admin.footer'); ?>