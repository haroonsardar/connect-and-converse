<?php include 'includes/header.php'; 
if(!isset($_GET['id'])) { header("Location: index.php"); exit(); }
$post_id = mysqli_real_escape_string($conn, $_GET['id']);

// Post details fetch karna
$query = "SELECT posts.*, users.username, users.profile_pic, categories.name as cat_name 
          FROM posts 
          JOIN users ON posts.user_id = users.id 
          JOIN categories ON posts.category_id = categories.id 
          WHERE posts.id = '$post_id'";
$result = mysqli_query($conn, $query);
$post = mysqli_fetch_assoc($result);

// Post ke Likes (Upvotes) count karna
$votes_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM votes WHERE post_id = '$post_id' AND comment_id IS NULL AND vote_type = 'up'");
$upvotes = ($votes_res) ? mysqli_fetch_assoc($votes_res)['total'] : 0;
?>

<div class="container mt-4 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-5 col-sm-12">
            
            <div class="card border-0 shadow-sm mb-3" style="border-radius: 10px;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <a href="view-profile.php?username=<?php echo $post['username']; ?>">
                            <img src="uploads/profiles/<?php echo $post['profile_pic']; ?>" class="rounded-circle me-2 border" width="35" height="35" style="object-fit:cover;">
                        </a>
                        <div>
                            <h6 class="mb-0 fw-bold small">
                                <a href="view-profile.php?username=<?php echo $post['username']; ?>" class="text-dark text-decoration-none">
                                    <?php echo $post['username']; ?>
                                </a>
                            </h6>
                            <span style="font-size: 9px;" class="text-muted text-uppercase fw-medium"><?php echo $post['cat_name']; ?> • <?php echo date('M d', strtotime($post['created_at'])); ?></span>
                        </div>
                    </div>
                    
                    <h5 class="fw-bold mb-2" style="font-size: 1.1rem;"><?php echo $post['title']; ?></h5>
                    <p class="text-secondary mb-3 small" style="line-height: 1.5;"><?php echo nl2br($post['content']); ?></p>
                    
                    <?php if(!empty($post['image'])): ?>
                        <div class="rounded-3 overflow-hidden mb-3 border">
                            <img src="uploads/posts/<?php echo $post['image']; ?>" class="img-fluid w-100" style="max-height: 400px; object-fit: cover;">
                        </div>
                    <?php endif; ?>

                    <div class="d-flex align-items-center justify-content-between border-top pt-2 mt-2">
                        <div class="d-flex gap-2">
                            <?php if(isset($_SESSION['user_id'])): ?>
                            <form action="actions/vote_action.php" method="POST" class="d-inline">
                                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                                <button type="submit" name="vote" value="up" class="btn btn-light btn-sm rounded-pill px-2 border-0" style="background: #f0f2f5;">
                                    <i class="fas fa-heart text-danger me-1 small"></i> <span class="small fw-bold"><?php echo $upvotes; ?></span>
                                </button>
                                <button type="submit" name="vote" value="down" class="btn btn-light btn-sm rounded-pill border-0" style="background: #f0f2f5;">
                                    <i class="fas fa-thumbs-down text-muted small"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>
                        <span class="text-muted" style="font-size: 10px;">ID: #<?php echo $post_id; ?></span>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <form action="actions/comment_action.php" method="POST" class="d-flex gap-2 mb-3">
                        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                        <input name="comment_text" class="form-control form-control-sm border-0 shadow-sm rounded-pill px-3" placeholder="Add a comment..." required>
                        <button type="submit" name="add_comment" class="btn btn-primary btn-sm rounded-circle" style="width: 31px; height: 31px;">
                            <i class="fas fa-paper-plane small"></i>
                        </button>
                    </form>
                <?php endif; ?>

                <div id="comments-list" class="pb-5">
                    <?php
                    $c_query = "SELECT comments.*, users.username, users.profile_pic FROM comments 
                                JOIN users ON comments.user_id = users.id 
                                WHERE post_id = '$post_id' ORDER BY created_at DESC";
                    $c_result = mysqli_query($conn, $c_query);
                    while($comment = mysqli_fetch_assoc($c_result)):
                        $comment_id = $comment['id'];
                        // Comment score calculate karna (Upvotes - Downvotes)
                        $score_query = "SELECT 
                            (SELECT COUNT(*) FROM votes WHERE comment_id = '$comment_id' AND vote_type = 'up') - 
                            (SELECT COUNT(*) FROM votes WHERE comment_id = '$comment_id' AND vote_type = 'down') as score";
                        $score_data = mysqli_fetch_assoc(mysqli_query($conn, $score_query));
                        $score = $score_data['score'];
                    ?>
                    <div class="card border-0 shadow-none bg-transparent mb-3">
                        <div class="card-body p-0 ps-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <p class="small mb-1">
                                    <span class="fw-bold me-1 text-dark"><?php echo $comment['username']; ?></span>
                                    <span class="text-secondary"><?php echo $comment['comment_text']; ?></span>
                                </p>
                            </div>
                            
                            <div class="d-flex align-items-center gap-3">
                                <div class="d-flex align-items-center gap-2">
                                    <form action="actions/vote_action.php" method="POST" class="d-inline">
                                        <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>">
                                        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                                        <button type="submit" name="vote" value="up" class="btn p-0 border-0 bg-transparent text-success" style="font-size: 11px;">
                                            <i class="fas fa-arrow-up"></i>
                                        </button>
                                    </form>
                                    
                                    <span class="fw-bold text-muted" style="font-size: 11px;"><?php echo $score; ?></span>
                                    
                                    <form action="actions/vote_action.php" method="POST" class="d-inline">
                                        <input type="hidden" name="comment_id" value="<?php echo $comment_id; ?>">
                                        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                                        <button type="submit" name="vote" value="down" class="btn p-0 border-0 bg-transparent text-danger" style="font-size: 11px;">
                                            <i class="fas fa-arrow-down"></i>
                                        </button>
                                    </form>
                                </div>
                                
                                <?php if(isset($_SESSION['user_id'])): ?>
                                <button class="btn btn-link text-muted p-0 border-0 shadow-none" onclick="openReportModal(<?php echo $comment['id']; ?>)">
                                    <i class="far fa-flag" style="font-size: 10px;"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="reportModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <form action="actions/report_action.php" method="POST" class="modal-content border-0 shadow">
            <div class="modal-body p-3">
                <h6 class="fw-bold mb-3 small text-danger">Report Comment</h6>
                <input type="hidden" name="comment_id" id="report_comment_id">
                <select name="reason" class="form-select form-select-sm bg-light border-0 mb-3" required>
                    <option value="Spam">Spam</option>
                    <option value="Inappropriate">Inappropriate</option>
                    <option value="Harassment">Harassment</option>
                </select>
                <div class="d-flex gap-2">
                    <button type="submit" name="submit_report" class="btn btn-danger btn-sm w-100 rounded-pill">Report</button>
                    <button type="button" class="btn btn-light btn-sm w-100 rounded-pill border" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function openReportModal(id) {
    document.getElementById('report_comment_id').value = id;
    new bootstrap.Modal(document.getElementById('reportModal')).show();
}
</script>

<?php include 'includes/footer.php'; ?>