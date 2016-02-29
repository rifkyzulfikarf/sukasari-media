<?php
/**
*  class kunjungan...
*/
class kunjungan extends koneksi{

	function select_spv(){

		if( $daftar = $this->runQuery("SELECT DISTINCT `karyawan`.`id`,`karyawan`.`nama` FROM `karyawan` INNER JOIN `visit` ON `visit`.`id_karyawan` = `karyawan`.`id` ") ){
			if( $daftar->num_rows > 0 ){

				return $daftar;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}

	}

	function select_cust($spv){

		if( $daftar = $this->runQuery("SELECT DISTINCT `pelanggan`.`id`,`pelanggan`.`nama`, `pelanggan`.`alamat`, `area`.`area` FROM `pelanggan` 
			INNER JOIN `area` ON `area`.`id` = `pelanggan`.`area`
			INNER JOIN `visit` ON `visit`.`id_pelanggan` = `pelanggan`.`id` WHERE `visit`.`id_karyawan` = '$spv'") ){
			if( $daftar->num_rows > 0 ){

				return $daftar;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}

	}

	function select_job(){
		if( $daftar = $this->runQuery("SELECT * FROM `jenis_pekerjaan` WHERE `hapus` like '0'") ){
			if( $daftar->num_rows > 0 ){
				return $daftar;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}


	function detail_spv($spv){

		$spv = $this->clearText($spv);

		if( $cek = $this->runQuery("SELECT `karyawan`.*, `area`.`area` as `nama_area` FROM `karyawan` INNER JOIN `area` ON `karyawan`.`area` = `area`.`id` WHERE `karyawan`.`id` = '$spv' ") ){
			if( $cek->num_rows > 0 ){
				$x = $cek->fetch_assoc();
				return $x;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}

	}

	function detail_cust($cust){

		$cust = $this->clearText($cust);

		if( $cek = $this->runQuery("SELECT `pelanggan`.* FROM `pelanggan` WHERE `pelanggan`.`id` = '$cust' ") ){
			if( $cek->num_rows > 0 ){
				$x = $cek->fetch_assoc();
				return $x;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}

	}


	function nama_job($id_job){
		$id_job = $this->clearText($id_job);

		if( $query = $this->runQuery("SELECT * FROM `jenis_pekerjaan` WHERE `id` = '$id_job' ") ){
			if( $query->num_rows > 0 ){
				$x =  $query->fetch_assoc();
				return $x;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
			
	}



	function  kunjungan_list( $spv, $tgl1, $tgl2, $cust, $job ){
		$spv = $this->clearText($spv);		
		$tgl1 = $this->clearText($tgl1);
		$tgl2 = $this->clearText($tgl2);
		$cust = $this->clearText($cust);
		$job = $this->clearText($job);

		if( $cari = $this->runQuery("SELECT DISTINCT `visit`.* , DATE(`visit`.`tgl`) AS `tanggal`, TIME(`visit`.`tgl`) as `jam`, `pelanggan`.`noreg`, `pelanggan`.`nama`, `pelanggan`.`alamat`, `pelanggan`.`pasar`, `pelanggan`.`sub_pasar`, `area`.`area` as `kota` FROM `visit` 
			INNER JOIN `pelanggan` ON `visit`.`id_pelanggan` = `pelanggan`.`id` 
			INNER JOIN `area` ON `area`.`id` = `pelanggan`.`area`  
			INNER JOIN `visit_detail` ON `visit`.`id` = `visit_detail`.`id_visit` 
			WHERE `visit`.`id_karyawan` like '$spv' &&  DATE(`visit`.`tgl`) >= '$tgl1' && DATE(`visit`.`tgl`) <= '$tgl2' && `visit_detail`.`id_jenis_pekerjaan` like '$job' && `visit`.`id_pelanggan` like '$cust'") ){	

			if( $cari->num_rows> 0 ){
				return $cari;
			}else{
				return FALSE;
			}

		}else{
			return FALSE;
		}


	}

	function kunjungan_harian($tgl, $spv){

		$spv = $this->clearText($spv);

		if( $cari = $this->runQuery("SELECT `visit`.* , TIME(`visit`.`tgl`) as `jam`, `pelanggan`.`noreg`, `pelanggan`.`nama`, `pelanggan`.`alamat`, `pelanggan`.`pasar`, `pelanggan`.`sub_pasar`, `area`.`area` as `kota` FROM `visit` INNER JOIN `pelanggan` ON `visit`.`id_pelanggan` = `pelanggan`.`id` INNER JOIN `area` ON `area`.`id` = `pelanggan`.`area`  WHERE `visit`.`id_karyawan` like '$spv' &&  DATE(`visit`.`tgl`) like '$tgl' ") ){	

			if( $cari->num_rows> 0 ){
				return $cari;
			}else{
				return FALSE;
			}

		}else{
			return FALSE;
		}
			


	}

	function detail_job( $id_visit ){
		$id_visit = $this->clearText($id_visit);
		if( $cek = $this->runQuery("SELECT * FROM `visit_detail` INNER JOIN `jenis_pekerjaan` ON `visit_detail`.`id_jenis_pekerjaan` = `jenis_pekerjaan`.`id` WHERE `visit_detail`.`id_visit` like '$id_visit' ") ){

			if( $cek->num_rows > 0 ){
				return $cek;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}

	}


	function cari_visit($id_visit){
		$id_visit = $this->clearText($id_visit);

		if( $cek = $this->runQuery("SELECT `visit`.* , TIME(`visit`.`tgl`) as `jam`,DATE(`visit`.`tgl`) as `hari`,  `pelanggan`.`noreg`, `pelanggan`.`nama`, `pelanggan`.`alamat`, `pelanggan`.`sub_pasar`, `pelanggan`.`area`, `karyawan`.`nama` as `spv` FROM `visit` 
			INNER JOIN `pelanggan` ON `visit`.`id_pelanggan` = `pelanggan`.`id` 
			INNER JOIN `karyawan` ON `visit`.`id_karyawan` = `karyawan`.`id`
			WHERE `visit`.`id` like '$id_visit' ") ){

			if( $cek->num_rows > 0 ){
				$rs = $cek->fetch_assoc();
				return $rs;
			}else{
				return FALSE;
			}

		}else{
			return FALSE;
		}


	}


		

}















?>