<?php
	class Admin
	{
		private $connect;

		function __construct($cn)
		{
			$this->connect = $cn;
		}

		function login($username, $password)
		{
			$_SESSION['report'] = '';
			$query = $this->connect->prepare('SELECT * FROM tblAdmin WHERE username_admin = ? AND password_admin = ?');
			$query->bindParam(1, $username);
			$query->bindParam(2, $password);
			$query->execute();
			$data = $query->fetchAll();

			if(sizeof($data) != 0)
			{
				$_SESSION['admin-name'] = $data[0]['nama_admin'];
				$_SESSION['level-login'] = 'admin';
				header("Location: ../admin/index.php");
			}
			else
			{
				$_SESSION['alert'] = 'danger';
				$_SESSION['report'] = 'Username atau Password yang anda masukkan salah.<br>';
				header('Location: ../index.php');
			}
		}
	}
?>		
