<?php

	class Pelanggan
	{
		private $connect;

		function __construct($cn)
		{
			$this->connect = $cn;
		}

		function login($username, $password)
		{
			$_SESSION['report'] = '';
			$query = $this->connect->prepare('SELECT * FROM tblPelanggan WHERE username_pelanggan = ? AND password_pelanggan = ?');
			$query->bindParam(1, $username);
			$query->bindParam(2, $password);
			$query->execute();
			$data = $query->fetchAll();

			if(sizeof($data) != 0)
			{
				$_SESSION['user-name'] = $data[0]['nama_pelanggan'];
				$_SESSION['user-code'] = $data[0]['kode_pelanggan'];
				$_SESSION['level-login'] = 'pelanggan';
				header("Location: ../user/index.php");
			}
			else
			{
				$_SESSION['alert'] = 'danger';
				$_SESSION['report'] = 'Username atau Password yang anda masukkan salah.<br>';
				header('Location: ../index.php');
			}
		}

		function selectAllPelanggan()
		{
			$select = $this->connect->prepare("SELECT * FROM tblPelanggan;");
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function selectPelangganByKode($kode)
		{
			$select = $this->connect->prepare('SELECT * FROM tblPelanggan WHERE kode_pelanggan = ?;');
			$select->bindParam(1, $kode);
			$select->execute();
			$data = $select->fetch(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function insert($nama, $nohp, $email, $username, $password)
		{
			$data = array(null, $nama, $nohp, $email, $username, $password);
			$insert = $this->connect->prepare('INSERT INTO tblPelanggan VALUES (?,?,?,?,?,?);');

			if($insert->execute($data))
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		function delete($kode)
		{			
			$select = $this->connect->prepare('SELECT * FROM tblPelanggan WHERE kode_pelanggan = ?;');
			$select->bindParam(1, $kode);
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(sizeof($data) != 0)
			{
				$delete1 = $this->connect->prepare('DELETE FROM tblPemesanan WHERE kode_pelanggan = ?;');
				$delete1->bindParam(1, $kode);
				$delete2 = $this->connect->prepare('DELETE FROM tblPelanggan WHERE kode_pelanggan = ?;');
				$delete2->bindParam(1, $kode);

				if($delete1->execute() && $delete2->execute())
				{
					return true;
				}
	  			else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
	}
?>
