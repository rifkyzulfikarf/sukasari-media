<?php

class supplier extends koneksi{
	
	function daftar_supplier(){
		if( $cari = $this->runQuery("SELECT * FROM `supplier` WHERE `hapus` ='0'  ") ){
			if( $cari->num_rows > 0 ){
				return $cari;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	function input_supplier($nama, $alamat, $telp="", $fax="", $email="", $cp=""){
		
		$nama = $this->clearText($nama);
		$telp = $this->clearText($telp);
		$fax = $this->clearText($fax);
		$email = $this->clearText( htmlentities($email) );
		$cp = $this->clearText($cp);

		if( $input = $this->runQuery("INSERT INTO `supplier`(`nama`, `alamat`,`telp`,`fax`,`email`,`cp`) VALUES ('$nama', '$alamat', '$telp','$fax', '$email', '$cp') ") ){

			return TRUE;
		}else{
			return FALSE;
		}

	}


	function edit_supplier($id, $nama, $alamat, $telp="", $fax="", $email="", $cp=""){

		$id = $this->clearText($id);
		$nama = $this->clearText($nama);
		$telp = $this->clearText($telp);
		$fax = $this->clearText($fax);
		$email = $this->clearText( htmlentities($email) );
		$cp = $this->clearText($cp);

		if( $edit = $this->runQuery("UPDATE `supplier` SET `nama`='$nama',`alamat`='$alamat',`telp`='$telp', `fax`='$fax', `email`='$email', `cp`='$cp' WHERE `id`='$id'  ") ){

			return TRUE;
		}else{
			return FALSE;
		}


	}


	function hapus_supplier($id){
		$id = $this->clearText($id);
		if( $hapus = $this->runQuery("UPDATE `supplier` SET `hapus`='1' WHERE `id` like '$id' ") ){
			return TRUE;
		}else{
			return FALSE;
		}
	}


	
}

?>