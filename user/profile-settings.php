<?php 
include '../includes/header.php'; 
if(!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit(); }
$user_id = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id"));
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold mb-4"><i class="fas fa-cog me-2"></i>Account Settings</h5>
                
                <form action="../actions/auth_action.php" method="POST" enctype="multipart/form-data">
                    <div class="text-center mb-4">
                        <img src="../uploads/profiles/<?php echo $user['profile_pic']; ?>" class="rounded-circle border p-1 mb-2" width="100" height="100">
                        <div class="small text-muted">Current Profile Picture</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Update Username</label>
                        <input type="text" name="username" class="form-control bg-light border-0" value="<?php echo $user['username']; ?>" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Change Profile Picture</label>
                        <input type="file" name="profile_pic" class="form-control bg-light border-0">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" name="update_profile" class="btn btn-primary px-4">Save Changes</button>
                        <a href="dashboard.php" class="btn btn-light border px-4">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>