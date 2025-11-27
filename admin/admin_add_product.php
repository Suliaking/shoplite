<?php
include("includes/admin_header.php");
include("../includes/db.php");

// Handle Add Product Form
if (isset($_POST['add_product'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Image Upload
    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    if (!empty($image)) {
        move_uploaded_file($tmp, "../uploads/$image");
    }

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $name, $price, $description, $image);
    $stmt->execute();

    header("Location: admin_products.php");
    exit();
}

?>

<div class="container mt-4">
    <h2 class="mb-4">Add New Product</h2>

    <div class="card shadow">
        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter product name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Price (₦)</label>
                    <input type="number" name="price" class="form-control" placeholder="Enter price" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Description</label>
                    <textarea name="description" class="form-control" rows="4"
                        placeholder="Write product details..."></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload Image</label>
                    <input type="file" name="image" class="form-control" required>
                </div>

                <button type="submit" name="add_product" class="btn btn-success">Add Product</button>
                <a href="admin_products.php" class="btn btn-secondary">Cancel</a>

            </form>

        </div>
    </div>
</div>

<?php include("includes/admin_footer.php"); ?>