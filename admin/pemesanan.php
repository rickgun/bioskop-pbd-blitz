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

	include '../modules/Database.php';
	include '../modules/Pemesanan.php';

	$database = new Database();
	$pemesanan = new Pemesanan($database->connect());
	$dataAllPemesanan = $pemesanan->selectAllPemesanan();
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
	<script src="../assets/js/jquery.js"></script>
    <script>
	$(document).ready(function()
	{
	    $("#data-table").dataTable();
    });
    </script>

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
                        <h1 class="page-header">
                            Pemesanan
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

				<?php
					if( isset($_SESSION['alert']) && isset($_SESSION['report']) )
					{
						echo '
				<div class="col-lg-12">
					<div class="alert alert-'.$_SESSION['alert'].'">
						<strong>'.$_SESSION['report'].'</strong>
					</div>
				</div>
						';
						unset($_SESSION['alert']);
						unset($_SESSION['report']);
					}
				?>

                <div class="row">
                    <div class="table-responsive">
						<table id="data-table" class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th>Nama Film</th>
									<th>Tanggal Penayangan</th>
									<th>Studio</th>
									<th>Waktu Tayang</th>
									<th>Jumlah Pelanggan</th>
								</tr>
							</thead>
							<tbody>
					
							<?php
							for ($i=0; $i < count($dataAllPemesanan); $i++)
							{
							echo '
								<tr>
									<td>'.$dataAllPemesanan[$i]['judul_film'].'</td>
									<td>'.$dataAllPemesanan[$i]['tanggal_tayangan'].'</td>
									<td>'.$dataAllPemesanan[$i]['studio_tayangan'].'</td>
									<td>'.$dataAllPemesanan[$i]['waktu_tayangan'].'</td>
									<td>'.$dataAllPemesanan[$i]['jumlah_pelanggan'].'</td>
								</tr>
							';
							}
							?>
							</tbody>
						</table>
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
