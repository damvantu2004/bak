<?php
include './Application/Views/shared/site/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Đổi mật khẩu</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php endif; ?>
                    
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    
                    <form action="./?controller=verify&action=updatePassword2" method="post" id="changePasswordForm">
                        <div class="form-group mb-3">
                            <label for="current_password">Mật khẩu hiện tại</label>
                            <input type="password" name="current_password" id="current_password" class="form-control" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="new_password">Mật khẩu mới</label>
                            <input type="password" name="new_password" id="new_password" class="form-control" required minlength="6">
                            <small class="form-text text-muted">Mật khẩu phải có ít nhất 6 ký tự</small>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="confirm_password">Xác nhận mật khẩu mới</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required minlength="6">
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Cập nhật mật khẩu</button>
                            <a href="./?controller=verify&action=profile" class="btn btn-outline-secondary">Quay lại hồ sơ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (newPassword !== confirmPassword) {
        e.preventDefault();
        alert('Mật khẩu mới và xác nhận không khớp!');
    }
});
</script>

<?php
include './Application/Views/shared/site/footer.php';
?> 