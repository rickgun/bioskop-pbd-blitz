<?php

	class Tayangan
	{
		private $connect;

		function __construct($cn)
		{
			$this->connect = $cn;
		}

		function selectAllTayangan()
		{
			$select = $this->connect->prepare("
				SELECT tblMasterFilm.judul_film, DATE_FORMAT(tblTayangan.jammulai_tayangan,'%W, %e %M %Y') AS tanggal_tayangan, COUNT(tblTayangan.jammulai_tayangan) as jumlah_tayangan, tblTayangan.kode_film, DATE(tblTayangan.jammulai_tayangan) AS waktu_tayangan
				FROM tblMasterFilm, tblTayangan
				WHERE tblMasterFilm.kode_film = tblTayangan.kode_film
				GROUP BY DATE(tblTayangan.jammulai_tayangan) DESC, tblTayangan.kode_film ASC;");
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function selectTayanganByKodedanTanggal($kode, $tanggal)
		{
			$select = $this->connect->prepare("
				SELECT tblMasterFilm.judul_film, tblMasterFilm.cover_film, tblTayangan.kode_tayangan, DATE_FORMAT(tblTayangan.jammulai_tayangan,'%W, %e %M %Y') AS tanggal_tayangan, tblTayangan.harga_tayangan, tblTayangan.studio_tayangan, CONCAT(TIME_FORMAT(tblTayangan.jammulai_tayangan,'%H:%i'), ' - ', TIME_FORMAT(tblTayangan.jamselesai_tayangan,'%H:%i')) AS waktu_tayangan
				FROM tblMasterFilm, tblTayangan
				WHERE	tblMasterFilm.kode_film = tblTayangan.kode_film AND
						tblTayangan.kode_film = ".$kode." AND
						DATE(tblTayangan.jammulai_tayangan) = '".$tanggal."'
				ORDER BY tblTayangan.jammulai_tayangan ASC;");
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function selectTayanganByHari()
		{
			$select = $this->connect->prepare('SELECT tblMasterFilm.kode_film, tblMasterFilm.judul_film, tblMasterFilm.cover_film, tblTayangan.kode_tayangan, tblTayangan.studio_tayangan FROM tblMasterFilm, tblTayangan WHERE tblMasterFilm.kode_film = tblTayangan.kode_film AND DATE(tblTayangan.jammulai_tayangan) = CURDATE() AND TIME_FORMAT(tblTayangan.jammulai_tayangan,"%H:%i:%s") >= CURTIME() GROUP BY tblTayangan.studio_tayangan ASC;');
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function selectTayanganByStudioKodedanTanggal($studio, $kode, $tanggal)
		{
			$select = $this->connect->prepare("
				SELECT tblMasterFilm.judul_film, tblMasterFilm.cover_film, tblTayangan.kode_tayangan, DATE_FORMAT(tblTayangan.jammulai_tayangan,'%W, %e %M %Y') AS tanggal_tayangan, tblTayangan.harga_tayangan, tblTayangan.studio_tayangan, CONCAT(TIME_FORMAT(tblTayangan.jammulai_tayangan,'%H:%i'), ' - ', TIME_FORMAT(tblTayangan.jamselesai_tayangan,'%H:%i')) AS waktu_tayangan
				FROM tblMasterFilm, tblTayangan
				WHERE	tblMasterFilm.kode_film = tblTayangan.kode_film AND
						tblTayangan.studio_tayangan = ".$studio." AND
						tblTayangan.kode_film = ".$kode." AND
						DATE(tblTayangan.jammulai_tayangan) = '".$tanggal."'
				ORDER BY tblTayangan.jammulai_tayangan ASC;");
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function insert($kode_film, $harga, $studio, $jammulai, $jamselesai)
		{
			$data = array(null, $kode_film, $harga, $studio, $jammulai, $jamselesai);
			$insert = $this->connect->prepare('INSERT INTO tblTayangan VALUES (?,?,?,?,?,?);');

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
			$select = $this->connect->prepare('SELECT * FROM tblTayangan WHERE kode_tayangan = ?;');
			$select->bindParam(1, $kode);
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(sizeof($data) != 0)
			{
				$delete1 = $this->connect->prepare('DELETE FROM tblPemesanan WHERE kode_tayangan = ?;');
				$delete1->bindParam(1, $kode);
				$delete2 = $this->connect->prepare('DELETE FROM tblTayangan WHERE kode_tayangan = ?;');
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
