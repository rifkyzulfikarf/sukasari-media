<?php

include 'inc/blob.php';
$data = new koneksi();
$aksi = new koneksi();

//============ untuk  rayon dan area di pelanggan ========================
/*
if( $lihat = $data->runQuery("SELECT * FROM `rayon`") ){
	while( $rs = $lihat->fetch_assoc() ){
		$run = $aksi->runQuery("UPDATE `pelanggan` SET `rayon` = '".$rs['id']."' WHERE `rayon` = '".$rs['rayon']."' ");
	}
}

if( $lihat = $data->runQuery("SELECT * FROM `area`") ){
	while( $rs = $lihat->fetch_assoc() ){
		$run = $aksi->runQuery("UPDATE `pelanggan` SET `area` = '".$rs['id']."' WHERE `area` = '".$rs['area']."' ");
	}
}

*/

//============= end ==========



/*
if( $lihat = $data->runQuery("SELECT `id`,`kode`,`noreg` FROM `pelanggan`") ){
	while( $rs = $lihat->fetch_assoc() ){

		if( strlen($rs['kode'])== 0 ){
			$kode = "00";
		}elseif(strlen($rs['kode'])== 1){
			$kode = "0".$rs['kode'];
		}elseif(strlen($rs['kode']) == 2){
			$kode = $rs['kode'];
		}

		switch (strlen($rs['noreg'])) {
			case '0':
				$noreg = "00000";
				break;
			case '1':
				$noreg = "0000".$rs['noreg'];
				break;
			case '2':
				$noreg = "000".$rs['noreg'];
				break;
			case '3':
				$noreg = "00".$rs['noreg'];
				break;
			case '4':
				$noreg = "0".$rs['noreg'];
				break;
			case '5':
				$noreg = $rs['noreg'];
				break;
		}

		$update = $aksi->runQuery("UPDATE `pelanggan` SET `kode`='$kode' , `noreg` = '$noreg' WHERE `id` = '".$rs['id']."' ");


	}
}

*/
header('location: ./login/');
?>