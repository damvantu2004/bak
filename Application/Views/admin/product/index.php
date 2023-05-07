<?php view('shared.admin.header', [
    'title' => 'Product List'
]); ?>
<?php if (!empty($message['error-delete'])) { ?>
<div class="alert alert-danger" id="error-delete-product">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
        onclick="document.getElementById('error-delete-product').style.display='none'">&times;</button>
    <?= $message['error-delete'] ?? '' ?>
</div>
<?php } ?>
<?php if (!empty($message['success-delete'])) { ?>
<div class="alert alert-success" id="success-delete-product">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
        onclick="document.getElementById('success-delete-product').style.display='none'">&times;</button>
    <?= $message['success-delete'] ?? '' ?>
</div>
<?php } ?>
<form action="./?module=admin&controller=product&action=searchProductFull" class="form-inline" method="post">

    <div class="form-group">
        <input class="form-control search-input" name="productSearch" placeholder="Search By Name..">
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
            <th>Name</th>
            <th>Category</th>
            <th>Price/ Sale</th>
            <th>Status</th>
            <th>Created Date</th>
            <th>Image</th>
            <th class="text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $model) : ?>
        <tr>
            <td><?= $model['id'] ?></td>
            <td><?= $model['name'] ?></td>
            <td><?= $model['category_name'] ?></td>
            <td> $<?= number_format($model['price'], 2, '.', '') ?> <span
                    class="badge badge-warning"><?= $model['sale_price'] > 0 ? '$' . number_format($model['sale_price'], 2, '.', '') : 'unset' ?></span>
            </td>
            <td>
                <?php if ($model['status'] == 0) : ?>
                <span class="badge badge-danger">Private</span>
                <?php else : ?>

                <span class="badge badge-success">Public</span>
                <?php endif; ?>
            </td>
            <td><?= $model['created_at'] ?></td>
            <td>
                <img src="./public/uploads/<?= $model['image'] ?>" width="60">
            </td>
            <td class="text-right">


                <a href="./?module=admin&controller=product&action=edit&id=<?= $model['id'] ?>"
                    class="btn btn-sm btn-success">
                    <i class="fas fa-edit"></i>
                </a>

                <a href="./?module=admin&controller=product&action=delete&id=<?= $model['id'] ?>"
                    class="btn btn-sm btn-danger btndelete"
                    onclick="return confirm('Are you sure to delete this product ?')">
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