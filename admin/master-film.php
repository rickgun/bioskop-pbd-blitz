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

	$database = new Database();
	$masterfilm = new MasterFilm($database->connect());
	$dataAllGenre = $masterfilm->selectAllGenre();
	$dataAllKategori = $masterfilm->selectAllKategori();
	$dataAllFilm = $masterfilm->selectAllFilm();
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
                            Master Film
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
                        		<h3 style="color:black"><strong>Insert Master Film</strong></h3>
							</div>
							<div class="form-bottom">
								<form role="form" action="../process/insert.php" method="post" class="login-form" enctype="multipart/form-data">
									<div class="col-lg-12" style="padding: 0px 50px">
										<table>
											<tr>
												<td><label>Judul</label></td>
												<td><input type="text" name="form-judul" autofocus="autofocus"></td>
											</tr>
											<tr>
												<td><label>Production&nbsp;&nbsp;&nbsp;</label></td>
												<td><input type="text" name="form-production"></td>
											</tr>
											<tr>
												<td><label>Genre</label></td>
												<td>
													<select name="form-genre">
														<option value="">Pilih Genre</option>
														<?php
														for($i=0; $i<count($dataAllGenre); $i++)
														{
															echo '<option value="'.$dataAllGenre[$i]['id_genre'].'">'.$dataAllGenre[$i]['nama_genre'].'</option>';
														}
														?>
													</select>
												</td>
											</tr>
											<tr>
												<td><label>Kategori</label></td>
												<td>
													<select name="form-kategori">
														<option value="">Pilih Kategori</option>
														<?php
														for($i=0; $i<count($dataAllKategori); $i++)
														{
															echo '<option value="'.$dataAllKategori[$i]['id_kategori'].'">'.$dataAllKategori[$i]['nama_kategori'].'</option>';
														}
														?>
													</select>
												</td>
											</tr>
											<tr>
												<td><label>Rating</label></td>
												<td><input type="number" name="form-rating" step="0.1" min="0" max="10"></td>
											</tr>
											<tr>
												<td><label>Cover Foto</label></td>
												<td><input type="file" name="form-cover"></td>
											</tr>
										</table>
									</div>
									<br><br>
									<input type="hidden" name="jenis" value="master-film">
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
									<th>Judul Film</th>
									<th>Production</th>
									<th>Genre</th>
									<th>Kategori</th>
									<th>Rating</th>
									<th><i class="fa fa-gear"></i></th>
								</tr>
							</thead>
							<tbody>
					
							<?php
							for ($i=0; $i < count($dataAllFilm); $i++)
							{
							echo '
								<tr>
									<td>'.$dataAllFilm[$i]['judul_film'].'</td>
									<td>'.$dataAllFilm[$i]['production_film'].'</td>
									<td>'.$dataAllFilm[$i]['nama_genre'].'</td>
									<td>'.$dataAllFilm[$i]['nama_kategori'].'</td>
									<td>'.$dataAllFilm[$i]['rating_film'].'</td>
									<td>
										<a href="../process/delete.php?data=master-film&kode='.$dataAllFilm[$i]['kode_film'].'">
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
