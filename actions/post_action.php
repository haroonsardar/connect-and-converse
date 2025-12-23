<?php
include_once('../config/db.php');
if (!isset($_SESSION['user_id'])) { exit("Unauthorized"); }

// ==========================================
// USER: CREATE NEW POST
// ==========================================
if (isset($_POST['create_post'])) {
    $user_id = $_SESSION['user_id'];
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $tags = mysqli_real_escape_string($conn, $_POST['tags']);
    $image_name = "";

    // Image upload handling
    if (!empty($_FILES['post_image']['name'])) {
        $image_name = time() . '_' . $_FILES['post_image']['name'];
        move_uploaded_file($_FILES['post_image']['tmp_name'], "../uploads/posts/" . $image_name);
    }

    $query = "INSERT INTO posts (user_id, category_id, title, content, image, tags) VALUES ('$user_id', '$category_id', '$title', '$content', '$image_name', '$tags')";
    if (mysqli_query($conn, $query)) {
        header("Location: ../user/dashboard.php?msg=post_created");
    }
    exit();
}

// ==========================================
// ADMIN: DELETE POST LOGIC
// ==========================================
if (isset($_POST['delete_post_admin'])) {
    // Role check for safety
    if ($_SESSION['role'] != 'admin') { exit("Access Denied"); }

    $post_id = mysqli_real_escape_string($conn, $_POST['post_id']);

    // 1. Fetch image name to delete file from folder
    $post_res = mysqli_query($conn, "SELECT image FROM posts WHERE id = '$post_id'");
    $post_data = mysqli_fetch_assoc($post_res);
    
    if (!empty($post_data['image'])) {
        $file_path = "../uploads/posts/" . $post_data['image'];
        if (file_exists($file_path)) { unlink($file_path); }
    }

    // 2. Delete post from database
    $query = "DELETE FROM posts WHERE id = '$post_id'";
    if (mysqli_query($conn, $query)) {
        header("Location: ../admin/posts.php?msg=deleted");
    } else {
        header("Location: ../admin/posts.php?error=failed");
    }
    exit();
}
?>