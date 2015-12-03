<?php
if( isset($_POST['cari']) && $_POST['cari']!="" && isset($_POST['area']) && $_POST['area'] != ""){
	include 'pelanggan/class.pelanggan.php';
	$data = new pelanggan();

	if( $daftar = $data->daftar_pelanggan_by_area($_POST['cari'], $_POST['area'])){
		while( $rs = $daftar->fetch_array() ){
			echo "<option value='".$rs['id']."'>[".$rs['noreg']."] ".stripslashes($rs['nama']).", ".$rs['alamat']." ".$rs['nm_area']."</option>";
		}
	}



}
?>