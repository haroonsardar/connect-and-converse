<?php include 'includes/header.php'; ?>

<div class="container mt-4 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h4 class="fw-bold mb-4 text-primary"><i class="fas fa-search me-2"></i>Global Search</h4>
            
            <form action="search.php" method="GET" class="card border-0 shadow-sm p-4 mb-5" style="border-radius: 15px;">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="small fw-bold text-muted mb-1">Keywords</label>
                        <input type="text" name="keyword" class="form-control border-0 bg-light py-2" placeholder="Search title, tags, or users..." value="<?php echo $_GET['keyword'] ?? ''; ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="small fw-bold text-muted mb-1">Category</label>
                        <select name="category" class="form-select border-0 bg-light py-2">
                            <option value="">All Categories</option>
                            <?php 
                            $cats = mysqli_query($conn, "SELECT * FROM categories");
                            while($c = mysqli_fetch_assoc($cats)) {
                                $selected = (isset($_GET['category']) && $_GET['category'] == $c['id']) ? 'selected' : '';
                                echo "<option value='{$c['id']}' $selected>{$c['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small fw-bold text-muted mb-1">Published Date</label>
                        <input type="date" name="date" class="form-control border-0 bg-light py-2" value="<?php echo $_GET['date'] ?? ''; ?>">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Search</button>
                    </div>
                </div>
            </form>

            <?php
            $keyword_provided = !empty($_GET['keyword']) || !empty($_GET['category']) || !empty($_GET['date']);
            
            if($keyword_provided):
                $key = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';
                
                // --- SECTION 1: USER SEARCH (Requirement: Find users via keywords) ---
                if(!empty($key)):
                    $u_res = mysqli_query($conn, "SELECT * FROM users WHERE username LIKE '%$key%' OR email LIKE '%$key%' LIMIT 4");
                    if(mysqli_num_rows($u_res) > 0): ?>
                        <h6 class="fw-bold text-muted mb-3 text-uppercase small" style="letter-spacing: 1px;">Matching Users</h6>
                        <div class="row mb-5">
                            <?php while($u = mysqli_fetch_assoc($u_res)): ?>
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm text-center p-3 h-100" style="border-radius: 12px;">
                                    <img src="uploads/profiles/<?php echo !empty($u['profile_pic']) ? $u['profile_pic'] : 'default.png'; ?>" class="rounded-circle mx-auto mb-2 border" width="55" height="55" style="object-fit:cover;">
                                    <a href="view-profile.php?username=<?php echo $u['username']; ?>" class="text-dark text-decoration-none fw-bold small">@<?php echo $u['username']; ?></a>
                                    <div class="text-muted" style="font-size: 10px;"><?php echo ucfirst($u['role']); ?></div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif;
                endif;

                // --- SECTION 2: DISCUSSIONS SEARCH (Requirement: Effective search bar for posts) ---
                echo '<h6 class="fw-bold text-muted mb-3 text-uppercase small" style="letter-spacing: 1px;">Discussions & Posts</h6>';
                
                $where = "WHERE 1=1";
                if(!empty($key)) {
                    // Keyword searches Title, Content, and Tags
                    $where .= " AND (posts.title LIKE '%$key%' OR posts.content LIKE '%$key%' OR posts.tags LIKE '%$key%')";
                }
                if(!empty($_GET['category'])) {
                    $cat = mysqli_real_escape_string($conn, $_GET['category']);
                    $where .= " AND posts.category_id = '$cat'";
                }
                if(!empty($_GET['date'])) {
                    $date = mysqli_real_escape_string($conn, $_GET['date']);
                    $where .= " AND DATE(posts.created_at) = '$date'";
                }

                $query = "SELECT posts.*, users.username, categories.name as cat_name 
                          FROM posts 
                          JOIN users ON posts.user_id = users.id 
                          JOIN categories ON posts.category_id = categories.id 
                          $where ORDER BY created_at DESC";
                $res = mysqli_query($conn, $query);

                if(mysqli_num_rows($res) > 0): ?>
                    <div class="row">
                        <?php while($row = mysqli_fetch_assoc($res)): ?>
                        <div class="col-md-6 mb-3">
                            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                                <div class="card-body p-3 d-flex flex-column">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="badge bg-light text-primary border small" style="font-size: 10px;"><?php echo $row['cat_name']; ?></span>
                                        <small class="text-muted" style="font-size: 10px;"><?php echo date('M d, Y', strtotime($row['created_at'])); ?></small>
                                    </div>
                                    <h6 class="fw-bold mb-2"><?php echo $row['title']; ?></h6>
                                    <p class="text-secondary small flex-grow-1" style="line-height: 1.4;">
                                        <?php echo substr(strip_tags($row['content']), 0, 110); ?>...
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                                        <small class="text-primary fw-bold">By @<?php echo $row['username']; ?></small>
                                        <a href="view-thread.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary rounded-pill px-3" style="font-size: 11px;">View Full Thread</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5 bg-white rounded shadow-sm">
                        <i class="fas fa-search-minus fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No discussions found matching your search criteria.</p>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="text-center py-5 opacity-50">
                    <i class="fas fa-filter fa-4x mb-3"></i>
                    <h5>Use the filters above to find specific content</h5>
                    <p class="small">Search by keywords, select a category, or pick a specific date.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>