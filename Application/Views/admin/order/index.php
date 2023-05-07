<?php view('shared.admin.header', [
    'title' => 'Order List'
]); ?>
<form action="./?module=admin&controller=order&action=searchOrderFull" class="form-inline" method="post">

    <div class="form-group">
        <input class="form-control search-input" name="orderSearch" placeholder="Search...">
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
            <th>Phone</th>
            <th>Address</th>
            <th>Province</th>
            <th>Created at</th>
            <th>Status</th>
            <th class="text-center">Quantity</th>
            <th>Total</th>
            <th class="text-center"> Detail</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order) : ?>
            <tr>
                <td>
                    <?= $order['id'] ?>

                </td>

                <td>
                    <?= $order['fname'] . ' ' . $order['lname'] ?>

                </td>

                <td>
                    <?= $order['phone'] ?>
                </td>
                <td>
                    <?= $order['address'] ?>
                </td>
                <td>
                    <?= $order['province'] ?>
                </td>
                <td>
                    <?= $order['created_at'] ?>
                </td>
                <td>
                    <?php if ($order['status'] == 1) : ?>
                        <span class="badge badge-info">Pending</span>
                    <?php endif; ?>
                    <?php if ($order['status'] == 2) : ?>
                        <span class="badge badge-warning">Delivering</span>
                    <?php endif; ?>
                    <?php if ($order['status'] == 3) : ?>
                        <span class="badge badge-danger">Cancelled</span>
                    <?php endif; ?>
                    <?php if ($order['status'] == 0) : ?>
                        <span class="badge badge-success">Delivered</span>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <?= $order['quantity'] ?>
                </td>
                <td>
                    $<?= number_format($order['total'], 2, '.', '') ?>

                </td>
                <td class="text-center">
                    <a title="View order detail" href="./?module=admin&controller=order&action=detail&id=<?= $order['id'] ?>" class="btn btn-sm btn-success">
                        <i class="fas fa-info-circle"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>


</table>

<hr>

<?= $pagination ?>
<!-- Pagination  -->

<?php view('shared.admin.footer'); ?>