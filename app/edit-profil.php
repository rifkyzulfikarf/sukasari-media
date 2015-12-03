<?php 

if( isset($_POST['user']) && isset($_POST['password']) && isset($_POST['password2']) && $_POST['user']<>"" && $_POST['password']<>"" && $_POST['password2']<>"" && strlen($_POST['password']) > 3 && $_POST['password'] == $_POST['password2']  ){

	$data = new koneksi();

	$user = e_code($_POST['user']);
	$kunci = e_code($_POST['password']);
	$id = d_code($_SESSION['media-data']);
	if( $edit = $data->runQuery("UPDATE `pemakai` SET `user` = '$user' , `kunci` = '$kunci' WHERE `id` = '$id' ") ){
		echo "<script> alert('data tersimpan.. silahkan login kembali !'); window.location = './login/'; </script>";
	}else{
		echo "<script> alert('Error..! Gagal menyimpan..'); </script>";	
	}


}else{
	echo "<script> alert('Silahkan cek kembali..!'); </script>";
}

?>