<?php
include("includes/admin_header.php");
include("../includes/db.php");
?>

<div class="container mt-4">
    <h2 class="mb-4">Manage Products</h2>

    <a href="admin_add_product.php" class="btn btn-primary mb-3">+ Add New Product</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price (₦)</th>
                <th width="180">Action</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $products = $conn->query("SELECT * FROM products ORDER BY id DESC");
            while ($row = $products->fetch_assoc()):
                ?>
                <tr>
                    <td><?= $row['id'] ?></td>

                    <td>
                        <img src="../uploads/<?= $row['image'] ?>" width="50" height="50" style="object-fit:cover;">
                    </td>

                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= number_format($row['price']) ?></td>

                    <td>
                        <a href="admin_edit_product.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Delete this product?');">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include("includes/admin_footer.php"); ?>