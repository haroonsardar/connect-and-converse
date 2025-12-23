<?php 
include '../includes/header.php'; 
// Admin Check
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { header("Location: ../index.php"); exit(); }

// Stats Fetching
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM users WHERE role != 'admin'"))['t'];
$total_posts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM posts"))['t'];
$total_flags = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as t FROM flags WHERE status='pending'"))['t'];
?>

<div class="container mt-4 flex-grow-1">
    <h3 class="fw-bold mb-4 text-primary">Admin Control Panel</h3>
    
    <div class="row g-3 mb-5">
        <div class="col-md-4">
            <div class="card bg-primary text-white p-4 border-0 shadow-sm rounded-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div><h6 class="small text-uppercase">Total Students</h6><h3><?php echo $total_users; ?></h3></div>
                    <i class="fas fa-users fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white p-4 border-0 shadow-sm rounded-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div><h6 class="small text-uppercase">Discussions</h6><h3><?php echo $total_posts; ?></h3></div>
                    <i class="fas fa-comments fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white p-4 border-0 shadow-sm rounded-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div><h6 class="small text-uppercase">Pending Reports</h6><h3><?php echo $total_flags; ?></h3></div>
                    <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <h6 class="fw-bold mb-3 text-muted">QUICK MANAGEMENT</h6>
    <div class="row g-3">
        <div class="col-md-3">
            <a href="users.php" class="card border-0 shadow-sm p-4 text-center text-decoration-none text-dark h-100 btn-hover">
                <i class="fas fa-user-cog fa-2x mb-3 text-primary"></i>
                <h6 class="fw-bold mb-0">Manage Users</h6>
            </a>
        </div>
        <div class="col-md-3">
            <a href="posts.php" class="card border-0 shadow-sm p-4 text-center text-decoration-none text-dark h-100 btn-hover">
                <i class="fas fa-file-alt fa-2x mb-3 text-warning"></i>
                <h6 class="fw-bold mb-0">Manage Posts</h6>
            </a>
        </div>
        <div class="col-md-3">
            <a href="flagged.php" class="card border-0 shadow-sm p-4 text-center text-decoration-none text-dark h-100 btn-hover">
                <i class="fas fa-flag fa-2x mb-3 text-danger"></i>
                <h6 class="fw-bold mb-0">Manage Flags</h6>
            </a>
        </div>
        <div class="col-md-3">
            <a href="categories.php" class="card border-0 shadow-sm p-4 text-center text-decoration-none text-dark h-100 btn-hover">
                <i class="fas fa-tags fa-2x mb-3 text-success"></i>
                <h6 class="fw-bold mb-0">Categories</h6>
            </a>
        </div>
    </div>
</div>

<style>
.btn-hover:hover { background-color: #f8f9fa; transform: translateY(-5px); transition: 0.3s; box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
</style>

<?php include '../includes/footer.php'; ?>