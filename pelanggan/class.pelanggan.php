<?php 

/**
* 
*/
class pelanggan extends koneksi{
	
	function daftar_pelanggan($cari = "%"){
		$cari = $this->clearText($cari);
		if( $daftar = $this->runQuery("SELECT `pelanggan`.*, `area`.`area` as `nm_area`, `rayon`.`rayon` as `nm_rayon` FROM `pelanggan` INNER JOIN `area` ON `area`.`id`=`pelanggan`.`area` INNER JOIN `rayon` ON `rayon`.`id`=`pelanggan`.`rayon` WHERE `pelanggan`.`nama` like '%".$cari."%' && `pelanggan`.`hapus`= '0' ORDER BY `pelanggan`.`id` DESC ") ){
			if( $daftar->num_rows > 0 ){
				return $daftar;
			}else{
				return FALSE;
			}

		}else{
			return FALSE;
		}

	}
	
	function daftar_pelanggan_by_area($cari, $area){
		$cari = $this->clearText($cari);
		$area = $this->clearText($area);
		if( $daftar = $this->runQuery("SELECT `pelanggan`.*, `area`.`area` as `nm_area`, `rayon`.`rayon` as `nm_rayon` 
		FROM `pelanggan` INNER JOIN `area` ON `area`.`id`=`pelanggan`.`area` INNER JOIN `rayon` ON `rayon`.`id`=`pelanggan`.`rayon` 
		WHERE `pelanggan`.`nama` like '%".$cari."%' AND `pelanggan`.`hapus`= '0' AND `pelanggan`.`area` = '$area' 
		ORDER BY `pelanggan`.`id` DESC ") ){
			if( $daftar->num_rows > 0 ){
				return $daftar;
			}else{
				return FALSE;
			}

		}else{
			return FALSE;
		}

	}


	function input_pelanggan($noreg, $nama, $alamat, $rayon, $pasar, $sub_pasar, $type, $area, $kode_pos){

		$noreg = $this->clearText($noreg);
		$nama = $this->clearText($nama);
		$alamat = $this->clearText($alamat);
		$rayon = $this->clearText($rayon);
		$pasar = $this->clearText($pasar);
		$sub_pasar = $this->clearText($sub_pasar);
		$type = $this->clearText($type);
		$area = $this->clearText($area);
		$kode_pos = $this->clearText($kode_pos);

		if( $input = $this->runQuery("INSERT INTO `pelanggan`(`noreg`, `nama`, `alamat`, `rayon`, `pasar`, `sub_pasar`, `type`, `area`, `kode_pos`,`barcode`) VALUES ('$noreg', '$nama', '$alamat', '$rayon', '$pasar', '$sub_pasar', '$type', '$area', '$kode_pos', '$noreg' )  ") ){

			return TRUE;
		}else{
			return FALSE;
		}

	}


	function edit_pelanggan( $id, $noreg, $nama, $alamat, $rayon, $pasar, $sub_pasar, $type, $area, $kode_pos){

		$id = $this->clearText($id);
		$noreg = $this->clearText($noreg);
		$nama = $this->clearText($nama);
		$alamat = $this->clearText($alamat);
		$rayon = $this->clearText($rayon);
		$pasar = $this->clearText($pasar);
		$sub_pasar = $this->clearText($sub_pasar);
		$type = $this->clearText($type);
		$area = $this->clearText($area);
		$kode_pos = $this->clearText($kode_pos);

		if( $edit = $this->runQuery(" UPDATE `pelanggan` SET `noreg` = '$noreg', `nama`='$nama', `alamat`='$alamat', `rayon` = '$rayon', `pasar`='$pasar', `sub_pasar`='$sub_pasar', `type`='$type', `area`='$area', `kode_pos`='$kode_pos', `barcode`='$noreg' WHERE `id`='$id' ") ){

			return TRUE;
		}else{
			return FALSE;
		}

	}


	function hapus_pelanggan( $id ){

		$id = $this->clearText($id);

		if( $edit = $this->runQuery(" UPDATE `pelanggan` SET `hapus` = '1' WHERE `id`='$id' ") ){

			return TRUE;
		}else{
			return FALSE;
		}

	}




}

?>