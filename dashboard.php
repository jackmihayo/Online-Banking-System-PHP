<?php
require "database.php";
session_start();

if(!isset($_SESSION['user_id'])){
	header("Location: /BANK/login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

//
$sql ="SELECT username, balance FROM users WHERE id= ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id); //sql inject user_id to database
$stmt->execute(); // run and get result
$stmt->bind_result($username, $balance); //store result
$stmt->fetch(); //retrieve result from database

?>
<p>Welcome, <b><?php echo $username; ?></b></p>
<p>You are balance is: <b><?php echo $balance; ?></b></p>


	
<a href="/BANK/Deposit.php">Deposit</a>
<a href="/BANK/Withdraw.php">Withdrawal</a>
<a href="/BANK/Transfer.php">Transfer</a>
<a href="/BANK/Logout.php">Logout</a>
