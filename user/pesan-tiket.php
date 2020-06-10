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

	$tayangan = new Tayangan($database->connect());
	$dataTayangan = $tayangan->selectTayanganByStudioKodedanTanggal($_GET['st'], $_GET['kode'], date('Y-m-d'));

	$pemesanan = new Pemesanan($database->connect());

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
						echo '<h2>'.$dataTayangan[0]['judul_film'].'</h2>';
						echo '<img src="../assets/cover/'.$dataTayangan[0]['cover_film'].'" style="width:250px; height:400px">';
						echo '';
					?>
					</div>
					<br><br>
					<div class="col-lg-6 col-md-6 col-sm-5 col-xs-12 text-center">
						<?php
							echo '<h3>'.$dataTayangan[0]['tanggal_tayangan'].'</h3>';
							echo '<h4>Studio '.$dataTayangan[0]['studio_tayangan'].'</h4>';
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
										<th class="text-center">Waktu Tayangan</th>
										<th class="text-center">Harga Penayangan</th>
										<th class="text-center">Seat</th>
										<th class="text-center">Payment</th>
										<th class="text-center"><i class="fa fa-gear"></i></th>
									</tr>
								</thead>
								<tbody>
					
								<?php
								for ($i=0; $i < count($dataTayangan); $i++)
								{
									echo '
									<form role="form" action="../process/insert.php" method="post" class="login-form" enctype="multipart/form-data">
										<tr>
											<td>'.$dataTayangan[$i]['waktu_tayangan'].'</td>
											<td>'.$dataTayangan[$i]['harga_tayangan'].'</td>
											<td>
												<select name="seat">
													<option>Pilih Seat</option>
									';
									$dataPemesanan = $pemesanan->selectPemesananByKodeTayangan($dataTayangan[$i]['kode_tayangan']);
									for($j=0; $j<30; $j++)
									{
										$same = 0;
										for($k=0; $k<count($dataPemesanan); $k++)
										{
											if(($j+1) == $dataPemesanan[$k]['seat'])
												$same = 1;
										}
										if($same == 0)
											echo '<option value="'.($j+1).'"> Kursi '.($j+1).' </option>';
									}
									echo '
												</select>
											</td>
											<td>
												<select name="pembayaran">
													<option>Pembayaran</option>
													<option value="Cash"> Cash </option>
													<option value="Credit"> Credit </option>
												</select>
											</td>
											<td>
												<input type="hidden" name="jenis" value="pemesanan">
												<input type="hidden" name="kode" value="'.$dataTayangan[$i]['kode_tayangan'].'">
												<input type="hidden" name="st" value="'.$_GET['st'].'">
												<input type="hidden" name="kd" value="'.$_GET['kode'].'">
												<button type="submit" class="btn btn-sm btn-success">
													<i class="fa fa-fw fa-edit"></i>Pesan
												</button>
											</td>
										</tr>
									</form>
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
