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
	include '../modules/Tayangan.php';

	$database = new Database();
	$tayangan = new Tayangan($database->connect());
	$dataTayangan = $tayangan->selectTayanganByKodedanTanggal($_GET['kode'], $_GET['tanggal']);
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
                            Jadwal Tayangan
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
					<div class="col-lg-4 text-center">
					<?php
						echo '<h2>'.$dataTayangan[0]['judul_film'].'</h2><br>';
						echo '<h3>'.$dataTayangan[0]['tanggal_tayangan'].'</h3><br><br>';
						echo '<img src="../assets/cover/'.$dataTayangan[0]['cover_film'].'" style="width:250px; height:400px">';
					?>
					</div>
					<div class="col-lg-6">
		                <div class="table-responsive">
							<table id="data-table" class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th>Waktu Tayangan</th>
										<th>Studio Penayangan</th>
										<th>Harga Penayangan</th>
										<th><i class="fa fa-gear"></i></th>
									</tr>
								</thead>
								<tbody>
					
								<?php
								for ($i=0; $i < count($dataTayangan); $i++)
								{
								echo '
									<tr>
										<td>'.$dataTayangan[$i]['waktu_tayangan'].'</td>
										<td>'.$dataTayangan[$i]['studio_tayangan'].'</td>
										<td>'.$dataTayangan[$i]['harga_tayangan'].'</td>
										<td>
											<a href="../process/delete.php?data=tayangan&kode='.$dataTayangan[$i]['kode_tayangan'].'">
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
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

	<?php include 'includes/js.html';?>

</body>

</html>
