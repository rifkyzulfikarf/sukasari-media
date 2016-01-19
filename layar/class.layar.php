<?php

class layar extends koneksi {

	function getLayar() {
		if ($query = $this->runQuery("SELECT * FROM jenis_layar")) {
			if ($query->num_rows > 0) {
				return $query;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	
	function tambah($bahan, $harga) {
		$bahan = $this->clearText($bahan);
		$harga = $this->clearText($harga);
		
		if( $input = $this->runQuery("INSERT INTO `jenis_layar`(`bahan`,`harga/m`) VALUES('$bahan', '$harga')") ){
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	function ubah($id, $bahan, $harga) {
		$id = $this->clearText($id);
		$bahan = $this->clearText($bahan);
		$harga = $this->clearText($harga);
		
		if ($ubah = $this->runQuery("UPDATE `jenis_layar` SET `bahan` = '$bahan', `harga/m` = '$harga' WHERE `no` = '$id'")) {
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
}

?>