<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BANK";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
	echo "Database not connected!";
}

//create database
/*
$sql = "CREATE DATABASE BANK";
if(mysqli_query($conn, $sql)){
	echo "Database succefully created!";
}else{
	echo "No Database";
}
*/

//select database
$conn->select_db("BANK");

//create users table
/*
$sql = "CREATE TABLE users(
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
username VARCHAR (255) UNIQUE NOT NULL,
password VARCHAR (10) NOT NULL,
balance DECIMAL(10,2) DEFAULT 0.00
)"; 
if(mysqli_query($conn, $sql)){
	echo "Table is created!";
}else{
	echo "Table not created!";
}
*/

/*
//create transaction table
$sql ="CREATE TABLE transactions(
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
user_id INT(6) UNSIGNED,
type ENUM('Deposit','Withdrawal','Transfer'),
amount DECIMAL(10,2),
recipient_id INT(6) UNSIGNED NULL,
transaction_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY(user_id) REFERENCES users(id),
FOREIGN KEY(recipient_id) REFERENCES users(id)
)";
if (mysqli_query($conn, $sql)) {
	echo "transactions createad";
}else{
	echo "not createad".mysqli_error($conn);
}
*/
?>