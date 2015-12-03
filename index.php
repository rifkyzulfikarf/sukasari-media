<?php 
	session_start();
	date_default_timezone_set('Asia/Jakarta');
	set_time_limit(0);
	//header('location:login');

	if( isset($_SESSION['media-data']) && isset($_SESSION['media-nama']) && isset($_SESSION['media-status']) ){

		require 'inc/blob.php';

		if (isset($_REQUEST['mod']) && $_REQUEST['mod']<>"" && !(is_null($_REQUEST['mod']) )  ) {
			if( file_exists( d_url($_REQUEST['mod']) ) ){
				
				require d_url( $_REQUEST['mod'] ) ;

			}else{
				//--404
				require 'app/dashboard.php';
				

			}
		}elseif( isset($_REQUEST['aksi']) && $_REQUEST['aksi']<>""  && !(is_null($_REQUEST['aksi']) )   ){

			if( file_exists( d_url($_REQUEST['aksi']) ) ){
				require d_url($_REQUEST['aksi']);
			}


		}else{
			//dashboard
			?>
				<!DOCTYPE html>
				<html>
					<head>
						<?php include('app/header.php'); ?>
					</head>
					<body>
						<?php include("inc/the_menu.php"); ?>
						<div id="isi_halaman" >
						<?php   'app/dashboard.php'; 
							if( isset($_REQUEST['no_spa']) && $_REQUEST['no_spa']<>"" && file_exists( d_url($_REQUEST['no_spa']) ) ){
								include d_url($_REQUEST['no_spa']);
							}else{
								include 'app/dashboard.php';
							}

						?>

						</div>
						<?php include('app/modal-signout.php'); ?>
						<?php include('app/footer.php'); ?>
					</body>
				</html>"

			<?php

		}

	}else{
		session_destroy();
		//header('location: login/');
		echo "<script> window.location = './login/'; </script>  Sorry, it seems you're lost. Just  <a href='./login/'><button> click HERE to Go BACK </button></a>";
	}


	
?>