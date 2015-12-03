<?php

/**
* 
*/
class user extends koneksi{
	
	function list_user(){

		if( $query = $this->runQuery("SELECT `pemakai`.*, `karyawan`.`nama` FROM `pemakai` INNER JOIN `karyawan` ON `karyawan`.`id` = `pemakai`.`id_karyawan`") ){

			if( $query->num_rows > 0 ){

				return $query;

			}else{
				return FALSE;
			}

		}else{
			return FALSE;
		}

	}//========== func list_user

	function list_karyawan_belum_ada_user(){

		//if( $query = $this->runQuery("SELECT `karyawan`.`id`,` FROM `karyawan` WHERE `id` NOT IN (SELECT `id_karyawan` FROM `pemakai`)") ){
		if( $query = $this->runQuery("SELECT `karyawan`.`id`, `karyawan`.`nama`, `karyawan`.`nama`, `area`.`area`, `level`.`jabatan` FROM `karyawan` INNER JOIN `area` ON `karyawan`.`area` = `area`.`id` INNER JOIN `level` ON `karyawan`.`level` = `level`.`id` WHERE `karyawan`.`id` NOT IN (SELECT `id_karyawan` FROM `pemakai`) ") ){
			if( $query->num_rows > 0 ){
				return $query;
			}else{
				return FALSE;
			}

		}else{
			return FALSE;
		}

	}//========== func karyawan belum ada user


	function add_user($id_karyawan, $user, $pass){
		
		$id_karyawan = $this->clearText($id_karyawan);
		$user = $this->clearText($user);
		$pass = $this->clearText($pass);

		$user = e_code($user);
		$pass = e_code($pass);

		$status = e_code('1');

		if( $query = $this->runQuery("INSERT INTO `pemakai` (`nama`,`id_karyawan`,`user`,`kunci`,`status`) VALUES ('$user','$id_karyawan','$user','$pass', '$status') ") ){

			return TRUE;
		}else{
			return FALSE;
		}

	}//======== func add_user


	function hapus_user($id){

		$id = $this->clearText($id);

		if( $query = $this->runQuery("DELETE FROM `pemakai` WHERE `id` = '$id'  ") ){
			if( $query_2 = $this->runQuery("DELETE FROM `akses` WHERE `id_user` = '$id' ") ){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}


	}//========== func hapus_user


	function list_menu_aktif($id_user, $level){

		$id_user = $this->clearText($id_user);
		$level = $this->clearText($level);

		if( $query = $this->runQuery(" SELECT `akses_menu`.* FROM `akses_menu` INNER JOIN `akses` ON `akses`.`id_menu` = `akses_menu`.`id` WHERE `akses`.`id_user` = '$id_user' && `akses_menu`.`level` = '$level' ")  ){

			if( $query->num_rows > 0 ){
				return $query;
			}else{
				return FALSE;
			}

		}else{
			return FALSE;
		}

	}//========= func list_menu_aktif


	function list_menu_available($id_user, $level){

		$id_user = $this->clearText($id_user);
		$level = $this->clearText($level);

		if( $query = $this->runQuery("SELECT * FROM `akses_menu` WHERE `id` NOT IN (SELECT `id_menu` FROM `akses` WHERE `id_user` = '$id_user' ) ") ){

			if( $query->num_rows > 0 ){
				return $query;
			}else{
				return FALSE;
			}

		}else{
			return FALSE;
		}


	}//========= func list_menu_available


	function list_menu( $id_user, $level, $induk ){

		$id_user = $this->clearText($id_user);
		$level = $this->clearText($level);
		$induk = $this->clearText($induk);

		if( $query = $this->runQuery("SELECT `akses_menu`.*, `akses`.`id` as `id_akses` FROM `akses_menu` LEFT OUTER JOIN `akses` ON `akses`.`id_menu` = `akses_menu`.`id` WHERE (`akses`.`id_user` = '$id_user' || `akses`.`id_user` IS NULL ) && `akses_menu`.`level` = '$level' && `akses_menu`.`induk` = '$induk' ORDER BY `akses_menu`.`urutan`,`akses_menu`.`id`" ) ){

			if( $query->num_rows > 0 ){
				return $query;
			}else{
				return FALSE;
			}

		}else{
			return FALSE;
		}


	}//========= func list_menu


	function add_menu( $id_user, $id_menu ){
		$id_user = $this->clearText($id_user);
		$id_menu = $this->clearText($id_menu);

		if( $query = $this->runQuery("INSERT INTO `akses` (`id_user`,`id_menu`) VALUES ('$id_user','$id_menu') ") ){
			return TRUE;
		}else{
			return FALSE;
		}

	}//============= func add_menu


	function rubah_status( $id, $status ){

		$id = $this->clearText($id);
		$status = e_code($status);

		if( $query = $this->runQuery("UPDATE `pemakai` SET `status` = '$status' WHERE `id` = '$id' ") ){
			return TRUE;
		}else{
			return FALSE;
		}


	}//========== func rubah_status





	
}


?>