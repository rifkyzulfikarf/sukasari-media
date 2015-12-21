<?php

class do_do extends koneksi{
		

	function daftar_do( $area, $id_karyawan, $tgl1 , $tgl2 , $status_do ){

		//$area = $this->clearText($area);
		$area = $_SESSION['media-area'];
		$id_karyawan = $this->clearText($id_karyawan);
		$status_do = $this->clearText($status_do);

		if( $daftar = $this->runQuery("SELECT `do`.*, `pelanggan`.`nama`,`pelanggan`.`alamat`,`karyawan`.`nama` as `nama_karyawan`, 
		`level`.`jabatan`, `area`.`area` AS `nama_area`, `rayon`.`rayon` AS `nama_rayon` FROM `do` 
			INNER JOIN `pelanggan` ON `pelanggan`.`id` = `do`.`id_pelanggan`
			INNER JOIN `karyawan` ON `karyawan`.`id` = `do`.`id_karyawan`
			INNER JOIN `level` ON `karyawan`.`level` = `level`.`id` 
			INNER JOIN `area` ON `area`.`id` = `do`.`area` 
			INNER JOIN `rayon` ON `pelanggan`.`rayon` = `rayon`.`id` 
			WHERE `do`.`hapus` = '0' && `do`.`status`<>'0' &&  `do`.`area` = '$area' && `do`.`status` like '$status_do' && (`do`.`tgl_do` BETWEEN '$tgl1' AND '$tgl2' || `do`.`tgl_acc` BETWEEN '$tgl1' AND '$tgl2') ")  ){

			if( $daftar->num_rows > 0 ){
				return $daftar;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}

	}//----- func daftar_po

	function detail_do($id_do){
		$id_do = $this->clearText($id_do);

		if( $daftar = $this->runQuery("SELECT * FROM `do_detail` 
			INNER JOIN `tema_layar` ON `do_detail`.`id_tema_layar` = `tema_layar`.`id`
			INNER JOIN `ukuran` ON `do_detail`.`id_ukuran` = `ukuran`.`id`
			WHERE `do_detail`.`id_do` = $id_do && `do_detail`.`hapus` ='0'") ){

			if($daftar->num_rows > 0){
				return $daftar;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}

	}//


	function tema_layar(){

		if( $daftar = $this->runQuery("SELECT * FROM tema_layar") ){
			if( $daftar->num_rows >0 ){
				return $daftar;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}

	}

	function ukuran_layar(){

		if( $daftar = $this->runQuery("SELECT * FROM `ukuran`") ){
			if( $daftar->num_rows >0 ){
				return $daftar;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}

	}
	
	function generateKodeDO() {
		$blnSekarang = date("m");
		$thSekarang = date("Y");
		$cari = $thSekarang."-".$blnSekarang."-";
		
		if ($qKode = $this->runQuery("SELECT MAX(`no`) AS hasil FROM `do` WHERE DATE(`timestamp`) LIKE '$cari%'")) {
			$rsKode = $qKode->fetch_array();
			if ($rsKode['hasil'] == null) {
				$autokode = "DO".$blnSekarang.$thSekarang."000001";
			} else {
				$autokode = (substr($rsKode['hasil'], 8, 6)) + 1;
				$lenkode = strlen($autokode);
				switch ($lenkode) {
					case 1 :
						$autokode = "DO".$blnSekarang.$thSekarang."00000".$autokode;
						break;
					case 2 :
						$autokode = "DO".$blnSekarang.$thSekarang."0000".$autokode;
						break;
					case 3 :
						$autokode = "DO".$blnSekarang.$thSekarang."000".$autokode;
						break;
					case 4 :
						$autokode = "DO".$blnSekarang.$thSekarang."00".$autokode;
						break;
					case 5 :
						$autokode = "DO".$blnSekarang.$thSekarang."0".$autokode;
						break;
					case 6 :
						$autokode = "DO".$blnSekarang.$thSekarang.$autokode;
						break;
				}
			}
			return $autokode;
		}
	}
	
	function simpan_do($no, $idPelanggan, $noregPelanggan, $area, $tgl_do, $status, $hapus, $idKaryawan, $acc, $tglAcc) {
		$no = $this->clearText($no);
		$idPelanggan = $this->clearText($idPelanggan);
		$noregPelanggan = $this->clearText($noregPelanggan);
		$area = $this->clearText($area);
		$tgl_do = $this->clearText($tgl_do);
		$status = $this->clearText($status);
		$hapus = $this->clearText($hapus);
		$idKaryawan = $this->clearText($idKaryawan);
		$acc = $this->clearText($acc);
		$tglAcc = $this->clearText($tglAcc);

		if ($simpan = $this->runQuery("INSERT INTO `do`(`no`, `id_pelanggan`, `noreg_pelanggan`, `area`, `tgl_do`, `status`, `hapus`, `id_karyawan`, `acc`,`tgl_acc`) VALUES 
						('$no', '$idPelanggan', '$noregPelanggan', '$area', '$tgl_do', '$status', '$hapus', '$idKaryawan', '$acc', '$tglAcc' )  ") ){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function simpan_detail_do($idDO, $deskripsi, $idTema, $idUkuran, $jumlah, $ket) {
		$idDO = $this->clearText($idDO);
		$deskripsi = $this->clearText($deskripsi);
		$idTema = $this->clearText($idTema);
		$idUkuran = $this->clearText($idUkuran);
		$jumlah = $this->clearText($jumlah);
		$ket = $this->clearText($ket);

		if ($simpanDetail = $this->runQuery("INSERT INTO `do_detail`(`id_do`, `deskripsi`, `id_tema_layar`, `id_ukuran`, `jml`, `ket`, `hapus`) VALUES 
							('$idDO', '$deskripsi', '$idTema', '$idUkuran', '$jumlah', '$ket', '0')")){
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function hapus_do($id) {
		$id = $this->clearText($id);
		if ($hapusDO = $this->runQuery("UPDATE `do` SET `hapus` = '1' WHERE `id` = $id")) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function hapus_detail_do($id) {
		$id = $this->clearText($id);
		
		if ($hapusDetail = $this->runQuery("UPDATE `do_detail` SET hapus = '1' WHERE `id` = '$id'")) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function simpan_acc_do($id, $acc) {
		$id = $this->clearText($id);
		$acc = $this->clearText($acc);
		$tgl = date("Y-m-d");
		if ($acc = $this->runQuery("UPDATE `do` SET `status` = '2', acc = '$acc', tgl_acc = '$tgl' WHERE `id` = $id")) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function simpan_tolak_do($id, $acc) {
		$id = $this->clearText($id);
		$acc = $this->clearText($acc);
		$tgl = date("Y-m-d");
		if ($acc = $this->runQuery("UPDATE `do` SET `status` = '3', acc = '$acc', tgl_acc = '$tgl' WHERE `id` = $id")) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

}



?>