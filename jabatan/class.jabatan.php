<?php

class jabatan extends koneksi{
	function daftar_jabatan(){
		if( $daftar = $this->runQuery("SELECT * FROM `level` WHERE `status`='1' ") ){
			if( $daftar->num_rows > 0 ){
				return $daftar;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	function input_jabatan($jabatan){
		$jabatan = $this->clearText($jabatan);
		if($input = $this->runQuery("INSERT INTO `level` (`jabatan`) VALUES ('$jabatan') ") ){
			return TRUE;
		}else{
			return FALSE;
		}

	}

	function edit_jabatan($id, $jabatan){
		$id = $this->clearText($id);
		$jabatan = $this->clearText($jabatan);
		if( $edit = $this->runQuery("UPDATE `level` SET `jabatan` = '$jabatan' WHERE `id` = '$id' ") ){
			return TRUE;
		}else{
			return FALSE;
		}

	}

	function hapus_jabatan($id){
		$id = $this->clearText($id);
		if( $hapus = $this->runQuery("UPDATE `level` set `status` = '0' WHERE `id` = '$id' ") ){
			return TRUE;
		}else{
			return FALSE;
		}
	}



}

?>