<?php 
include '../includes/header.php'; 
if($_SESSION['role'] != 'admin') { header("Location: ../index.php"); exit(); }

// Logic: Handle Flag Actions
if(isset($_GET['action']) && isset($_GET['id'])) {
    $flag_id = $_GET['id'];
    if($_GET['action'] == 'dismiss') {
        mysqli_query($conn, "DELETE FROM flags WHERE id = '$flag_id'");
    } elseif($_GET['action'] == 'delete_comment') {
        // First get comment_id from flag
        $flag_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT comment_id FROM flags WHERE id = '$flag_id'"));
        $comm_id = $flag_data['comment_id'];
        mysqli_query($conn, "DELETE FROM comments WHERE id = '$comm_id'");
        mysqli_query($conn, "DELETE FROM flags WHERE comment_id = '$comm_id'");
    }
    header("Location: flagged.php?msg=success");
}
?>

<div class="container mt-4 flex-grow-1">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="fw-bold mb-0 text-danger"><i class="fas fa-flag me-2"></i>Reported Content Moderation</h6>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light small text-uppercase">
                    <tr>
                        <th>Reporter</th>
                        <th>Comment Content</th>
                        <th>Reason</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $reports = mysqli_query($conn, "SELECT flags.*, users.username as reporter, comments.comment_text 
                                                    FROM flags 
                                                    JOIN users ON flags.user_id = users.id 
                                                    JOIN comments ON flags.comment_id = comments.id 
                                                    WHERE flags.status = 'pending'");
                    if(mysqli_num_rows($reports) > 0):
                        while($row = mysqli_fetch_assoc($reports)):
                    ?>
                    <tr>
                        <td class="small fw-bold">@<?php echo $row['reporter']; ?></td>
                        <td class="small text-secondary"><?php echo $row['comment_text']; ?></td>
                        <td><span class="badge bg-warning text-dark small"><?php echo $row['reason']; ?></span></td>
                        <td class="text-end">
                            <a href="flagged.php?action=dismiss&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Dismiss</a>
                            <a href="flagged.php?action=delete_comment&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger rounded-pill px-3">Remove Content</a>
                        </td>
                    </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="4" class="text-center py-4 text-muted">No pending reports. Everything is clean!</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>