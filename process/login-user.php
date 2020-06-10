<?php
	session_start();

	include '../modules/Database.php';
	include '../modules/Pelanggan.php';

	$database = new Database();
	$pelanggan = new Pelanggan($database->connect());
	$pelanggan->login($_POST['form-username'], $_POST['form-password']);
?>
