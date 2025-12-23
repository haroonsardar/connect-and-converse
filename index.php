<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>

        <div class="col-md-9">
            <h4 class="fw-bold mb-4 text-dark">Latest Discussions</h4>

            <?php
            $where = "";
            if(isset($_GET['category'])) {
                $cat_id = mysqli_real_escape_string($conn, $_GET['category']);
                $where = "WHERE posts.category_id = '$cat_id'";
            }

            $post_query = "SELECT posts.*, users.username, users.profile_pic, categories.name as cat_name 
                           FROM posts 
                           JOIN users ON posts.user_id = users.id 
                           JOIN categories ON posts.category_id = categories.id 
                           $where 
                           ORDER BY posts.created_at DESC";
            $post_result = mysqli_query($conn, $post_query);

            if(mysqli_num_rows($post_result) > 0):
                while($post = mysqli_fetch_assoc($post_result)):
            ?>
                <div class="card mb-3 border-0 shadow-sm post-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="uploads/profiles/<?php echo $post['profile_pic']; ?>" class="rounded-circle me-2 border" width="40" height="40" style="object-fit:cover;">
                            <div>
                                <h6 class="mb-0 fw-bold"><?php echo $post['username']; ?></h6>
                                <small class="text-muted"><?php echo date('M d, Y', strtotime($post['created_at'])); ?> in <span class="badge bg-light text-primary"><?php echo $post['cat_name']; ?></span></small>
                            </div>
                        </div>
                        <h5 class="card-title fw-bold">
                            <a href="view-thread.php?id=<?php echo $post['id']; ?>" class="text-dark text-decoration-none"><?php echo $post['title']; ?></a>
                        </h5>
                        <p class="card-text text-secondary">
                            <?php echo substr(strip_tags($post['content']), 0, 150) . '...'; ?>
                        </p>
                        <a href="view-thread.php?id=<?php echo $post['id']; ?>" class="btn btn-link p-0 text-decoration-none fw-medium">Read Full Discussion <i class="fas fa-chevron-right small ms-1"></i></a>
                    </div>
                </div>
            <?php 
                endwhile;
            else:
                echo '<div class="alert alert-info border-0 shadow-sm">No discussions found yet.</div>';
            endif;
            ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>