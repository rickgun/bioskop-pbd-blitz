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
	include '../modules/Pelanggan.php';

	$database = new Database();
	$pelanggan = new Pelanggan($database->connect());
	$dataAllPelanggan = $pelanggan->selectAllPelanggan();
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
                            Data Pelanggan
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
                        		<h3 style="color:black"><strong>Insert Data Pelanggan</strong></h3>
							</div>
							<div class="form-bottom">
								<form role="form" action="../process/insert.php" method="post" class="login-form" enctype="multipart/form-data">
									<div class="col-lg-12" style="padding: 0px 50px">
										<table>
											<tr>
												<td><label>Nama Pelanggan</label></td>
												<td><input type="text" name="form-nama" autofocus="autofocus"></td>
											</tr>
											<tr>
												<td><label>Nomor HP</label></td>
												<td><input type="text" name="form-nohp"></td>
											</tr>
											<tr>
												<td><label>Email</label></td>
												<td><input type="email" name="form-email"></td>
											</tr>
											<tr>
												<td><label>Username</label></td>
												<td><input type="text" name="form-username"></td>
											</tr>
											<tr>
												<td><label>Password</label></td>
												<td><input type="password" name="form-password"></td>
											</tr>
										</table>
									</div>
									<br><br>
									<input type="hidden" name="jenis" value="data-pelanggan">
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
									<th>Nama Pelanggan</th>
									<th>Nomor HP</th>
									<th>E-Mail</th>
									<th>Username</th>
									<th>Password</th>
									<th><i class="fa fa-gear"></i></th>
								</tr>
							</thead>
							<tbody>
					
							<?php
							for ($i=0; $i < count($dataAllPelanggan); $i++)
							{
							echo '
								<tr>
									<td>'.$dataAllPelanggan[$i]['nama_pelanggan'].'</td>
									<td>'.$dataAllPelanggan[$i]['nohp_pelanggan'].'</td>
									<td>'.$dataAllPelanggan[$i]['email_pelanggan'].'</td>
									<td>'.$dataAllPelanggan[$i]['username_pelanggan'].'</td>
									<td>'.$dataAllPelanggan[$i]['password_pelanggan'].'</td>
									<td>
										<a href="../process/delete.php?data=pelanggan&kode='.$dataAllPelanggan[$i]['kode_pelanggan'].'">
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
