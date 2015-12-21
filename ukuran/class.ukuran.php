<?php 

class ukuran extends koneksi{

	function daftar_ukuran(){
		if( $list = $this->runQuery("SELECT `id`, `kode`, `panjang`, `lebar`, `pre` FROM `ukuran`;") ){

			if( $list->num_rows > 0 ){
				return $list;
			}else{
				return FALSE;
			}

		}else{
			return FALSE;
		}

	}


	function input_ukuran( $kode, $panjang, $lebar, $pre ){
		
		$kode = $this->clearText($kode);
		$panjang = $this->clearText($panjang);	
		$lebar = $this->clearText($lebar);
		$pre = $this->clearText($pre);
		
		if( $input = $this->runQuery("INSERT INTO `ukuran` (`kode`,`panjang`,`lebar`,`pre`) VALUES ('$kode', '$panjang', '$lebar', '$pre')") ){
			return TRUE;
		}else{
			return FALSE;
		}

	}

	function edit_ukuran( $id, $kode, $panjang, $lebar, $pre ) {
		$id = $this->clearText($id);
		$kode = $this->clearText($kode);
		$panjang = $this->clearText($panjang);	
		$lebar = $this->clearText($lebar);
		$pre = $this->clearText($pre);

		if( $edit = $this->runQuery("UPDATE `ukuran` SET `kode` = '$kode', `panjang` = '$panjang', `lebar`='$lebar', `pre` = '$pre' WHERE `id` = '$id';") ){
			return TRUE;
		}else{
			return FALSE;
		}


	}


}


?>