<?php
	session_start();
	if(isset($_SESSION['level-login']))
	{
		if($_SESSION['level-login'] != 'pelanggan')
		{
			echo "<script>alert('Anda tidak dapat memasuki halaman pada level ini, harap logout dan login kembali!'); window.location.href='../index.php';</script>";
		}
	}
	else
	{
		echo "<script>alert('Harap melakukan login di halaman depan!'); window.location.href='../index.php';</script>";
	}

	include '../modules/Database.php';
	include '../modules/Pemesanan.php';

	$database = new Database();
	$pemesanan = new Pemesanan($database->connect());
	$dataPemesanan = $pemesanan->selectPemesananByKodePelanggan($_SESSION['user-code']);
	$dataPemesananExpired = $pemesanan->selectPemesananExpiredByKodePelanggan($_SESSION['user-code']);

	if(isset($_SESSION['user-code']))
		$totalPemesanan = $pemesanan->selectTotalPemesananByKodePelanggan($_SESSION['user-code']);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Pelanggan | Bioskop PBD Blitz</title>

	<?php include 'includes/css.html';?>

</head>

<body>

    <div id="wrapper">

		<?php include 'includes/nav.html';?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header text-center">
                            Selamat Datang di Bioskop PBD Blitz
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
					<div class="col-lg-10 col-lg-offset-1 text-center">
						<h3>Pemesanan Tiket dalam Proses</h3>
					<?php
						if( isset($_SESSION['alert']) && isset($_SESSION['report']) )
						{
							echo '
						<div class="alert alert-'.$_SESSION['alert'].'">
							<strong>'.$_SESSION['report'].'</strong>
						</div>
							';
							unset($_SESSION['alert']);
							unset($_SESSION['report']);
						}
					?>
		                <div class="table-responsive">
							<table id="data-table" class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th class="text-center">Tanggal Tayang</th>
										<th class="text-center">Nama Film</th>
										<th class="text-center">Waktu Tayang</th>
										<th class="text-center">Studio</th>
										<th class="text-center">Seat</th>
										<th class="text-center">Harga</th>
										<th class="text-center">Pembayaran</th>
										<th class="text-center"><i class="fa fa-gear"></i></th>
									</tr>
								</thead>
								<tbody>
					
								<?php
								for ($i=0; $i < count($dataPemesanan); $i++)
								{
								echo '
									<tr>
										<td>'.$dataPemesanan[$i]['tanggal_tayang'].'</td>
										<td>'.$dataPemesanan[$i]['judul_film'].'</td>
										<td>'.$dataPemesanan[$i]['waktu_tayang'].'</td>
										<td>'.$dataPemesanan[$i]['studio_tayangan'].'</td>
										<td>'.$dataPemesanan[$i]['seat'].'</td>
										<td>'.$dataPemesanan[$i]['harga_tayangan'].'</td>
										<td>'.$dataPemesanan[$i]['pembayaran'].'</td>
										<td>
											<a href="ubah-tiket.php?kd='.$dataPemesanan[$i]['kode_pemesanan'].'">
												<i class="fa fa-fw fa-pencil"></i>Edit
											</a>
												&nbsp&nbsp&nbsp
											<a href="../process/delete.php?data=pemesanan&kode='.$dataPemesanan[$i]['kode_pemesanan'].'">
												<i class="fa fa-fw fa-trash"></i>Delete
											</a>
										</td>
						
									</tr>
								';
								}
								?>
								</tbody>
							</table>
						</div>
					</div>
                </div>
                <!-- /.row -->
				<br><br><br>
                <div class="row">
					<div class="col-lg-8 col-lg-offset-2 text-center">
						<h3>Sejarah Pemesanan Tiket</h3>
		                <div class="table-responsive">
							<table id="data-table" class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th class="text-center">Tanggal Tayang</th>
										<th class="text-center">Nama Film</th>
										<th class="text-center">Waktu Tayang</th>
										<th class="text-center">Studio</th>
										<th class="text-center">Seat</th>
										<th class="text-center">Harga</th>
										<th class="text-center">Pembayaran</th>
									</tr>
								</thead>
								<tbody>
					
								<?php
								for ($i=0; $i < count($dataPemesananExpired); $i++)
								{
								echo '
									<tr>
										<td>'.$dataPemesananExpired[$i]['tanggal_tayang'].'</td>
										<td>'.$dataPemesananExpired[$i]['judul_film'].'</td>
										<td>'.$dataPemesananExpired[$i]['waktu_tayang'].'</td>
										<td>'.$dataPemesananExpired[$i]['studio_tayangan'].'</td>
										<td>'.$dataPemesananExpired[$i]['seat'].'</td>
										<td>'.$dataPemesananExpired[$i]['harga_tayangan'].'</td>
										<td>'.$dataPemesananExpired[$i]['pembayaran'].'</td>
									</tr>
								';
								}
								?>
								</tbody>
							</table>
						</div>
					</div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

	<?php include 'includes/js.html';?>

</body>

</html>
