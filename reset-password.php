<?php 
include 'includes/header.php'; 
// Hum email URL parameter se le rahe hain (Simple FYP logic)
$email = isset($_GET['email']) ? $_GET['email'] : '';
?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4 border-0 shadow-lg">
                <h4 class="fw-bold text-center mb-4">Set New Password</h4>
                
                <form action="actions/auth_action.php" method="POST">
                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">New Password</label>
                        <input type="password" name="new_password" class="form-control bg-light border-0" placeholder="••••••••" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Confirm New Password</label>
                        <input type="password" name="confirm_password" class="form-control bg-light border-0" placeholder="••••••••" required>
                    </div>
                    
                    <button type="submit" name="reset_password" class="btn btn-success w-100 py-2">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>