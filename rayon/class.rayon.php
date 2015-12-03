<?php
/**
* 
*/
class rayon extends koneksi{
	
	function daftar_rayon(){
		if( $daftar = $this->runQuery("SELECT `rayon`.*, `area`.`area` FROM `rayon` INNER JOIN `area` ON `rayon`.`id_area` = `area`.`id` WHERE `rayon`.`hapus` = '0' ") ){
			if( $daftar->num_rows > 0 ){
				return $daftar;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}


	function input_rayon($rayon, $id_area){
		$rayon = $this->clearText($rayon);
		$id_area = $this->clearText($id_area);

		if( $input = $this->runQuery("INSERT INTO `rayon`(`rayon`,`id_area`) VALUES ('$rayon', '$id_area')") ){
			return TRUE;
		}else{
			return FALSE;
		}

	}


	function edit_rayon($id, $rayon, $id_area){
		$id = $this->clearText($id);
		$rayon = $this->clearText($rayon);
		$id_area = $this->clearText($id_area);

		if( $input = $this->runQuery(" UPDATE `rayon` SET `rayon` = '$rayon', `id_area` = '$id_area' WHERE `id`='$id' ") ){
			return TRUE;
		}else{
			return FALSE;
		}

	}


	function hapus_rayon( $id ){
		$id = $this->clearText($id);
	
		if( $input = $this->runQuery(" UPDATE `rayon` SET `hapus` ='1' WHERE `id`='$id' ") ){
			return TRUE;
		}else{
			return FALSE;
		}

	}




	




}

?>