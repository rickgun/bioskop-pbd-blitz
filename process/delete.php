<?php
	session_start();

	include '../modules/Database.php';

	$database = new Database();
	if($_GET['data'] == 'master-film')
	{
		include '../modules/MasterFilm.php';
		$masterfilm = new MasterFilm($database->connect());
		if($masterfilm->delete($_GET['kode']))
		{
			$_SESSION['alert'] = 'success';
			$_SESSION['report'] = "Data telah berhasil dihapus.";
			?><script> location.replace("../admin/master-film.php"); </script><?php
		}
		else
		{
			$_SESSION['alert'] = 'danger';
			$_SESSION['report'] = "Data telah gagal dihapus.";
			?><script> location.replace("../admin/master-film.php"); </script><?php
		}
	}
	else if($_GET['data'] == 'pelanggan')
	{
		include '../modules/Pelanggan.php';
		$pelanggan = new Pelanggan($database->connect());
		if($pelanggan->delete($_GET['kode']))
		{
			$_SESSION['alert'] = 'success';
			$_SESSION['report'] = "Data telah berhasil dihapus.";
			?><script> location.replace("../admin/data-pelanggan.php"); </script><?php
		}
		else
		{
			$_SESSION['alert'] = 'danger';
			$_SESSION['report'] = "Data telah gagal dihapus.";
			?><script> location.replace("../admin/data-pelanggan.php"); </script><?php
		}
	}
	else if($_GET['data'] == 'tayangan')
	{
		include '../modules/Tayangan.php';
		$tayangan = new Tayangan($database->connect());
		if($tayangan->delete($_GET['kode']))
		{
			$_SESSION['alert'] = 'success';
			$_SESSION['report'] = "Data telah berhasil dihapus.";
			?><script> location.replace("../admin/tayangan.php"); </script><?php
		}
		else
		{
			$_SESSION['alert'] = 'danger';
			$_SESSION['report'] = "Data telah gagal dihapus.";
			?><script> location.replace("../admin/tayangan.php"); </script><?php
		}
	}
	else if($_GET['data'] == 'pemesanan')
	{
		include '../modules/Pemesanan.php';
		$pemesanan = new Pemesanan($database->connect());
		if($pemesanan->delete($_GET['kode']))
		{
			$_SESSION['alert'] = 'success';
			$_SESSION['report'] = "Tiket pesanan telah berhasil dihapus.";
			?><script> location.replace("../user/cek-tiket.php"); </script><?php
		}
		else
		{
			$_SESSION['alert'] = 'danger';
			$_SESSION['report'] = "Tiket pesanan gagal dihapus, harap cek kembali.";
			?><script> location.replace("../user/cek-tiket.php"); </script><?php
		}
	}

?>
