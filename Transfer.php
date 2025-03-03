<?php 
require "database.php";
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /BANK/Login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $recipient = trim($_POST['recipient']);
    $amount = trim($_POST['amount']);
    $user_id = $_SESSION['user_id'];

    // Validate input
    if (empty($recipient) || empty($amount) || $amount <= 0) {
        echo "Invalid input!";
        exit();
    }

    // Get recipient ID
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $recipient);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "Recipient not found!";
        exit();
    }
    
    $recipient_row = $result->fetch_assoc();
    $recipient_id = $recipient_row['id'];

    // Get sender balance
    $balanceResult = $conn->query("SELECT balance FROM users WHERE id = $user_id");
    $senderRow = $balanceResult->fetch_assoc();
    if ($amount > $senderRow['balance']) {
        echo "Insufficient balance!";
        exit();
    }

    // Perform transaction
    $conn->begin_transaction();
    try {
        // Deduct from sender
        $stmt1 = $conn->prepare("UPDATE users SET balance = balance - ? WHERE id = ?");
        $stmt1->bind_param("di", $amount, $user_id);
        $stmt1->execute();

        // Add to recipient
        $stmt2 = $conn->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
        $stmt2->bind_param("di", $amount, $recipient_id);
        $stmt2->execute();

        // Insert transaction record
        $stmt3 = $conn->prepare("INSERT INTO transactions (user_id, type, amount, recipient_id) VALUES (?, 'Transfer', ?, ?)");
        $stmt3->bind_param("idi", $user_id, $amount, $recipient_id);
        $stmt3->execute();
        $conn->commit();
        echo "Transfer successful! $amount sent to $recipient.";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Transaction failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transfer Form</title>
</head>
<body>
	<a href="/BANK/dashboard.php">Back to Dashboard</a>

    <h3>Transfer Funds</h3>
    <form method="POST">
        <label>Recipient:</label>
        <input type="text" name="recipient" required><br><br>
        <label>Amount:</label>
        <input type="number" name="amount" required><br><br>
        <button type="submit">Transfer</button>
    </form>
</body>
</html>
