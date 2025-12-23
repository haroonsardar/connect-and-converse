<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4 border-0 shadow-lg">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">Recover Password</h3>
                    <p class="text-muted small">Enter your university email to reset password</p>
                </div>
                
                <form action="actions/auth_action.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-control bg-light border-0" placeholder="name@university.edu" required>
                    </div>
                    <button type="submit" name="forgot_password" class="btn btn-primary w-100 py-2">Send Reset Link</button>
                </form>
                
                <div class="text-center mt-3">
                    <a href="login.php" class="text-decoration-none small">Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>