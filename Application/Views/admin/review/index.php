<?php view('shared.admin.header', [
    'title' => 'Product Review'
]); ?>

<form action="./?module=admin&controller=review&action=searchReviewListFull" class="form-inline" method="post">

    <div class="form-group">
        <input class="form-control search-input" name="reviewSearch" placeholder="Search By Name..">
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
            <th>Product Name</th>
            <th>Image</th>
            <th class="text-center">Average Rating</th>
            <th class="text-center">No. of Reviews</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $model) : ?>
            <tr>
                <td><?= $model['id'] ?></td>
                <td><?= $model['name'] ?></td>
                <td>
                    <img src="./public/uploads/<?= $model['image'] ?>" width="60">
                </td>
                <td class="text-center"><?= $model['average_rating'] ?>/5.0</td>

                <td class="text-center"><?= $model['total_review'] ?></td>

                <td class="text-center">

                    <a href="./?module=admin&controller=review&action=reviewDetail&id=<?= $model['id'] ?>" class="btn btn-sm btn-success">
                        <i class="fas fa-info-circle"></i>
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