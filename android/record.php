<?php
include('../inc/blob.php');


header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");





$postdata=json_decode(file_get_contents("php://input"), TRUE);
$data=new koneksi();
$text="";
$arr=array();
if( $cek_token=$data->runQuery("SELECT `karyawan`.`id`,`karyawan`.`nama` FROM `karyawan` INNER JOIN `pin` ON `pin`.`id_karyawan`=`karyawan`.`id` WHERE `pin`.`id_karyawan`='".$postdata['token']."' ") ){
	if( $cek_token->num_rows > 0 ){
		$rs_spv=$cek_token->fetch_assoc();
		$text .= "Spv: ".$rs_spv['nama'];

		$arr['id_karyawan'] = $rs_spv['id'];

		if( $cek_barcode = $data->runQuery("SELECT `id`,`nama` FROM `pelanggan` WHERE `barcode`='".$postdata['barcode']."' ") ){
			$rs_pelanggan=$cek_barcode->fetch_assoc();
			$text .= " | Pelanggan : ".$rs_pelanggan['nama'];
			$arr['id_pelanggan'] = $rs_pelanggan['id'];

			if( $rec = $data->runQuery("INSERT INTO `visit` (`barcode`,`latitude`,`longitude`,`id_pelanggan`,`id_karyawan`) 
				VALUES ('".$postdata['barcode']."', '".$postdata['latitude']."', '".$postdata['longitude']."', '".$arr['id_pelanggan']."', '".$arr['id_karyawan']."') ") ){

				//$text .=" [ ";

				$id_visit=$data->lastInsertID();
				$qry="INSERT INTO `visit_detail`(`id_visit`,`id_jenis_pekerjaan`) VALUES ";
				if( $postdata['tagih'] ){
					$qry .= " ('$id_visit','1') ,";
					//$text.=" Tagih ,";
				}
				if( $postdata['kirim'] ){
					$qry .= " ('$id_visit','2') ,";
					//$text.=" Kirim Barang ,";
				}
				if( $postdata['kunjungan'] ){
					$qry .= " ('$id_visit','3') ,";
					//$text.=" Kunjungan ,";
				}
				if( $postdata['konfirmasi'] ){
					$qry .= " ('$id_visit','4') ,";
					//$text.=" Konfirmasi Order ,";
				}
				if( $postdata['order'] ){
					$qry .= " ('$id_visit','5') ,";
					//$text.=" Order ,";
				}
				 //$text .= " ] ";
				if( $visit_detail = $data->runQuery( substr( $qry, 0, strlen($qry)-1 ) ) ){
					$text .= " [Data tersimpan]";
				}else{
					$text .= " [Gagal memasukkan detail Visit] ";
				}


			}else{
				$text .= " | Gagal insert data.. ";
			}



		}else{
			$text .= " | Barcode Pelanggan tidak ditemukan ";
		}

	}else{
		
		$text .= "Token tidak ditemukan..";
	}
}else{
	
	$text .= "gagal query Token.. ".$postdata['token'];
}


echo json_encode(array( "status" => TRUE, "text" => $text ));


?>