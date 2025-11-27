<?php
include("includes/admin_header.php");
include("../includes/db.php");
?>

<div class="container mt-4">
    <h2 class="mb-4">Manage Orders</h2>

```
<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>User</th>
                    <th>Products</th>
                    <th>Total (₦)</th>
                    <th>Status</th>
                    <th>Order Date</th>
                    <th width="180">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch orders with user info
                $orders = $conn->query("
                    SELECT o.id AS order_id, o.total_amount, o.status, o.created_at, u.name AS user_name
                    FROM orders o
                    JOIN users u ON o.user_id = u.id
                    ORDER BY o.id DESC
                ");

                if ($orders->num_rows == 0):
                    ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-3">
                            No orders found.
                        </td>
                    </tr>
                <?php else:
                    while ($order = $orders->fetch_assoc()):
                        $order_id = $order['order_id'];

                        // Fetch products for this order
                        $stmt = $conn->prepare("
                            SELECT p.name, oi.quantity
                            FROM order_items oi
                            JOIN products p ON oi.product_id = p.id
                            WHERE oi.order_id = ?
                        ");
                        $stmt->bind_param("i", $order_id);
                        $stmt->execute();
                        $products_result = $stmt->get_result();

                        $product_list = [];
                        while ($p = $products_result->fetch_assoc()) {
                            $product_list[] = htmlspecialchars($p['name']) . " x " . intval($p['quantity']);
                        }
                        $products_str = implode(", ", $product_list);
                        ?>
                        <tr>
                            <td><?= $order['order_id'] ?></td>
                            <td><?= htmlspecialchars($order['user_name']) ?></td>
                            <td><?= $products_str ?></td>
                            <td>₦<?= number_format($order['total_amount']) ?></td>
                            <td>
                                <?php
                                // Color badges for status
                                $status = strtolower($order['status']);
                                $badge_class = 'secondary';
                                if ($status == 'pending') $badge_class = 'warning';
                                elseif ($status == 'completed') $badge_class = 'success';
                                elseif ($status == 'canceled') $badge_class = 'danger';
                                ?>
                                <span class="badge bg-<?= $badge_class ?>"><?= htmlspecialchars($order['status']) ?></span>
                            </td>
                            <td><?= date("d M Y, H:i", strtotime($order['created_at'])) ?></td>
                            <td>
                                <a href="edit_order.php?id=<?= $order['order_id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <a href="delete_order.php?id=<?= $order['order_id'] ?>" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this order?');">
                                    <i class="bi bi-trash"></i> Delete
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
