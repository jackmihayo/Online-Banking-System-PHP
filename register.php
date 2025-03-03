<?php
require "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$username = trim($_POST["username"]);
	$password = trim(password_hash($_POST["password"], PASSWORD_DEFAULT));
	$sql = "INSERT INTO users (username, password, balance) VALUES(?,?,1000.00)"; // Default balance is 1000.00
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("ss",$username,$password);
	if($stmt->execute()){
		echo "Registration successfully! <a href='/BANK/login.php'>Login here</a>";
	}else{
		echo "Error".$stmt->error;
	}
}else{
	echo "Form not submited!";
}

?>
<!DOCTYPE html>

<head>
	<title>Register Form</title>
</head>
<body>
	<h3>User Registration Form</h3>
	<form method="POST" action="">
		<label>Username</label>
		<input type="text" name="username"><br><br>
		<label>Password:</label>
		<input type="text" name="password"><br><br>
		<button type="submit">Register</button>
	</form>

</body>
</html>