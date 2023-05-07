<?php view('shared.admin.header', [
    'title' => "Product '" . $pro['name'] . "' detail review"
]); ?>

<form action="./?module=admin&controller=review&action=searchReviewForProductFull&id=<?= $pro['id'] ?>" class="form-inline" method="post">

    <div class="form-group">
        <input class="form-control" name="reviewSearch" placeholder="Search By Name..">
    </div>

    <button type="submit" class="btn btn-root  search-btn">
        <i class="fas fa-search"></i>
    </button>
</form>
<hr>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Review ID</th>
            <th>Customer</th>
            <th>Email</th>
            <th class="text-center">Rating</th>
            <th class="text-center">Content</th>
            <th class="text-center">Created At</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $model) : ?>
            <tr>
                <td><?= $model['id'] ?></td>
                <td><?= $model['fname'] . " " . $model['lname'] ?></td>

                <td><?= $model['email'] ?></td>
                <td class="text-center"><?= $model['rating'] ?>/5.0</td>

                <td class="text-center"><?= $model['content'] ?></td>

                <td class="text-center"><?= $model['created_at'] ?></td>
                <td class="text-center">

                    <a href="./?module=admin&controller=review&action=delete&id=<?= $model['id'] ?>&proId=<?= $pro['id'] ?>" class="btn btn-sm btn-danger btndelete" onclick="return confirm('Are you sure to delete this review ?')">
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