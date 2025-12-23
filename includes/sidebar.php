<?php
$cat_query = "SELECT * FROM categories";
$cat_result = mysqli_query($conn, $cat_query);
?>
<div class="col-md-3">
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <h6 class="fw-bold mb-3">Search Hub</h6>
            <form action="search.php" method="GET">
                <div class="input-group">
                    <input type="text" name="query" class="form-control border-0 bg-light" placeholder="Keywords...">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h6 class="fw-bold mb-3">Categories</h6>
            <div class="list-group list-group-flush">
                <a href="index.php" class="list-group-item list-group-item-action border-0 px-0 small">
                    <i class="fas fa-border-all me-2 text-primary"></i> All Discussions
                </a>
                <?php while($cat = mysqli_fetch_assoc($cat_result)): ?>
                <a href="index.php?category=<?php echo $cat['id']; ?>" class="list-group-item list-group-item-action border-0 px-0 small">
                    <i class="fas fa-hashtag me-2 text-muted"></i> <?php echo $cat['name']; ?>
                </a>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>