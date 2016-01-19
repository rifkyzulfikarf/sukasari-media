<?php

class tema extends koneksi {

	function getTema() {
		if ($query = $this->runQuery("SELECT * FROM tema_layar")) {
			if ($query->num_rows > 0) {
				return $query;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	
	function tambah($tema) {
		$tema = $this->clearText($tema);
				
		if( $input = $this->runQuery("INSERT INTO `tema_layar`(`tema`) VALUES('$tema')") ){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function ubah($id, $tema) {
		$id = $this->clearText($id);
		$tema = $this->clearText($tema);
		
		if ($ubah = $this->runQuery("UPDATE `tema_layar` SET `tema` = '$tema' WHERE `id` = '$id'")) {
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
}

?>