<?php
include("includes/admin_header.php");
include("../includes/db.php");
?>

<div class="container mt-4">
    <h2 class="mb-4">Manage Users</h2>

    ```
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registered On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $users = $conn->query("SELECT * FROM users ORDER BY id DESC");

                    if ($users->num_rows == 0):
                        ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">No users found.</td>
                        </tr>
                    <?php else:
                        while ($user = $users->fetch_assoc()):
                            ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= htmlspecialchars($user['name']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= date("d M Y, H:i", strtotime($user['created_at'])) ?></td>
                                <td>
                                    <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this user?');">
                                        <i class="bi bi-trash"></i> Delete
                                    </a>
                                    <a href="send_email.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-info">
                                        <i class="bi bi-envelope"></i> Email
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    ```

</div>

<?php include("includes/admin_footer.php"); ?>