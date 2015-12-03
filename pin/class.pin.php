<?php

class pin extends koneksi{
	
	function daftar_spv(){
		if( $daftar = $this->runQuery("SELECT `karyawan`.*, `area`.`area` as `nm_area` FROM `karyawan` INNER JOIN `area` ON `area`.`id` = `karyawan`.`area` WHERE `karyawan`.`level` = '4' && `karyawan`.`hapus` = '0' ") ){
			if( $daftar->num_rows > 0 ){
				return $daftar;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}


	function daftar_pin(){
		if( $daftar = $this->runQuery("SELECT `karyawan`.`nama`,`area`.`area` as `nm_area`, `pin`.* FROM `pin` INNER JOIN `karyawan` ON `karyawan`.`id` = `pin`.`id_karyawan` INNER JOIN `area` ON `area`.`id` = `karyawan`.`area` WHERE `karyawan`.`hapus`='0' ") ){
			if( $daftar->num_rows > 0 ){
				return $daftar;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}

	}


	function input_pin($id_karyawan, $pin){
		$id_karyawan = $this->clearText($id_karyawan);
		$pin = $this->clearText($pin);
		if( $input = $this->runQuery("INSERT INTO `pin` (`id_karyawan`,`pin`) VALUES ('$id_karyawan', '$pin')") ){
			return TRUE;
		}else{
			return FALSE;
		}
	}


	function edit_pin($id_karyawan, $pin){
		$id_karyawan = $this->clearText($id_karyawan);
		$pin = $this->clearText($pin);
		if( $edit = $this->runQuery("UPDATE `pin` SET `pin` = '$pin' WHERE `id_karyawan` = '$id_karyawan' ") ){
			return TRUE;
		}else{
			return FALSE;
		}	
	}

	function hapus_pin($id_karyawan){
		$id_karyawan = $this->clearText($id_karyawan);
		if( $hapus = $this->runQuery("DELETE FROM `pin` WHERE `id_karyawan` = '$id_karyawan'") ){
			return TRUE;
		}else{
			return FALSE;
		}


	}



}


?>