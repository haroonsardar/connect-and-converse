<?php 
include '../includes/header.php'; 
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') { header("Location: ../index.php"); exit(); }
?>

<div class="container mt-4 flex-grow-1">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0">Student Management Directory</h4>
        <a href="dashboard.php" class="btn btn-sm btn-dark rounded-pill px-3 shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light small text-uppercase">
                    <tr>
                        <th class="ps-4 py-3">User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM users WHERE LOWER(role) != 'admin' ORDER BY id DESC");
                    while($row = mysqli_fetch_assoc($res)):
                        $status = isset($row['status']) ? $row['status'] : 'active';
                    ?>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center py-2">
                                <img src="../uploads/profiles/<?php echo !empty($row['profile_pic']) ? $row['profile_pic'] : 'default.png'; ?>" 
                                     class="rounded-circle me-3 border" width="40" height="40" style="object-fit:cover;">
                                <span class="fw-bold">@<?php echo $row['username']; ?></span>
                            </div>
                        </td>
                        <td class="small"><?php echo $row['email']; ?></td>
                        <td><span class="badge bg-light text-primary border small"><?php echo ucfirst($row['role']); ?></span></td>
                        <td>
                            <span class="badge <?php echo ($status == 'active') ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'; ?> rounded-pill border">
                                <?php echo ucfirst($status); ?>
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <form action="../actions/admin_action.php" method="POST" class="d-inline">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <?php if($status == 'active'): ?>
                                    <button type="submit" name="block_user" class="btn btn-sm btn-outline-warning rounded-pill px-3">Block</button>
                                <?php else: ?>
                                    <button type="submit" name="unblock_user" class="btn btn-sm btn-outline-success rounded-pill px-3">Unblock</button>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>