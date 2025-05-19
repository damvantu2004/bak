<?php
include './Application/Views/shared/site/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Quên mật khẩu</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($message)): ?>
                        <div class="alert alert-success"><?= $message ?></div>
                    <?php endif; ?>
                    
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    
                    <form action="./?controller=verify&action=sendResetLink" method="post">
                        <div class="form-group mb-3">
                            <label for="email">Email đăng nhập</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                            <small class="form-text text-muted">Nhập email bạn đã dùng để đăng ký tài khoản. Chúng tôi sẽ gửi liên kết đặt lại mật khẩu đến địa chỉ này.</small>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Gửi liên kết đặt lại mật khẩu</button>
                            <a href="#" data-toggle="modal" data-target="#loginModal" class="btn btn-outline-secondary">Quay lại đăng nhập</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include './Application/Views/shared/site/footer.php';
?> 