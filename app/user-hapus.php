<?php
if( isset($_POST['data']) && $_POST['data']<>"" ){

	require './app/class.user.php';

	$data = new user();

	$id = d_code($_POST['data']);

	if( $hapus = $data->hapus_user($id) ){
		echo "Berhasil dihapus..!";
		
	}else{
		echo "Gagal dihapus";
		
	}


}


?>