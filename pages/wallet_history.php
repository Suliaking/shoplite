<?php
session_start();
include "../includes/db.php";

// Check if user is logged in
if (!isset($_SESSION['name'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['name'];

// Get user data
$userQ = $conn->prepare("SELECT id, name FROM users WHERE name = ?");
$userQ->bind_param("s", $name);
$userQ->execute();
$userResult = $userQ->get_result();

if ($userResult->num_rows !== 1) {
    die("User not found.");
}

$user = $userResult->fetch_assoc();
$user_id = $user['id'];

// Fetch wallet history
$historyQ = $conn->prepare("SELECT * FROM wallet_history WHERE user_id = ? ORDER BY id DESC");
$historyQ->bind_param("i", $user_id);
$historyQ->execute();
$history = $historyQ->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallet History</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

    <h2 class="mb-4">Wallet Transaction History</h2>

    <a href="profile.php" class="btn btn-secondary mb-3">⬅ Back to Profile</a>

    <div class="card shadow-sm">
        <div class="card-body">

            <?php if ($history->num_rows > 0): ?>
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Amount (₦)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $history->fetch_assoc()): ?>
                        <tr>
                            <td><?= date("F j, Y g:i A", strtotime($row['created_at'])) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>

                            <td>
                                <?php if ($row['type'] == "credit"): ?>
                                    <span class="badge bg-success">Credit</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Debit</span>
                                <?php endif; ?>
                            </td>

                            <td>₦<?= number_format($row['amount'], 2) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

            <?php else: ?>
                <p class="text-muted">No wallet transactions yet.</p>
            <?php endif; ?>

        </div>
    </div>

</div>

</body>
</html>
