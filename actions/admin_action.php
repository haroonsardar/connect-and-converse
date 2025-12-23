<?php
include_once('../config/db.php');

// Security Check: Sirf authorized Admin hi action le sakay
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { 
    exit("Access Denied: Unauthorized Action"); 
}

// ==========================================
// 1. BLOCK USER LOGIC
// ==========================================
if (isset($_POST['block_user'])) {
    $id = mysqli_real_escape_string($conn, $_POST['user_id']);
    
    // Status ko 'blocked' par update karna
    $query = "UPDATE users SET status = 'blocked' WHERE id = '$id'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: ../admin/users.php?msg=blocked");
    } else {
        header("Location: ../admin/users.php?error=update_failed");
    }
    exit();
}

// ==========================================
// 2. UNBLOCK USER LOGIC
// ==========================================
if (isset($_POST['unblock_user'])) {
    $id = mysqli_real_escape_string($conn, $_POST['user_id']);
    
    // Status ko 'active' par update karna
    $query = "UPDATE users SET status = 'active' WHERE id = '$id'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: ../admin/users.php?msg=unblocked");
    } else {
        header("Location: ../admin/users.php?error=update_failed");
    }
    exit();
}

// ==========================================
// 3. DELETE USER LOGIC
// ==========================================
if (isset($_POST['delete_user'])) {
    $id = mysqli_real_escape_string($conn, $_POST['user_id']);
    
    // User ko permanently delete karna
    // Note: Discussion threads aur comments mein foreign keys ka khyal rakhein (ON DELETE CASCADE recommended)
    $query = "DELETE FROM users WHERE id = '$id'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: ../admin/users.php?msg=deleted");
    } else {
        header("Location: ../admin/users.php?error=delete_failed");
    }
    exit();
}

// Agar koi direct access kare baghair kisi action ke
header("Location: ../admin/dashboard.php");
exit();
?>