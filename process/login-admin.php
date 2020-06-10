<?php
	session_start();

	include '../modules/Database.php';
	include '../modules/Admin.php';

	$database = new Database();
	$admin = new Admin($database->connect());
	$admin->login($_POST['form-username'], $_POST['form-password']);
?>
