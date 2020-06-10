<?php
	session_start();
	if(isset($_SESSION['level-login']))
	{
		if($_SESSION['level-login'] != 'admin')
		{
			echo "<script>alert('Anda tidak dapat memasuki halaman pada level ini, harap logout dan login kembali!'); window.location.href='../index.php';</script>";
		}
	}
	else
	{
		echo "<script>alert('Harap melakukan login di halaman depan!'); window.location.href='../index.php';</script>";
	}
	date_default_timezone_set("Asia/Jakarta");

	include '../modules/Database.php';
	include '../modules/MasterFilm.php';
	include '../modules/Pemesanan.php';

	$database = new Database();
	$masterfilm = new MasterFilm($database->connect());
	$dataFilm = $masterfilm->selectFilmByKode($_POST['film']);

	$pemesanan = new Pemesanan($database->connect());
	$total = 0;
	if(isset($_POST['jenis-laporan']))
	{
		if($_POST['jenis-laporan'] == 'film')
		{
			$data = $pemesanan->selectLaporanFilm($_POST['film'], $_POST['bulan'], $_POST['tahun']);
			$page_title = 'Laporan Film';
			if(count($_POST['bulan']) == 1)
			{
				$bulan = '0'.$_POST['bulan'];
			}
			$date_temp = date_create($_POST['tahun']."-".$bulan."-01");
			$date = date_format($date_temp,"F Y");
			$firstcolumn = "Hari";
		}
		else if($_POST['jenis-laporan'] == 'harian')
		{
			$data = $pemesanan->selectLaporanHarian($_POST['hari'], $_POST['bulan'], $_POST['tahun']);
			$page_title = 'Laporan Harian';
			if(count($_POST['bulan']) == 1)
			{
				$bulan = '0'.$_POST['bulan'];
			}
			if(count($_POST['hari']) == 1)
			{
				$hari = '0'.$_POST['hari'];
			}
			$date_temp = date_create($_POST['tahun']."-".$bulan."-".$hari);
			$date = date_format($date_temp,"l, d F Y");
			$firstcolumn = "Waktu";
		}
		else if($_POST['jenis-laporan'] == 'bulanan')
		{
			$data = $pemesanan->selectLaporanBulanan($_POST['bulan'], $_POST['tahun']);
			$page_title = 'Laporan Bulanan';
			if(count($_POST['bulan']) == 1)
			{
				$bulan = '0'.$_POST['bulan'];
			}
			$date_temp = date_create($_POST['tahun']."-".$bulan."-01");
			$date = date_format($date_temp,"F Y");
			$firstcolumn = "Hari";
		}
		else
		{
			echo "<script>alert('Terjadi kesalahan, harap ulangi lagi!'); window.location.href='laporan.php';</script>";
		}
	}
	else
	{
		echo "<script>alert('Anda belum memilih jenis laporan yang diinginkan!'); window.location.href='laporan.php';</script>";
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administrator | Bioskop PBD Blitz</title>

	<?php include 'includes/css.html';?>
	<script src="../assets/js/jquery-2.1.1.min.js"></script>
	<script src="../assets/js/plugins/morris/raphael.min.js"></script>
	<script src="../assets/js/plugins/morris/morris.min.js"></script>
	<script src="../assets/js/plugins/morris/morris.js"></script>

</head>

<body>

    <div id="wrapper">

		<?php include 'includes/nav.html';?>
		<script src="../assets/js/jquery.js"></script>
		<script src="includes/active-menu.js"></script>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="text-center">
                            <?php echo $page_title;?>
                        </h1>
						<h3 class="page-header text-center"><?php echo $dataFilm['judul_film'];?></h3>
                    </div>
                </div>
                <!-- /.row -->

				<?php
				echo'
                <div class="row">
					<div class="col-lg-12 text-center">
				';
				echo '<h3>'.$date.'</h3>';
				echo '
						<div id="laporan"></div>
						<script>
							Morris.Line({
								// ID of the element in which to draw the chart.
								element: "laporan",
							 
								// Chart data records -- each entry in this array corresponds to a point
								// on the chart.
								data: '; echo json_encode($data); echo ',
							 
								// The name of the data record attribute that contains x-values.
								xkey: ["X"],
							 
								// A list of names of data record attributes that contain y-values.
								ykeys: ["Y"],
							 
								// Labels for the ykeys -- will be displayed when you hover over the
								// chart.
								labels: ["Pendapatan"],

							 	parseTime: false,
								lineColors: ["#0b62a4"],
								xLabels: "Hari",
							 
								// Disables line smoothing
								smooth: true,
								resize: true
							});
						</script>
					</div>
                </div>
                <!-- /.row -->
				<br><br>
                <div class="row">
					<div class="col-lg-6 col-lg-offset-3 text-center">
						<h2>Tabel Hasil Laporan</h2>
				';
				echo '<h3>'.$date.'</h3>';
				echo '
						<div class="table-responsive">
							<table id="data-table" class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th class="text-center">'.$firstcolumn.'</th>
										<th class="text-center">Pendapatan</th>
									</tr>
								</thead>
								<tbody>
					
				';
				for ($i=0; $i < count($data); $i++)
				{
				$total = $total + $data[$i]['Y'];
				echo '
									<tr>
										<td>'.$data[$i]['X'].'</td>
										<td>'.$data[$i]['Y'].'</td>
									</tr>
				';
				}
				echo '
								</tbody>
							</table>
							<h3>Total : '.$total.'</h3>
						</div>						
					</div>
                </div>
                <!-- /.row -->
				';
				?>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

	<?php include 'includes/js.html';?>

</body>

</html>
