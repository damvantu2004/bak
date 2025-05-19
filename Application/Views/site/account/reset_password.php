<?php
include './Application/Views/shared/site/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Đặt lại mật khẩu</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    
                    <form action="./?controller=verify&action=updatePassword" method="post" id="passwordResetForm">
                        <input type="hidden" name="token" value="<?= $token ?>">
                        
                        <div class="form-group mb-3">
                            <label for="password">Mật khẩu mới</label>
                            <input type="password" name="password" id="password" class="form-control" required minlength="6">
                            <small class="form-text text-muted">Mật khẩu phải có ít nhất 6 ký tự</small>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="confirm_password">Xác nhận mật khẩu</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required minlength="6">
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('passwordResetForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Mật khẩu xác nhận không khớp!');
    }
});
</script>

<?php
include './Application/Views/shared/site/footer.php';
?> 