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
	include '../modules/MasterFilm.php';
	include '../modules/Tayangan.php';

	$database = new Database();

	$masterfilm = new MasterFilm($database->connect());
	$dataAllFilm = $masterfilm->selectAllFilm();

	$tayangan = new Tayangan($database->connect());
	$dataAllTayangan = $tayangan->selectAllTayangan();
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
                            Tayangan
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
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="col-sm-6 col-sm-offset-3 form-box bordered">
							<div class="form-top text-center">
                        		<h3 style="color:black"><strong>Insert Tayangan</strong></h3>
							</div>
							<div class="form-bottom">
								<form role="form" action="../process/insert.php" method="post" class="login-form" enctype="multipart/form-data">
									<div class="col-lg-12" style="padding: 0px 50px">
										<table>
											<tr>
												<td><label>Nama Film</label></td>
												<td>
													<select name="form-film">
														<option value="">Pilih Film</option>
														<?php
														for($i=0; $i<count($dataAllFilm); $i++)
														{
															echo '<option value="'.$dataAllFilm[$i]['kode_film'].'">'.$dataAllFilm[$i]['judul_film'].'</option>';
														}
														?>
													</select>
												</td>
											</tr>
											<tr>
												<td><label>Harga Tayangan&nbsp;&nbsp;&nbsp;</label></td>
												<td><input type="number" name="form-harga" step="5000" min="0"></td>
											</tr>
											<tr>
												<td><label>Studio</label></td>
												<td><input type="number" name="form-studio" step="1" min="1" max="4"></td>
											</tr>
											<tr>
												<td><label>Jam Mulai Tayangan</label></td>
												<td><input type="text" name="form-jammulai" step="1"></td>
											</tr>
											<tr>
												<td><label>Jam Selesai Tayangan</label></td>
												<td><input type="text" name="form-jamselesai" step="1"></td>
											</tr>
										</table>
									</div>
									<br><br>
									<input type="hidden" name="jenis" value="tayangan">
									<center><button type="submit" class="btn btn-md btn-success"><b>Insert!</b></button></center>
		        			   </form>
	            		   </div>
                       </div>
						<!--/.form-box-->
                    </div>
                </div>
                <!-- /.row -->
				<br><br>

                <div class="row">
                    <div class="table-responsive">
						<table id="data-table" class="table table-bordered table-hover table-striped">
							<thead>
								<tr>
									<th>Nama Film</th>
									<th>Tanggal Penayangan</th>
									<th>Jumlah Penayangan</th>
									<th><i class="fa fa-gear"></i></th>
								</tr>
							</thead>
							<tbody>
					
							<?php
							for ($i=0; $i < count($dataAllTayangan); $i++)
							{
							echo '
								<tr>
									<td>'.$dataAllTayangan[$i]['judul_film'].'</td>
									<td>'.$dataAllTayangan[$i]['tanggal_tayangan'].'</td>
									<td>'.$dataAllTayangan[$i]['jumlah_tayangan'].'</td>
									<td><a href="jadwal-tayangan.php?kode='.$dataAllTayangan[$i]['kode_film'].'&tanggal='.$dataAllTayangan[$i]['waktu_tayangan'].'"> Lihat Jadwal </a></td>
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
