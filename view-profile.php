<?php 
include 'includes/header.php'; 
if(!isset($_GET['username'])) { header("Location: index.php"); exit(); }

$username = mysqli_real_escape_string($conn, $_GET['username']);
$user_query = "SELECT * FROM users WHERE username = '$username'";
$user_res = mysqli_query($conn, $user_query);
$user_data = mysqli_fetch_assoc($user_res);

if(!$user_data) { echo "<div class='container mt-5'><h4>User not found!</h4></div>"; include 'includes/footer.php'; exit(); }
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center p-4">
                <img src="uploads/profiles/<?php echo $user_data['profile_pic']; ?>" class="rounded-circle mx-auto mb-3" width="120" height="120">
                <h4 class="fw-bold mb-0"><?php echo $user_data['username']; ?></h4>
                <p class="text-muted small">Member since <?php echo date('M Y', strtotime($user_data['created_at'])); ?></p>
                <hr>
                <div class="badge bg-soft-primary text-primary px-3 py-2">University Student</div>
            </div>
        </div>

        <div class="col-md-8">
            <h5 class="fw-bold mb-4">Discussions by <?php echo $user_data['username']; ?></h5>
            <?php
            $u_id = $user_data['id'];
            $posts = mysqli_query($conn, "SELECT * FROM posts WHERE user_id = '$u_id' ORDER BY created_at DESC");
            if(mysqli_num_rows($posts) > 0):
                while($p = mysqli_fetch_assoc($posts)):
            ?>
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-1"><a href="view-thread.php?id=<?php echo $p['id']; ?>" class="text-dark text-decoration-none"><?php echo $p['title']; ?></a></h6>
                        <small class="text-muted"><?php echo date('M d, Y', strtotime($p['created_at'])); ?></small>
                    </div>
                </div>
            <?php 
                endwhile;
            else:
                echo "<p class='text-muted'>This user hasn't started any discussions yet.</p>";
            endif;
            ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>