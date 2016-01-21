<?php
if( isset($_POST['cari']) && $_POST['cari']!=""){
	include 'pelanggan/class.pelanggan.php';
	$data = new pelanggan();
	
	if ($_SESSION['media-status'] == e_code("2") || $_SESSION['media-status'] == e_code("9") || $_SESSION['media-level'] == "2") {
		$area = "%";
	} else {
		$area = $_SESSION['media-area'];
	}
	
	if( $daftar = $data->daftar_pelanggan_by_area($_POST['cari'], $area)){
		while( $rs = $daftar->fetch_array() ){
			echo "<option value='".$rs['id']."'>[".$rs['noreg']."] ".stripslashes($rs['nama']).", ".$rs['alamat']." ".$rs['nm_area']."</option>";
		}
	}



}
?>