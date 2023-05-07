<?php view('shared.admin.header', [
    'title' => 'Banner List'
]); ?>
<form action="./?module=admin&controller=banner&action=searchBannerFull" class="form-inline" method="post">

    <div class="form-group">
        <input class="form-control search-input" name="bannerSearch" placeholder="Search By Name..">
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
            <th>Site</th>
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
                <td><?= $model['site'] ?></td>
                <td>
                    <?php if ($model['status'] == 0) { ?>
                        <span class="badge badge-danger">Hidden</span>
                    <?php } else { ?>

                        <span class="badge badge-success">Visible</span>
                    <?php } ?>
                </td>
                <td><?= $model['created_at'] ?></td>
                <td>
                    <img src="./public/uploads/<?= $model['image'] ?>" width="60">
                </td>
                <td class="text-right">


                    <a href="./?module=admin&controller=banner&action=edit&id=<?= $model['id'] ?>" class="btn btn-sm btn-success">
                        <i class="fas fa-edit"></i>
                    </a>

                    <a href="./?module=admin&controller=banner&action=delete&id=<?= $model['id'] ?>" class="btn btn-sm btn-danger btndelete" onclick="return confirm('Are you sure to delete this banner ?')">
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