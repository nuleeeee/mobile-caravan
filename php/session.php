<?php
session_start();
include "connect.php";

$loginsession = $_SESSION['login_user'];

if (!isset($loginsession)) {
	header('location:index.php');
	exit;
}
?>