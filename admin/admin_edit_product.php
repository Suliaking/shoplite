<?php
include("includes/admin_header.php");
include("../includes/db.php");

$id = intval($_GET['id']); // Get product ID
$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

if (!$product) {
    echo "<div class='container mt-4'><p>Product not found.</p></div>";
    exit();
}

// Handle form submission
if (isset($_POST['update_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];

    // Image upload
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp, "../uploads/$image");
    } else {
        $image = $product['image']; // keep old image if not changed
    }

    $stmt = $conn->prepare("UPDATE products SET name=?, price=?, image=? WHERE id=?");
    $stmt->bind_param("sisi", $name, $price, $image, $id);
    $stmt->execute();

    header("Location: admin_products.php");
    exit();
}
?>

<div class="container mt-4">
    <h2>Edit Product</h2>

    <form method="POST" enctype="multipart/form-data" class="card p-3 shadow-sm">

        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($product['name']); ?>"
                required>
        </div>

        <div class="mb-3">
            <label>Price (₦)</label>
            <input type="number" name="price" class="form-control" value="<?= $product['price']; ?>" required>
        </div>

        <div class="mb-3">
            <label>Current Image</label><br>
            <img src="../uploads/<?= $product['image']; ?>" width="100" style="object-fit:cover;">
        </div>

        <div class="mb-3">
            <label>New Image (optional)</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" name="update_product" class="btn btn-primary flex-grow-1">
                <i class="bi bi-save"></i> Update
            </button>
            <a href="admin_products.php" class="btn btn-secondary flex-grow-1 text-center">
                <i class="bi bi-x-circle"></i> Cancel
            </a>
        </div>

    </form>
</div>

<?php include("includes/admin_footer.php"); ?>