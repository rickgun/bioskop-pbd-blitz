<?php
	session_start();

	include '../modules/Database.php';

	$database = new Database();
	if($_POST['jenis'] == 'master-film')
	{
		include '../modules/MasterFilm.php';
		$masterfilm = new MasterFilm($database->connect());

		$nametemp = explode(" ", strtolower($_POST["form-judul"]));
		$changeName = implode("-", $nametemp);
		$temp = explode(".", $_FILES["form-cover"]["name"]);
		$filename = $changeName . '.' . end($temp);

		$target_dir = "../assets/cover/";

		if (move_uploaded_file($_FILES["form-cover"]["tmp_name"], $target_dir . $filename))
		{
			if($masterfilm->insert($_POST['form-judul'], $_POST['form-production'], $_POST['form-genre'], $_POST['form-kategori'], $_POST['form-rating'], $filename))
			{
				$_SESSION['alert'] = 'success';
				$_SESSION['report'] = "Data ".$_POST['form-judul']." telah berhasil dimasukkan.";
				?><script> location.replace("../admin/master-film.php"); </script><?php
			}
			else
			{
				$_SESSION['alert'] = 'danger';
				$_SESSION['report'] = "Data ".$_POST['form-judul']." gagal dimasukkan.";
				?><script> location.replace("../admin/master-film.php"); </script><?php
			}
		}
		else
		{
			$_SESSION['alert'] = 'danger';
			$_SESSION['report'] = "Cover ". basename( $_FILES["form-cover"]["name"]). " gagal diunggah.";
		}
	}
	else if($_POST['jenis'] == 'data-pelanggan')
	{
		include '../modules/Pelanggan.php';
		$pelanggan = new Pelanggan($database->connect());
		if($pelanggan->insert($_POST['form-nama'], $_POST['form-nohp'], $_POST['form-email'], $_POST['form-username'], $_POST['form-password']))
		{
			$_SESSION['alert'] = 'success';
			$_SESSION['report'] = "Data ".$_POST['form-nama']." telah berhasil dimasukkan.";
			?><script> location.replace("../admin/data-pelanggan.php"); </script><?php
		}
		else
		{
			$_SESSION['alert'] = 'danger';
			$_SESSION['report'] = "Data ".$_POST['form-nama']." gagal dimasukkan.";
			?><script> location.replace("../admin/data-pelanggan.php"); </script><?php
		}
	}
	else if($_POST['jenis'] == 'tayangan')
	{
		include '../modules/Tayangan.php';
		$tayangan = new Tayangan($database->connect());
		if($tayangan->insert($_POST['form-film'], $_POST['form-harga'], $_POST['form-studio'], $_POST['form-jammulai'], $_POST['form-jamselesai']))
		{
			$_SESSION['alert'] = 'success';
			$_SESSION['report'] = "Data tayangan telah berhasil dimasukkan.";
			?><script> location.replace("../admin/tayangan.php"); </script><?php
		}
		else
		{
			$_SESSION['alert'] = 'danger';
			$_SESSION['report'] = "Data tayangan gagal dimasukkan.";
			?><script> location.replace("../admin/tayangan.php"); </script><?php
		}
	}
	else if($_POST['jenis'] == 'pemesanan')
	{
		include '../modules/Pemesanan.php';
		$pemesanan = new Pemesanan($database->connect());
		if($pemesanan->insert($_SESSION['user-code'], $_POST['kode'], $_POST['seat'], $_POST['pembayaran']))
		{
			$_SESSION['alert'] = 'success';
			$_SESSION['report'] = "Tiket Anda telah berhasil dipesan.";
			header("Location: ../user/pesan-tiket.php?st=".$_POST['st']."&kode=".$_POST['kd']);
		}
		else
		{
			$_SESSION['alert'] = 'danger';
			$_SESSION['report'] = "Tiket Anda gagal dipesan, harap cek kembali.";
			header("Location: ../user/pesan-tiket.php?st=".$_POST['st']."&kode=".$_POST['kd']);
		}
	}
	else if($_POST['jenis'] == 'sign-up')
	{
		include '../modules/Pelanggan.php';
		$pelanggan = new Pelanggan($database->connect());
		$pelanggan->insert($_POST['form-nama'], $_POST['form-nohp'], $_POST['form-email'], $_POST['form-username'], $_POST['form-password']);
		?><script> location.replace("../index.php"); </script><?php
	}

?>
