<?php

if( isset($_POST['karyawan']) && isset($_POST['username']) && isset($_POST['password']) && $_POST['karyawan']<>"" && $_POST['username']<>"" && $_POST['password']<>"" ){

	include './app/class.user.php';
	$data = new user();

	if( $insert = $data->add_user($_POST['karyawan'], $_POST['username'], $_POST['password']) ){

		echo "<script> alert('Data tersimpan'); window.location='./?no_spa=".e_url('./app/user.php')."'; </script>";
	}else{
		echo "<script> alert('Gagal menyimpan, cek kembali..!');</script>";
	}



}

?>