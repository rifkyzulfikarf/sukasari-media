<?php
if( isset($_REQUEST['status']) && isset($_REQUEST['data']) && $_REQUEST['data']<>"" && $_REQUEST['status']<>"" ){

	require './app/class.user.php';

	$data = new user();

	$id = d_code($_REQUEST['data']);
	$status = d_code($_REQUEST['status']);
	if( $status == "1" ||  $status == "2" ){
		$ubah = $data->rubah_status($id, $status) ;	
	}
	

	echo "<script> window.location = './?no_spa=".e_url('./app/user.php')."'; </script>";
	

}


?>