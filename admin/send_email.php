<?php
include("includes/admin_header.php");
include("../includes/db.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Make sure PHPMailer is included
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

if (!isset($_GET['id']))
    die("User not found.");
$user_id = intval($_GET['id']);

// Fetch user info
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0)
    die("User not found.");
$user = $result->fetch_assoc();

$message_sent = false;
$error = '';

if (isset($_POST['send_email'])) {
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    if (!empty($subject) && !empty($message)) {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'onalasuliamon@gmail.com'; // your Gmail
            $mail->Password = 'gatnwqnlhomhfhjj';                   // App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('onalasuliamon117@gmail.com', 'ShopLite Admin');
            $mail->addAddress($user['email'], $user['name']);

            //Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = nl2br(htmlspecialchars($message));
            $mail->AltBody = $message;

            $mail->send();
            $message_sent = true;
        } catch (Exception $e) {
            $error = "Mailer Error: " . $mail->ErrorInfo;
        }
    } else {
        $error = "Subject and message cannot be empty.";
    }
}
?>

<div class="container mt-4">
    <h2>Send Email to <?= htmlspecialchars($user['name']) ?></h2>

    <?php if ($message_sent): ?>
        <div class="alert alert-success">Email sent successfully!</div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label>Subject</label>
            <input type="text" name="subject" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Message</label>
            <textarea name="message" class="form-control" rows="6" required></textarea>
        </div>
        <button type="submit" name="send_email" class="btn btn-primary">Send Email</button>
        <a href="users.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include("includes/admin_footer.php"); ?>