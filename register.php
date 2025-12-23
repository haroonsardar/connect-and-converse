<?php include 'includes/header.php'; ?>

<div class="container mt-5 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card p-4 shadow-lg border-0" style="border-radius: 20px;">
                <div class="text-center mb-4">
                    <div class="mb-2">
                        <i class="fas fa-user-plus text-primary fa-3x"></i>
                    </div>
                    <h2 class="fw-bold text-dark">Join the Hub</h2>
                    <p class="text-muted small">Create your student account to start discussing</p>
                </div>

                <?php if(isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger border-0 shadow-sm p-2 small mb-3 animate__animated animate__shakeX">
                        <i class="fas fa-exclamation-circle me-2"></i> <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>

                <form action="actions/auth_action.php" method="POST">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">Username</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-user text-muted"></i></span>
                            <input type="text" name="username" class="form-control bg-light border-0 py-2 small" placeholder="johndoe" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">University Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control bg-light border-0 py-2 small" placeholder="name@university.edu" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-lock text-muted"></i></span>
                            <input type="password" name="password" class="form-control bg-light border-0 py-2 small" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" name="register" class="btn btn-primary w-100 py-2 rounded-pill shadow-sm fw-bold">
                        Create Account <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="small text-muted">Already have an account? <a href="login.php" class="text-decoration-none fw-bold text-primary">Login Here</a></p>
                </div>
            </div>

            <div class="text-center mt-3">
                <p class="text-muted" style="font-size: 11px;">&copy; 2025 Connect & Converse - Built for Students ❤️</p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>