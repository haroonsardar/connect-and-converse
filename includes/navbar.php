<?php
// Folder structure handle karne ke liye path logic
$current_page = basename(dirname($_SERVER['PHP_SELF']));
$path = ($current_page == 'user' || $current_page == 'admin') ? '../' : '';

// Logo link logic: Login ke baad Dashboard par jayega, Guest ke liye Home par
$brand_link = $path . "index.php"; 
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        $brand_link = $path . "admin/dashboard.php";
    } else {
        $brand_link = $path . "user/dashboard.php";
    }
}
?>

<nav class="navbar navbar-expand-lg sticky-top mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?php echo $brand_link; ?>">
            <i class="fas fa-comments me-2"></i>Connect&Converse
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                
                <?php if(!isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $path; ?>index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $path; ?>login.php">Login</a></li>
                    <li class="nav-item"><a class="btn btn-warning btn-sm ms-2" href="<?php echo $path; ?>register.php">Register</a></li>
                
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $path; ?>user/dashboard.php">Dashboard</a>
                    </li>
                    
                    <?php if($_SESSION['role'] == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-warning" href="<?php echo $path; ?>admin/dashboard.php">Admin Panel</a>
                        </li>
                    <?php endif; ?>
                    
                    <li class="nav-item">
                        <a class="btn btn-light btn-sm ms-2" href="<?php echo $path; ?>logout.php">Logout</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>