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
                            Laporan
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-lg-12">
						<form role="form" action="laporan-detail.php" method="post" enctype="multipart/form-data">
                        	<div class="panel panel-primary">
		                        <div class="panel-heading text-center">
									<h2 class="panel-title"> Laporan Film</h2>
		                        </div>
								<center>
									<div class="panel-body">
										<table>
											<tr>
												<td><label>Film:</label></td>
												<td>
												<select name="film" class="form-control" required>
													<option>Pilih Film</option>
													<?php
													for($i=0; $i<count($dataAllFilm); $i++)
													{
														echo '<option value="'.$dataAllFilm[$i]['kode_film'].'"> '.$dataAllFilm[$i]['judul_film'].' </option>';
													}
													?>
												</select>
												</td>
											</tr>
											<tr>
												<td><label>Bulan:</label></td>
												<td>
													<select name="bulan" class="form-control" required>
														<option>Pilih Bulan</option>
														<option value="1"> Januari </option>
														<option value="2"> Februari </option>
														<option value="3"> Maret </option>
														<option value="4"> April </option>
														<option value="5"> Mei </option>
														<option value="6"> Juni </option>
														<option value="7"> Juli </option>
														<option value="8"> Agustus </option>
														<option value="9"> September </option>
														<option value="10"> Oktober </option>
														<option value="11"> November </option>
														<option value="12"> Desember </option>
													</select>
												</td>
											</tr>
											<tr>
												<td><label>Tahun:</label></td>
												<td>
													<select name="tahun" class="form-control" required>
														<option>Pilih Tahun</option>
														<option value="2016"> 2016 </option>
														<option value="2017"> 2017 </option>
														<option value="2018"> 2018 </option>
														<option value="2019"> 2019 </option>
														<option value="2020"> 2020 </option>
														<option value="2021"> 2021 </option>
													</select>
												</td>
											</tr>
										</table>
									</div>
								</center>
		                        <div class="panel-footer text-center">
				                    <input type="hidden" name="jenis-laporan" value="film">
		                            <button type="submit" class="btn btn-info">Filter!</button>
		                        </div>
                        	</div>
						</form>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-lg-12">
						<form role="form" action="laporan-detail.php" method="post" enctype="multipart/form-data">
                        	<div class="panel panel-green">
		                        <div class="panel-heading text-center">
									<h2 class="panel-title"> Laporan Harian</h2>
		                        </div>
								<center>
									<div class="panel-body">
										<table>
											<tr>
												<td><label>Hari:</label></td>
												<td>
													<select name="hari" class="form-control" required>
														<option>Pilih Hari</option>
														<?php
														for($i=1; $i<=31; $i++)
														{
															echo '<option value="'.$i.'"> '.$i.' </option>';
														}
														?>
													</select>
												</td>
											</tr>
											<tr>
												<td><label>Bulan:</label></td>
												<td>
													<select name="bulan" class="form-control" required>
														<option>Pilih Bulan</option>
														<option value="1"> Januari </option>
														<option value="2"> Februari </option>
														<option value="3"> Maret </option>
														<option value="4"> April </option>
														<option value="5"> Mei </option>
														<option value="6"> Juni </option>
														<option value="7"> Juli </option>
														<option value="8"> Agustus </option>
														<option value="9"> September </option>
														<option value="10"> Oktober </option>
														<option value="11"> November </option>
														<option value="12"> Desember </option>
													</select>
												</td>
											</tr>
											<tr>
												<td><label>Tahun:</label></td>
												<td>
													<select name="tahun" class="form-control" required>
														<option>Pilih Tahun</option>
														<option value="2016"> 2016 </option>
														<option value="2017"> 2017 </option>
														<option value="2018"> 2018 </option>
														<option value="2019"> 2019 </option>
														<option value="2020"> 2020 </option>
														<option value="2021"> 2021 </option>
													</select>
												</td>
											</tr>
										</table>
									</div>
								</center>
		                        <div class="panel-footer text-center">
		                            <input type="hidden" name="jenis-laporan" value="harian">
		                            <button type="submit" class="btn btn-info">Filter!</button>
		                        </div>
                        	</div>
						</form>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-lg-12">
						<form role="form" action="laporan-detail.php" method="post" enctype="multipart/form-data">
                        	<div class="panel panel-yellow">
		                        <div class="panel-heading text-center">
									<h2 class="panel-title"> Laporan Bulanan</h2>
		                        </div>
								<center>
									<div class="panel-body">
										<table style="margin-top:14px">
											<tr>
												<td><label>Bulan:</label></td>
												<td>
													<select name="bulan" class="form-control" required>
														<option>Pilih Bulan</option>
														<option value="1"> Januari </option>
														<option value="2"> Februari </option>
														<option value="3"> Maret </option>
														<option value="4"> April </option>
														<option value="5"> Mei </option>
														<option value="6"> Juni </option>
														<option value="7"> Juli </option>
														<option value="8"> Agustus </option>
														<option value="9"> September </option>
														<option value="10"> Oktober </option>
														<option value="11"> November </option>
														<option value="12"> Desember </option>
													</select>
												</td>
											</tr>
											<tr>
												<td><label>Tahun:</label></td>
												<td>
													<select name="tahun" class="form-control" required>
														<option>Pilih Tahun</option>
														<option value="2016"> 2016 </option>
														<option value="2017"> 2017 </option>
														<option value="2018"> 2018 </option>
														<option value="2019"> 2019 </option>
														<option value="2020"> 2020 </option>
														<option value="2021"> 2021 </option>
													</select>
												</td>
											</tr>
										</table>
										<br>
									</div>
								</center>
		                        <div class="panel-footer text-center">
		                            <input type="hidden" name="jenis-laporan" value="bulanan">
		                            <button type="submit" class="btn btn-info">Filter!</button>
		                        </div>
		                    </div>
						</form>
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
