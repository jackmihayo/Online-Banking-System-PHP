<?php 
require "database.php";

session_start();

if(!isset($user_id) && !isset($username)){
	header("Location: /BANK/Login.php");
	exit();
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$amount = trim($_POST['amount']);;
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT balance FROM users WHERE id = $user_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if($amount >0 && $row['balance']>= $amount){

    	//Instead of using prepare statement
    	$conn->query("UPDATE users SET balance = balance -$amount WHERE id = $user_id");
    	$conn->query("INSERT INTO transactions(user_id, amount, type) VALUES($user_id, $amount, 'Withdraw')");
    	echo "<p style= color: green; ><b>$amount</b> is successfully withdrawal</p>";
    
    }else{
    	echo "Insufficient balance";
    }

}
?>

<!DOCTYPE html>
<head>
	<title>Withdraw form</title>
</head>
<body>
	<a href="/BANK/dashboard.php">Back to Dashboard</a>

	
	<form method="POST">
	<h3>Withdraw Form</h3>
	<label>Amount:</label>
	<input type="number" name="amount"><br><br>
	<button type ="submit">Withdraw</button>
	</form>
</body>
</html>