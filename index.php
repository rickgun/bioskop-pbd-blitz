<?php
	session_start();
	if(isset($_SESSION['level-login']))
	{
		if($_SESSION['level-login'] == 'admin')
		{
			echo "<script>window.location.href='admin/index.php';</script>";
		}
		else if($_SESSION['level-login'] == 'pelanggan')
		{
			echo "<script>window.location.href='user/index.php';</script>";
		}
	}

	include 'modules/Database.php';
	include 'modules/MasterFilm.php';

	$database = new Database();
	$masterfilm = new MasterFilm($database->connect());
	$dataAllFilmDescView = $masterfilm->selectAllFilmDescView();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Home | Bioskop PBD Blitz</title>

	<?php include 'includes/css.html';?>

</head>

<body>

    <div id="wrapper">

		<!-- Navigation -->
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<a class="navbar-brand" href="index.html"><h5 style="font-size:30px"> Bioskop </h5></a>
			</div>
			<!-- Top Menu Items -->
			<ul class="nav navbar-right top-nav">
				<br>
			</ul>
			<ul class="nav navbar-right top-nav">
				<br><a href="admin-login.php"><button class="btn btn-default"><i class="fa fa-user"></i> Login Admin </button></a>
			</ul>
			<ul class="nav navbar-right top-nav">
				<br><a href="signup.php"><button class="btn btn-success">Signup</button></a>
			</ul>
			<form role="form" action="process/login-user.php" method="post" class="login-form">
				<ul class="nav navbar-right top-nav">
					<br><button type="submit" class="btn btn-primary">Login</button>
				</ul>
				<ul class="nav navbar-right top-nav">
					<li>
						<label style="color:white">Username</label> <br> <input type="text" name="form-username" class="form-control" autofocus="autofocus">
					</li>
					<li>
						<label style="color:white">Password</label> <br> <input type="password" name="form-password" class="form-control">
					</li>
				</ul>
			</form>
		</nav>

        <div id="page-wrapper">

            <div class="container-fluid">

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
				<br>
				<?php
				if(isset($dataAllFilmDescView))
				{
					for ($i=0; $i < count($dataAllFilmDescView); $i++)
					{
						echo '
							<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 text-center">
								<img src="assets/cover/'.$dataAllFilmDescView[$i]['cover_film'].'" style="width:250px; height:400px">
								<br>
								<center><h4><b>'.$dataAllFilmDescView[$i]['judul_film'].'</b></h4></center>
								<br><br>
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
