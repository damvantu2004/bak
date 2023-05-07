<?php view('shared.admin.header', [
    'title' => 'Edit Account'
]); ?>
<form action="./?module=admin&controller=account&action=update&id=<?= $_GET['id'] ?>" method="POST" role="form" name="categoryForm" onsubmit="">
    <section class="checkout p-50">
        <div class="container">
            <div class="row">

                <div class="col-md-9" style="margin: 0 auto">

                    <div class="bill-form-block">
                        <h2>
                            Account details
                        </h2>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="fname">First name</label>
                                <input value="<?= $user['fname'] ?>" type="text" name="fname" id="fname" class="form-control" aria-describedby="helpId" disabled>

                            </div>

                            <div class="col-md-6">
                                <label for="lname">Last name</label>
                                <input value="<?= $user['lname'] ?>" type="text" name="lname" id="lname" class="form-control" aria-describedby="helpId" disabled>



                            </div>


                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="email">Email address</label>
                                <input value="<?= $user['email'] ?>" type="text" name="email" id="email" class="form-control" aria-describedby="helpId" disabled>

                            </div>

                            <div class="col-md-6">
                                <label for="phone">Phone number</label>
                                <input value="<?= $user['phone'] ?>" type="text" name="phone" id="phone" class="form-control" aria-describedby="helpId" disabled>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="province">Province/City</label>


                            <input value="<?= $user['province'] ?>" type="text" class="form-control" disabled>


                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>

                            <input value="<?= $user['address'] ?>" type="text" name="address" id="address" class="form-control" aria-describedby="helpId" disabled>
                        </div>


                        <h2>Set account status</h2>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <small id="helpId" class="text-muted">Blocked user will not be able to place order or review products</small>
                            <select name="status" class="form-control">
                                <option value="1" <?= $user['status'] == '1' ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= $user['status'] == '0' ? 'selected' : '' ?>>Blocked</option>
                            </select>

                        </div>
                        <button type="submit" class="btn btn-primary">Save Data</button>
                    </div>

                </div>




            </div>
        </div>
    </section>
</form>
<?php view('shared.admin.footer'); ?>