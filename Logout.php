<?php
session_start();
session_destroy();
header("Location: /BANK/Login.php");
?>