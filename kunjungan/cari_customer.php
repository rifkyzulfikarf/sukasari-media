<?php
if( isset($_POST['spv']) && $_POST['spv']!=""){
	include 'kunjungan/class.kunjungan.php';
	$data = new kunjungan();

	if( $daftar = $data->select_cust($_POST['spv'])){
		echo "<option value='%'>Pilih customer</option>";
		while( $rs = $daftar->fetch_array() ){
			echo "<option value='".$rs['id']."'>".stripslashes($rs['nama'])." - ".stripslashes($rs['alamat'])." - ".stripslashes($rs['area'])."</option>";
		}
	}



}
?>