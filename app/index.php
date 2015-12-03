


<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include('header.php'); ?>
	</head>
	<body>
		<?php include("menu.php"); ?>
		<div id="isi_halaman">
		<?php
		$modul = $_GET[mod];
		if($modul==''){
			include('dashboard.php');
		}
		else{
			include($modul.'.php');
		}
		?>
		</div>
		<?php include('modal-signout.php'); ?>
		<?php include('footer.php'); ?>
	</body>
</html>