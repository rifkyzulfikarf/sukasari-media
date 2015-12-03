<?php

if( isset($_POST['menu']) && $_POST['menu']<>"" &&  isset($_POST['id']) && $_POST['id']<>"" ){

	require './app/class.user.php';
	$data  = new user();

	$arr = array();
	$arr = $_POST['menu'];
	//print_r($arr);
	//print_r(d_code($_POST['id']));


	//----- netralkan 

	$delete = $data->runQuery("DELETE FROM `akses` WHERE `id_user` = '".d_code($_POST['id'])."' ");

	foreach ($arr as $key => $value) {
		$add = $data->add_menu( d_code($_POST['id']), $value );
	}

	echo "Data tersimpan..!";

}


?>