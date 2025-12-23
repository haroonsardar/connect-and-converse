<?php
include_once('../config/db.php');

if (isset($_POST['add_comment'])) {
    // 1. Security Check: Kya user logged in hai?
    if (!isset($_SESSION['user_id'])) { 
        exit("Unauthorized: Please login to comment."); 
    }

    $post_id = mysqli_real_escape_string($conn, $_POST['post_id']);
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username']; // Notification message ke liye
    $comment_text = mysqli_real_escape_string($conn, $_POST['comment_text']);

    // 2. Comment ko database mein insert karna
    $query = "INSERT INTO comments (post_id, user_id, comment_text) VALUES ('$post_id', '$user_id', '$comment_text')";
    
    if (mysqli_query($conn, $query)) {
        
        // --- LOGIC: Real-time Notification (Requirement) ---
        // Post ke owner (writer) ki detail nikalna taake usay notify kiya ja sakay
        $post_query = "SELECT user_id, title FROM posts WHERE id = '$post_id'";
        $post_res = mysqli_query($conn, $post_query);
        
        if ($post_info = mysqli_fetch_assoc($post_res)) {
            $owner_id = $post_info['user_id'];
            $post_title = $post_info['title'];

            // Sirf tab notify karein agar comment karne wala khud post ka owner nahi hai
            if ($owner_id != $user_id) {
                $subject = "New Reply on your Discussion: " . $post_title;
                $message = "Hello! User @" . $username . " has just commented on your post. Check it out now!";
                
                // sendEmailNotification function (jo humne config/db.php mein define kiya tha)
                sendEmailNotification($owner_id, $subject, $message);
            }
        }

        // 3. Wapis usi Discussion page par redirect karna
        header("Location: ../view-thread.php?id=$post_id");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: ../index.php");
}
exit();
?>