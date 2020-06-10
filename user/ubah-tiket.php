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
	include '../modules/Tayangan.php';
	include '../modules/Pemesanan.php';

	date_default_timezone_set("Asia/Jakarta");

	$database = new Database();

	$pemesanan = new Pemesanan($database->connect());
	$dataPemesanan = $pemesanan->selectPemesananByKodePemesanan($_GET['kd']);

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
					<div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-5 col-sm-offset-1 col-xs-12 text-center">
					<br>
					<?php
						echo '<h2>'.$dataPemesanan['judul_film'].'</h2>';
						echo '<img src="../assets/cover/'.$dataPemesanan['cover_film'].'" style="width:250px; height:400px">';
						echo '';
					?>
					</div>
					<br><br>
					<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12 text-center">
						<?php
							echo '<h3>'.$dataPemesanan['tanggal_tayangan'].'</h3>';
							echo '<h4>Studio '.$dataPemesanan['studio_tayangan'].'</h4>';
						?>

			
						<?php
							echo '
						<form role="form" action="../process/edit.php" method="post" class="login-form">
				            <div class="table-responsive">
								<table id="data-table" class="table table-bordered table-hover table-striped">
									<thead>
										<tr>
											<th class="text-center">Waktu</th>
											<th class="text-center">Harga</th>
											<th class="text-center">Current Seat</th>
											<th class="text-center">Seat</th>
											<th class="text-center">Current Payment</th>
											<th class="text-center">Payment</th>
										</tr>
									</thead>
									<tbody>
											<tr>
												<td>'.$dataPemesanan['waktu_tayangan'].'</td>
												<td>'.$dataPemesanan['harga_tayangan'].'</td>
												<td>Kursi '.$dataPemesanan['seat'].'</td>
												<td>
													<select name="seat">
														<option>Pilih Seat</option>
										';
										for($j=0; $j<30; $j++)
										{
											echo '<option value="'.($j+1).'"> Kursi '.($j+1).' </option>';
										}
										echo '
													</select>
												</td>
												<td>'.$dataPemesanan['pembayaran'].'</td>
												<td>
													<select name="pembayaran">
														<option>Pembayaran</option>
														<option value="Cash"> Cash </option>
														<option value="Credit"> Credit </option>
													</select>
												</td>
											</tr>
										</tbody>
									</table>
									<input type="hidden" name="kode" value="'.$dataPemesanan['kode_pemesanan'].'">
									<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-fw fa-edit"></i>Ubah!</button>
								</div>
							</form>
							';
						?>
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
