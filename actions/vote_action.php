<?php
include_once('../config/db.php');

// Security Check: User ka login hona lazmi hai
if(!isset($_SESSION['user_id'])) { 
    header("Location: ../login.php"); 
    exit(); 
}

if(isset($_POST['vote'])) {
    $user_id = $_SESSION['user_id'];
    $vote_type = mysqli_real_escape_string($conn, $_POST['vote']); // 'up' ya 'down'
    $post_id = mysqli_real_escape_string($conn, $_POST['post_id']); // Redirection ke liye hamesha chahiye
    
    // Check karna ke vote Comment par hai ya Post par
    // Agar comment_id form se aa rahi hai to wo comment vote hai, warna post vote
    $comment_id = isset($_POST['comment_id']) ? mysqli_real_escape_string($conn, $_POST['comment_id']) : null;

    if ($comment_id) {
        // --- Logic for Comment Vote ---
        $check_query = "SELECT * FROM votes WHERE user_id = '$user_id' AND comment_id = '$comment_id'";
        $check_result = mysqli_query($conn, $check_query);

        if(mysqli_num_rows($check_result) > 0) {
            // Purana vote update karein
            mysqli_query($conn, "UPDATE votes SET vote_type = '$vote_type' WHERE user_id = '$user_id' AND comment_id = '$comment_id'");
        } else {
            // Naya vote insert karein (post_id yahan NULL rahega taake confusion na ho)
            mysqli_query($conn, "INSERT INTO votes (user_id, post_id, comment_id, vote_type) VALUES ('$user_id', NULL, '$comment_id', '$vote_type')");
        }
    } else {
        // --- Logic for Post Vote ---
        $check_query = "SELECT * FROM votes WHERE user_id = '$user_id' AND post_id = '$post_id' AND comment_id IS NULL";
        $check_result = mysqli_query($conn, $check_query);

        if(mysqli_num_rows($check_result) > 0) {
            // Purana vote update karein
            mysqli_query($conn, "UPDATE votes SET vote_type = '$vote_type' WHERE user_id = '$user_id' AND post_id = '$post_id' AND comment_id IS NULL");
        } else {
            // Naya vote insert karein
            mysqli_query($conn, "INSERT INTO votes (user_id, post_id, comment_id, vote_type) VALUES ('$user_id', '$post_id', NULL, '$vote_type')");
        }
    }

    // Wapis usi discussion thread par bhej dain
    header("Location: ../view-thread.php?id=$post_id");
} else {
    header("Location: ../index.php");
}
exit();
?>