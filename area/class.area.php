<?php

class area extends koneksi{
	function daftar_area(){
		if( $daftar = $this->runQuery("SELECT * FROM `area` WHERE `hapus`='0' ") ){
			if( $daftar->num_rows > 0 ){
				return $daftar;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	function input_area($area){
		$area = $this->clearText($area);
		if($input = $this->runQuery("INSERT INTO `area` (`area`) VALUES ('$area') ") ){
			return TRUE;
		}else{
			return FALSE;
		}

	}

	function edit_area($id, $area){
		$id = $this->clearText($id);
		$area = $this->clearText($area);
		if( $edit = $this->runQuery("UPDATE `area` SET `area` = '$area' WHERE `id` = '$id' ") ){
			return TRUE;
		}else{
			return FALSE;
		}

	}

	function hapus_area($id){
		$id = $this->clearText($id);
		if( $hapus = $this->runQuery("UPDATE `area` set `hapus` = '1' WHERE `id` = '$id' ") ){
			return TRUE;
		}else{
			return FALSE;
		}
	}



}

?>