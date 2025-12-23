<?php include 'includes/header.php'; ?>

<div class="container mt-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card p-4 shadow-lg border-0" style="border-radius: 20px;">
                <div class="text-center mb-4">
                    <div class="mb-2">
                        <i class="fas fa-university text-primary fa-3x"></i>
                    </div>
                    <h2 class="fw-bold text-dark">Welcome Back</h2>
                    <p class="text-muted small">Log in to your student hub to join discussions</p>
                </div>

                <?php if(isset($_SESSION['success'])): ?>
                    <div class="alert alert-success border-0 shadow-sm p-2 small mb-3 animate__animated animate__fadeIn">
                        <i class="fas fa-check-circle me-2"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                    </div>
                <?php endif; ?>

                <?php if(isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger border-0 shadow-sm p-2 small mb-3 animate__animated animate__shakeX">
                        <i class="fas fa-exclamation-circle me-2"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <form action="actions/auth_action.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">University Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control bg-light border-0 py-2 small" placeholder="name@university.edu" required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label small fw-bold text-secondary">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-lock text-muted"></i></span>
                            <input type="password" id="loginPassword" name="password" class="form-control bg-light border-0 py-2 small" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="mb-4 text-end">
                        <a href="forgot-password.php" class="small text-decoration-none fw-medium text-primary">Forgot Password?</a>
                    </div>

                    <button type="submit" name="login" class="btn btn-primary w-100 py-2 rounded-pill shadow-sm fw-bold">
                        Sign In <i class="fas fa-sign-in-alt ms-2"></i>
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="small text-muted">New student? <a href="register.php" class="text-decoration-none fw-bold text-primary">Create an Account</a></p>
                </div>
            </div>

            <div class="text-center mt-3">
                <p class="text-muted" style="font-size: 11px;">&copy; 2025 Connect & Converse. All rights reserved.</p>
            </div>
        </div>
    </div>
</div>

<script>
    // Agar aap password dikhana chahein to yahan logic add ho sakti hai
</script>

<?php include 'includes/footer.php'; ?>