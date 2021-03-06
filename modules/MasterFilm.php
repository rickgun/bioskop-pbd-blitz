<?php

	class MasterFilm
	{
		private $connect;

		function __construct($cn)
		{
			$this->connect = $cn;
		}

		function selectAllGenre()
		{
			$select = $this->connect->prepare("SELECT * FROM tblGenre;");
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function selectAllKategori()
		{
			$select = $this->connect->prepare("SELECT * FROM tblKategori;");
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function selectAllFilm()
		{
			$select = $this->connect->prepare("SELECT * FROM tblGenre, tblKategori, tblMasterFilm WHERE tblGenre.id_genre = tblMasterFilm.id_genre AND tblKategori.id_kategori = tblMasterFilm.id_kategori;");
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function selectAllFilmDescView()
		{
			$select = $this->connect->prepare("SELECT * FROM tblGenre, tblKategori, tblMasterFilm WHERE tblGenre.id_genre = tblMasterFilm.id_genre AND tblKategori.id_kategori = tblMasterFilm.id_kategori ORDER BY tblMasterFilm.kode_film DESC;");
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function selectFilmByKode($kode)
		{
			$select = $this->connect->prepare('SELECT * FROM tblMasterFilm WHERE kode_film = ?;');
			$select->bindParam(1, $kode);
			$select->execute();
			$data = $select->fetch(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function insert($judul, $production, $idgenre, $idkategori, $rating, $cover)
		{
			$data = array(null, $idgenre, $idkategori, $judul, $production, $rating, $cover);
			$insert = $this->connect->prepare('INSERT INTO tblMasterFilm VALUES (?,?,?,?,?,?,?);');

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
			$select = $this->connect->prepare('SELECT * FROM tblMasterFilm WHERE kode_film = ?;');
			$select->bindParam(1, $kode);
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(sizeof($data) != 0)
			{
				$select1 = $this->connect->prepare('SELECT * FROM tblTayangan WHERE kode_film = ?;');
				$select1->bindParam(1, $kode);
				$select1->execute();
				$data = $select1->fetchAll(PDO::FETCH_ASSOC);

				foreach($data as $datatayang)
				{
					$delete1 = $this->connect->prepare('DELETE FROM tblPemesanan WHERE kode_tayangan = ?;');
					$delete1->bindParam(1, $datatayang['kode_tayangan']);
					$delete1->execute();
				}
				$delete2 = $this->connect->prepare('DELETE FROM tblTayangan WHERE kode_film = ?;');
				$delete2->bindParam(1, $kode);
				$delete3 = $this->connect->prepare('DELETE FROM tblMasterFilm WHERE kode_film = ?;');
				$delete3->bindParam(1, $kode);
	
				if($delete2->execute() && $delete3->execute())
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
