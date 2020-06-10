<?php
	session_start();

	include '../modules/Database.php';
	include '../modules/Pemesanan.php';

	$database = new Database();
	$pemesanan = new Pemesanan($database->connect());
	if($pemesanan->update($_POST['kode'], $_POST['seat'], $_POST['pembayaran']))
	{
		$_SESSION['alert'] = 'success';
		$_SESSION['report'] = "Tiket pesanan telah berhasil diubah.";
		?><script> location.replace("../user/cek-tiket.php"); </script><?php
	}
	else
	{
		$_SESSION['alert'] = 'danger';
		$_SESSION['report'] = "Tiket pesanan gagal diubah, harap cek kembali.";
		?><script> location.replace("../user/cek-tiket.php"); </script><?php
	}
?>
