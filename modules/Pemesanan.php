<?php

	class Pemesanan
	{
		private $connect;

		function __construct($cn)
		{
			$this->connect = $cn;
		}

		function selectAllPemesanan()
		{
			$select = $this->connect->prepare("
				SELECT	tblMasterFilm.judul_film,
						DATE_FORMAT(tblTayangan.jammulai_tayangan,'%W, %e %M %Y') as tanggal_tayangan,
						tblTayangan.studio_tayangan,
						CONCAT(TIME_FORMAT(tblTayangan.jammulai_tayangan,'%H:%i'), ' - ', TIME_FORMAT(tblTayangan.jamselesai_tayangan,'%H:%i')) as waktu_tayangan,
						COUNT(tblPemesanan.kode_pelanggan) as jumlah_pelanggan
				FROM tblMasterFilm, tblTayangan, tblPemesanan
				WHERE tblMasterFilm.kode_film = tblTayangan.kode_film AND tblTayangan.kode_tayangan = tblPemesanan.kode_tayangan
				GROUP BY tblTayangan.studio_tayangan ASC, DATE(tblTayangan.jammulai_tayangan) ASC;");
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function selectPemesananByKodeTayangan($kode)
		{
			$select = $this->connect->prepare('SELECT * FROM tblPemesanan WHERE kode_tayangan = ?;');
			$select->bindParam(1, $kode);
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function selectTotalPemesananByKodePelanggan($kode)
		{
			$select = $this->connect->prepare('SELECT COUNT(tblPemesanan.kode_tayangan) as total FROM tblTayangan, tblPemesanan WHERE tblTayangan.kode_tayangan = tblPemesanan.kode_tayangan AND DATE(tblTayangan.jammulai_tayangan) >= CURDATE() AND tblPemesanan.kode_pelanggan = ?;');
			$select->bindParam(1, $kode);
			$select->execute();
			$data = $select->fetch(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function selectPemesananByKodePemesanan($kode)
		{
			$select = $this->connect->prepare("
				SELECT	tblMasterFilm.judul_film, tblMasterFilm.cover_film,
						DATE_FORMAT(tblTayangan.jammulai_tayangan,'%W, %e %M %Y') as tanggal_tayangan,
						CONCAT(TIME_FORMAT(tblTayangan.jammulai_tayangan,'%H:%i'), ' - ', TIME_FORMAT(tblTayangan.jamselesai_tayangan,'%H:%i')) AS waktu_tayangan,
						tblTayangan.studio_tayangan, tblTayangan.harga_tayangan, tblPemesanan.seat,
						tblPemesanan.pembayaran, tblPemesanan.kode_pemesanan
				FROM	tblMasterFilm, tblTayangan, tblPemesanan
				WHERE	tblMasterFilm.kode_film = tblTayangan.kode_film AND tblTayangan.kode_tayangan = tblPemesanan.kode_tayangan AND
						DATE(tblTayangan.jammulai_tayangan) >= CURDATE() AND tblPemesanan.kode_pemesanan = ?;");
			$select->bindParam(1, $kode);
			$select->execute();
			$data = $select->fetch(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function selectPemesananByKodePelanggan($kode)
		{
			$select = $this->connect->prepare("SELECT tblPemesanan.kode_pemesanan, DATE_FORMAT(tblTayangan.jammulai_tayangan,'%W, %e %M %Y') as tanggal_tayang, tblMasterFilm.judul_film, CONCAT(TIME_FORMAT(tblTayangan.jammulai_tayangan,'%H:%i'), ' - ', TIME_FORMAT(tblTayangan.jamselesai_tayangan,'%H:%i')) AS waktu_tayang, tblTayangan.studio_tayangan, tblTayangan.kode_tayangan, tblPemesanan.seat, tblTayangan.harga_tayangan, tblPemesanan.pembayaran FROM tblMasterFilm, tblTayangan, tblPemesanan WHERE tblMasterFilm.kode_film = tblTayangan.kode_film AND tblTayangan.kode_tayangan = tblPemesanan.kode_tayangan AND DATE(tblTayangan.jammulai_tayangan) >= CURDATE() AND tblPemesanan.kode_pelanggan = ?;");
			$select->bindParam(1, $kode);
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function selectPemesananExpiredByKodePelanggan($kode)
		{
			$select = $this->connect->prepare("SELECT tblPemesanan.kode_pemesanan, DATE_FORMAT(tblTayangan.jammulai_tayangan,'%W, %e %M %Y') as tanggal_tayang, tblMasterFilm.judul_film, CONCAT(TIME_FORMAT(tblTayangan.jammulai_tayangan,'%H:%i'), ' - ', TIME_FORMAT(tblTayangan.jamselesai_tayangan,'%H:%i')) AS waktu_tayang, tblTayangan.studio_tayangan, tblPemesanan.seat, tblTayangan.harga_tayangan, tblPemesanan.pembayaran FROM tblMasterFilm, tblTayangan, tblPemesanan WHERE tblMasterFilm.kode_film = tblTayangan.kode_film AND tblTayangan.kode_tayangan = tblPemesanan.kode_tayangan AND DATE(tblTayangan.jammulai_tayangan) < CURDATE() AND tblPemesanan.kode_pelanggan = ?;");
			$select->bindParam(1, $kode);
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function selectLaporanBulanan($bulan, $tahun)
		{
			$select = $this->connect->prepare("
				SELECT	DAY(tblTayangan.jammulai_tayangan) AS X, SUM(tblTayangan.harga_tayangan) AS Y
				FROM	tblTayangan, tblPemesanan
				WHERE	tblTayangan.kode_tayangan = tblPemesanan.kode_tayangan AND
						MONTH(tblTayangan.jammulai_tayangan) = ? AND YEAR(tblTayangan.jammulai_tayangan) = ?
				GROUP BY DAY(tblTayangan.jammulai_tayangan) ASC;");
			$select->bindParam(1, $bulan);
			$select->bindParam(2, $tahun);
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function selectLaporanHarian($hari, $bulan, $tahun)
		{
			$select = $this->connect->prepare("
				SELECT	CONCAT(TIME_FORMAT(tblTayangan.jammulai_tayangan,'%H:%i'), ' - ', TIME_FORMAT(tblTayangan.jamselesai_tayangan,'%H:%i')) AS X, SUM(tblTayangan.harga_tayangan) AS Y
				FROM	tblTayangan, tblPemesanan
				WHERE	tblTayangan.kode_tayangan = tblPemesanan.kode_tayangan AND DAY(tblTayangan.jammulai_tayangan) = ? AND
						MONTH(tblTayangan.jammulai_tayangan) = ? AND YEAR(tblTayangan.jammulai_tayangan) = ?
				GROUP BY CONCAT(TIME_FORMAT(tblTayangan.jammulai_tayangan,'%H:%i'), ' - ', TIME_FORMAT(tblTayangan.jamselesai_tayangan,'%H:%i')) ASC;");
			$select->bindParam(1, $hari);
			$select->bindParam(2, $bulan);
			$select->bindParam(3, $tahun);
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function selectLaporanFilm($kode, $bulan, $tahun)
		{
			$select = $this->connect->prepare("
				SELECT	DAY(tblTayangan.jammulai_tayangan) AS X, SUM(tblTayangan.harga_tayangan) AS Y
				FROM	tblMasterFilm, tblTayangan, tblPemesanan
				WHERE	tblMasterFilm.kode_film = tblTayangan.kode_film AND tblTayangan.kode_tayangan = tblPemesanan.kode_tayangan AND
						tblMasterFilm.kode_film = ? AND MONTH(tblTayangan.jammulai_tayangan) = ? AND YEAR(tblTayangan.jammulai_tayangan) = ?
				GROUP BY DAY(tblTayangan.jammulai_tayangan) ASC;");
			$select->bindParam(1, $kode);
			$select->bindParam(2, $bulan);
			$select->bindParam(3, $tahun);
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(count($data) > 0)
				return $data;
		}

		function insert($kode_pelanggan, $kode_tayangan, $seat, $pembayaran)
		{
			$data = array(null, $kode_pelanggan, $kode_tayangan, $seat, $pembayaran);
			$insert = $this->connect->prepare('INSERT INTO tblPemesanan VALUES (?,?,?,?,?);');

			if($insert->execute($data))
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		function update($kode, $seat, $pembayaran)
		{
			$data = array($seat, $pembayaran, $kode);
			$update = $this->connect->prepare('UPDATE tblPemesanan SET seat = ?, pembayaran = ? WHERE kode_pemesanan = ?');

			if($update->execute($data))
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
			$select = $this->connect->prepare('SELECT * FROM tblPemesanan WHERE kode_pemesanan = ?;');
			$select->bindParam(1, $kode);
			$select->execute();
			$data = $select->fetchAll(PDO::FETCH_ASSOC);

			if(sizeof($data) != 0)
			{
				$delete = $this->connect->prepare('DELETE FROM tblPemesanan WHERE kode_pemesanan = ?;');
				$delete->bindParam(1, $kode);
				if ($delete->execute())
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
