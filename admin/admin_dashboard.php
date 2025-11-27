<?php include("includes/admin_header.php"); ?>

<div class="container mt-4">

    <h2 class="fw-bold">Welcome back, <?= htmlspecialchars($_SESSION['admin_name']); ?> 👋</h2>
    <p class="text-muted mb-4">Here is an overview of your store performance today.</p>

    <div class="row g-4">

        <!-- Total Products -->
        <div class="col-md-4">
            <div class="card shadow-sm p-3 border-0">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle me-3">
                        <i class="bi bi-box-seam fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted">Total Products</h6>
                        <?php
                        include("../includes/db.php");
                        $p = $conn->query("SELECT COUNT(*) AS total FROM products")->fetch_assoc();
                        ?>
                        <h3 class="fw-bold"><?= $p['total']; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-md-4">
            <div class="card shadow-sm p-3 border-0">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle me-3">
                        <i class="bi bi-people fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted">Total Users</h6>
                        <?php
                        $u = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc();
                        ?>
                        <h3 class="fw-bold"><?= $u['total']; ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-md-4">
            <div class="card shadow-sm p-3 border-0">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle me-3">
                        <i class="bi bi-cart-check fs-3"></i>
                    </div>
                    <div>
                        <h6 class="text-muted">Total Orders</h6>
                        <?php
                        $o = $conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc();
                        ?>
                        <h3 class="fw-bold"><?= $o['total']; ?></h3>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Add More Stats or Charts -->
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card p-4 shadow-sm border-0">
                <h5 class="fw-bold mb-3">Recent Activity</h5>
                <p class="text-muted">You can add recent orders, system logs, low stock alerts, or graphs here.</p>
            </div>
        </div>
    </div>

</div>

<?php include("includes/admin_footer.php"); ?>