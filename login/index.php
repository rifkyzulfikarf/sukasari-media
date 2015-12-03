<?php
session_start();
session_destroy();

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="../img/favicon.png">
		<title>Aplikasi Kunjungan Sukasari</title>

		<!-- Bootstrap CSS -->
		<link href="../css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="../css/font-awesome.min.css">
		<link rel="stylesheet" href="../css/animate.min.css">
		<link rel="stylesheet" href="style.css">


		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
	<div id="spinner"><!--<img src="../img/load.GIF" alt=""><--><i class="fa fa-refresh fa-spin text-muted"></i><p>Loading...</p><p class="small">sedang proses</p></div>
		<div id="login-pane">
			<div class="logo wow fadeIn">
				<center>
					<img src="../img/logo.png" alt="">
				</center>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-4">
						<div class="login-panel wow bounceInUp">
							
							<form action="sign-in.php" method="POST">
								<input type="text" name="username" id="inputUsername" class="form-control input-min" required="required" title="username" placeholder="&#xf007; username" autofocus>
								<input type="password" name="password" id="inputPassword" class="form-control input-min" required="required"  title="password" placeholder="&#xf023; password" >
								<div class="row">
									
									<div class="col-md-12">
										<button class="btn btn-danger btn-orange btn-block" type="submit">Log in <i class="fa fa-send"></i></button>
									</div>
								</div>
							</form>

						
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<nav class="navbar navbar-default navbar-fixed-bottom transparan" role="navigation">
			<div class="container">
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-4">
						<p class="small text-muted text-center">Copyright &copy; 2015 by <a href="#">Sukasari</a> - Powered by <a href="#">Ezatech</a></p>
					</div>
					<div class="col-md-4">
						<p class="small text-muted text-right">Version 1.0.0</p>
					</div>
				</div>
			</div>
		</nav>

		<!-- jQuery -->
		<script src="../js/jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="../js/bootstrap.min.js"></script>
		<script type="text/javascript">// to make loading animation before page completely loaded
		$(window).load(function() {
		  $("#spinner").fadeOut("slow");
		});

		</script>
		<script src="../js/wow.min.js"></script>
		<script>
			new WOW().init();
		</script>
	</body>
</html>