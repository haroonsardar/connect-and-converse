<?php include '../includes/header.php'; 
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { header("Location: ../index.php"); exit(); } ?>

<div class="container mt-4 flex-grow-1">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0 text-primary">Manage All Discussions</h4>
        <a href="dashboard.php" class="btn btn-sm btn-dark rounded-pill px-3 shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>

    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
        <div class="alert alert-success border-0 shadow-sm mb-4">Post deleted successfully.</div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3">Title & Author</th>
                        <th>Category</th>
                        <th>Published</th>
                        <th class="text-end pe-4">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $posts = mysqli_query($conn, "SELECT posts.*, users.username, categories.name as cat_name FROM posts JOIN users ON posts.user_id = users.id JOIN categories ON posts.category_id = categories.id ORDER BY created_at DESC");
                    if(mysqli_num_rows($posts) > 0):
                        while($row = mysqli_fetch_assoc($posts)): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold small"><?php echo $row['title']; ?></div>
                                <div class="text-muted" style="font-size: 10px;">By @<?php echo $row['username']; ?></div>
                            </td>
                            <td><span class="badge bg-light text-dark border small"><?php echo $row['cat_name']; ?></span></td>
                            <td class="small text-muted"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                            <td class="text-end pe-4">
                                <form action="../actions/post_action.php" method="POST" class="d-inline">
                                    <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete_post_admin" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('DANGER: This will permanently remove the discussion. Proceed?')">
                                        <i class="fas fa-trash-alt me-1"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; else: ?>
                        <tr><td colspan="4" class="text-center py-5 text-muted">No posts available in the system.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>