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

	$database = new Database();
	$tayangan = new Tayangan($database->connect());
	$dataNowShowing = $tayangan->selectTayanganByHari();

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
				<br>
				<center><h2>Now Showing</h2></center>
				<br>
				<?php
				if(isset($dataNowShowing))
				{
					for ($i=0; $i < count($dataNowShowing); $i++)
					{
						echo '
							<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 text-center">
								<a href="pesan-tiket.php?st='.$dataNowShowing[$i]['studio_tayangan'].'&kode='.$dataNowShowing[$i]['kode_film'].'">
									<center><h4><b>Studio '.$dataNowShowing[$i]['studio_tayangan'].'</b></h4></center>
									<img src="../assets/cover/'.$dataNowShowing[$i]['cover_film'].'" style="width:250px; height:400px">
									<br>
									<center><h4><b>'.$dataNowShowing[$i]['judul_film'].'</b></h4></center>
									<br><br>
								</a>
							</div>
						';
					}
				}
				?>
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
