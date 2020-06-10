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
			<ul class="navbar-header navbar-right top-nav">
				<a href="index.php" style="text-decoration:none; color:#fff"><h3><i class="fa fa-long-arrow-left"></i> Kembali &nbsp;</h3></a>
			</ul>
		</nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h1 class="page-header">
                            Admin Login Panel
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                
				<div class="row">
					<div class="col-lg-6 col-lg-offset-3 text-center">
						<form role="form" action="process/login-admin.php" method="post" class="login-form">
	    			       <div class="form-group">
								<label>Username:</label><br>
								<input type="text" name="form-username" class="form-control" autofocus="autofocus">
								<br>
								<label>Password:</label><br>
								<input type="password" name="form-password" class="form-control">
								<br>
	    			       </div>
	    			       <button type="submit" class="btn btn-lg btn-primary">Login</button>
						</form>
					</div>
				</div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

	<?php include 'includes/js.html';?>



</body>

</html>
