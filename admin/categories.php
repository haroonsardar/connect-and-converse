<?php 
include '../includes/header.php'; 
// Security check: Sirf admin hi is page ko dekh sakay
if($_SESSION['role'] != 'admin') { header("Location: ../index.php"); exit(); }

// --- Logic: Add New Category ---
if (isset($_POST['add_category'])) {
    $cat_name = mysqli_real_escape_string($conn, $_POST['cat_name']);
    if(!empty($cat_name)) {
        mysqli_query($conn, "INSERT INTO categories (name) VALUES ('$cat_name')");
        echo "<script>window.location.href='categories.php?msg=added';</script>";
    }
}

// --- Logic: Delete Category ---
if (isset($_GET['delete'])) {
    $cat_id = mysqli_real_escape_string($conn, $_GET['delete']);
    mysqli_query($conn, "DELETE FROM categories WHERE id = '$cat_id'");
    echo "<script>window.location.href='categories.php?msg=deleted';</script>";
}
?>

<div class="container mt-4 flex-grow-1">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="fw-bold mb-0 text-primary"><i class="fas fa-plus-circle me-2"></i>Add New Category</h6>
                </div>
                <div class="card-body">
                    <form action="categories.php" method="POST" class="d-flex gap-2">
                        <input type="text" name="cat_name" class="form-control bg-light border-0" placeholder="e.g. Sports, Exams, Campus News" required>
                        <button type="submit" name="add_category" class="btn btn-primary px-4 rounded-pill">Add</button>
                    </form>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between">
                    <h6 class="fw-bold mb-0">Existing Categories</h6>
                    <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill">Total Labels</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light small text-uppercase">
                            <tr>
                                <th class="border-0">ID</th>
                                <th class="border-0">Category Name</th>
                                <th class="border-0 text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $res = mysqli_query($conn, "SELECT * FROM categories ORDER BY id DESC");
                            if(mysqli_num_rows($res) > 0):
                                while($row = mysqli_fetch_assoc($res)):
                            ?>
                            <tr>
                                <td class="small fw-bold">#<?php echo $row['id']; ?></td>
                                <td class="small"><?php echo $row['name']; ?></td>
                                <td class="text-end">
                                    <a href="categories.php?delete=<?php echo $row['id']; ?>" 
                                       class="btn btn-sm btn-outline-danger rounded-circle" 
                                       onclick="return confirm('Are you sure you want to delete this category? All posts in this category might be affected.')">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                endwhile; 
                            else:
                                echo '<tr><td colspan="3" class="text-center py-4 text-muted">No categories found. Add one above!</td></tr>';
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="text-center mt-3">
                <a href="dashboard.php" class="btn btn-link text-decoration-none small text-muted">
                    <i class="fas fa-arrow-left me-1"></i> Back to Control Panel
                </a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>