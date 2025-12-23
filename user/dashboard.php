<?php 
include '../includes/header.php'; 
if(!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit(); }
$user_id = $_SESSION['user_id'];

// 1. Personal Stats & User Data Fetch karna
$user_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id"));
$post_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM posts WHERE user_id = $user_id"))['total'];
$comm_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM comments WHERE user_id = $user_id"))['total'];
?>

<div class="container mt-4 flex-grow-1">
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4 mb-4">
                <img src="../uploads/profiles/<?php echo !empty($user_data['profile_pic']) ? $user_data['profile_pic'] : 'default.png'; ?>" 
                     class="rounded-circle mx-auto mb-3 border p-1" width="100" height="100" style="object-fit:cover;">
                
                <h5 class="fw-bold mb-1"><?php echo $user_data['username']; ?></h5>
                <p class="badge bg-primary px-3 mb-3">Student</p>
                
                <div class="d-grid gap-2">
                    <a href="profile-settings.php" class="btn btn-outline-primary btn-sm rounded-pill">Edit Profile</a>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6 border-end">
                        <h6 class="fw-bold mb-0"><?php echo $post_count; ?></h6>
                        <small class="text-muted small">My Posts</small>
                    </div>
                    <div class="col-6">
                        <h6 class="fw-bold mb-0"><?php echo $comm_count; ?></h6>
                        <small class="text-muted small">Comments</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0 text-uppercase" style="letter-spacing: 1px;">My Recent Activity</h6>
                <button class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#createPostModal">
                    <i class="fas fa-plus me-1"></i> New Discussion
                </button>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0 text-primary"><i class="fas fa-users me-2"></i>Community Feed (Latest Discussions)</h6>
                </div>
                <div class="list-group list-group-flush border-top">
                    <?php
                    // Community posts fetch karna
                    $community_feed = mysqli_query($conn, "SELECT posts.*, users.username, users.profile_pic 
                                                           FROM posts 
                                                           JOIN users ON posts.user_id = users.id 
                                                           ORDER BY posts.created_at DESC LIMIT 5");
                    
                    if(mysqli_num_rows($community_feed) > 0):
                        while($post = mysqli_fetch_assoc($community_feed)):
                    ?>
                    <div class="list-group-item py-3">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="d-flex align-items-center">
                                <img src="../uploads/profiles/<?php echo $post['profile_pic']; ?>" class="rounded-circle me-2 border" width="30" height="30" style="object-fit:cover;">
                                <div>
                                    <h6 class="mb-0 small fw-bold"><?php echo $post['title']; ?></h6>
                                    <small class="text-muted" style="font-size: 10px;">By @<?php echo $post['username']; ?> • <?php echo date('M d', strtotime($post['created_at'])); ?></small>
                                </div>
                            </div>
                            <a href="../view-thread.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-light border py-0 px-3 rounded-pill" style="font-size: 11px;">View</a>
                        </div>
                    </div>
                    <?php 
                        endwhile;
                    else:
                        echo '<div class="p-4 text-center text-muted small">No community discussions found.</div>';
                    endif;
                    ?>
                </div>
                <div class="card-footer bg-light text-center py-2">
                    <a href="../index.php" class="small text-decoration-none fw-bold">View Full Community Feed</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createPostModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="../actions/post_action.php" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold">Start New Discussion</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label small fw-bold">Topic Title</label>
                    <input type="text" name="title" class="form-control bg-light border-0 py-2" placeholder="What is on your mind?" required>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Category</label>
                        <select name="category_id" class="form-select bg-light border-0" required>
                            <?php 
                            $cats = mysqli_query($conn, "SELECT * FROM categories");
                            while($c = mysqli_fetch_assoc($cats)) echo "<option value='{$c['id']}'>{$c['name']}</option>";
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Tags (Comma separated)</label>
                        <input type="text" name="tags" class="form-control bg-light border-0" placeholder="e.g. exams, sports">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold">Image Attachment</label>
                        <input type="file" name="post_image" class="form-control bg-light border-0">
                    </div>
                </div>
                <div class="mb-1">
                    <label class="form-label small fw-bold">Discussion Content</label>
                    <textarea name="content" id="dashboard_editor" rows="6" class="form-control bg-light border-0" placeholder="Details..." required></textarea>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="submit" name="create_post" class="btn btn-primary rounded-pill px-5 shadow">Publish Discussion</button>
            </div>
        </form>
    </div>
</div>

<script>
    if(typeof CKEDITOR !== 'undefined') {
        CKEDITOR.replace('dashboard_editor');
    }
</script>

<?php include '../includes/footer.php'; ?>