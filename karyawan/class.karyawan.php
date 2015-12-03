<?php 

class karyawan extends koneksi{
	
	function select_level(){
		if( $list = $this->runQuery("SELECT * FROM `level` WHERE `status`='1' ") ){
			if( $list->num_rows > 0 ){
				return $list;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	function select_area(){
		if( $list = $this->runQuery("SELECT * FROM `area` WHERE `hapus` = '0' ORDER BY `area` ") ){
			if( $list->num_rows > 0 ){
				return $list;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}

	}

	function daftar_karyawan(){
		if( $list = $this->runQuery("SELECT `karyawan`.*, `level`.`jabatan` as `nama_jabatan`,`area`.`area` as `nama_area` FROM `karyawan` INNER JOIN `level` ON `level`.`id` = `karyawan`.`level` INNER JOIN `area` ON `area`.`id` = `karyawan`.`area` WHERE `karyawan`.`hapus` like '0' ") ){

			if( $list->num_rows > 0 ){
				return $list;
			}else{
				return FALSE;
			}

		}else{
			return FALSE;
		}

	}


	function input_karyawan( $nama, $level, $area ){
		/*
		$nama = $this->clearText($nama);
		$level = $this->clearText($level);	
		$area = $this->clearText($area);
*/
		if( $input = $this->runQuery("INSERT INTO `karyawan` (`nama`,`level`,`area`) VALUES ('$nama', '$level', '$area')") ){
			return TRUE;
		}else{
			return FALSE;
		}

	}

	function edit_karyawan( $id, $nama, $level, $area ) {
		$id = $this->clearText($id);
		$nama = $this->clearText($nama);
		$level = $this->clearText($level);	
		$area = $this->clearText($area);

		if( $edit = $this->runQuery("UPDATE `karyawan` SET `nama` = '$nama', `level` = '$level', `area`='$area' WHERE `id` = '$id'  ") ){
			return TRUE;
		}else{
			return FALSE;
		}


	}
	

	function hapus_karyawan( $id ){
		$id = $this->clearText($id);
		
		if( $hapus = $this->runQuery("UPDATE `karyawan` set `hapus`='1' WHERE `id`='$id' ") ){
			return TRUE;
		}else{
			return FALSE;
		}

	}


}


?>