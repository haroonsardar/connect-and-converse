<?php
include_once('../config/db.php');

if (isset($_POST['submit_report'])) {
    if (!isset($_SESSION['user_id'])) { exit("Unauthorized"); }

    $user_id = $_SESSION['user_id'];
    $comment_id = mysqli_real_escape_string($conn, $_POST['comment_id']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);

    $query = "INSERT INTO flags (user_id, comment_id, reason) VALUES ('$user_id', '$comment_id', '$reason')";
    
    if (mysqli_query($conn, $query)) {
        // Find post id to redirect back
        $res = mysqli_query($conn, "SELECT post_id FROM comments WHERE id = '$comment_id'");
        $row = mysqli_fetch_assoc($res);
        header("Location: ../view-thread.php?id=".$row['post_id']."&reported=success");
    }
}
?>