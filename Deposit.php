<!DOCTYPE html>
<head>
	<title>Deposit Form</title>
</head>
<body>
	<a href="/BANK/dashboard.php">Back to Dashboard</a>

	<h4>User Form of Deposit</h4>
<form method="POST">
<label>Amount(Tsh): </label>
<input type="number" name="amount"><br><br>
<button type="submit" name="Deposit">Deposit</button>
</form>
</body>
</html>




<?php
require "database.php";
session_start();

if (!isset($username) && (!isset($password))) {
	header("Location: /Bank/Login.php");
}
$user_id  = $_SESSION['user_id'];
$amount = $_POST['amount'];
if($amount > 0){
$conn->query("UPDATE users SET balance = balance + $amount WHERE id = $user_id");
$conn->query("INSERT INTO transactions (user_id, type, amount) VALUES($user_id, 'Deposit', $amount)");

echo "<b>$amount</b> Deposit Successfully ";
}else{
	echo "Invalid Amount";
}
?>

