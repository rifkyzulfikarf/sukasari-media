<?php

class po_po extends koneksi {

	function getDaftarPO($noPO, $idSupplier, $tglPO1, $tglPO2, $status) {
		
		$noPO = $this->clearText($noPO);
		$idSupplier = $this->clearText($idSupplier);
		$tglPO1 = $this->clearText($tglPO1);
		$tglPO2 = $this->clearText($tglPO2);
		$status = $this->clearText($status);
		
		if ($query = $this->runQuery("SELECT `po`.*, `supplier`.`nama`,`supplier`.`alamat`,`karyawan`.`nama` as `nama_karyawan`, `level`.`jabatan` FROM `po` 
			INNER JOIN `supplier` ON `supplier`.`id` = `po`.`id_supplier`
			INNER JOIN `karyawan` ON `karyawan`.`id` = `po`.`id_karyawan`
			INNER JOIN `level` ON `karyawan`.`level` = `level`.`id` 
			WHERE `po`.`hapus` = '0' && `po`.`status`<>'0' && `po`.`status` like '$status' && `po`.`id_supplier` like '$idSupplier' && (`po`.`tgl_po` BETWEEN '$tglPO1' AND '$tglPO2' || `po`.`tgl_acc` BETWEEN '$tglPO1' AND '$tglPO2') ")) {
			if ($query->num_rows > 0) {
				return $query;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	
	function getDetailPO($idPO) {
		$idPO = $this->clearText($idPO);
		if( $daftar = $this->runQuery("SELECT * FROM `po_detail` 
			INNER JOIN `do_detail` ON `po_detail`.`id_do_detail` = `do_detail`.`id`
			INNER JOIN `jenis_layar` ON `po_detail`.`id_jenis_layar` = `jenis_layar`.`no`
			INNER JOIN `tema_layar` ON `do_detail`.`id_tema_layar` = `tema_layar`.`id`
			INNER JOIN `ukuran` ON `do_detail`.`id_ukuran` = `ukuran`.`id` 
			INNER JOIN `do` ON `do_detail`.`id_do` = `do`.`id` 
			INNER JOIN `pelanggan` ON `do`.`id_pelanggan` = `pelanggan`.`id` 
			INNER JOIN `rayon` ON `pelanggan`.`rayon` = `rayon`.`id`
			WHERE `po_detail`.`id_po` = $idPO && `po_detail`.`hapus` = '0'") ){

			if($daftar->num_rows > 0){
				return $daftar;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}
	
	function generateKodePO() {				// 036/PO/PROM/II/2015
		$blnSekarang = date("m");
		$thSekarang = date("Y");
		$cari = $thSekarang."-".$blnSekarang."-";
		$blnRomawi = $this->getRomawi($blnSekarang);
		
		if ($qKode = $this->runQuery("SELECT COUNT(`no_po`) AS hasil FROM `po` WHERE DATE(`timestamp`) LIKE '$cari%'")) {
			$rsKode = $qKode->fetch_array();
			if ($rsKode['hasil'] == 0) {
				$autokode = "00001/PO/PROM/".$blnRomawi."/".$thSekarang;
			} else {
				$autokode = $rsKode['hasil'] + 1;
				$lenkode = strlen($autokode);
				switch ($lenkode) {
					case 1 :
						$autokode = "0000".$autokode."/PO/PROM/".$blnRomawi."/".$thSekarang;
						break;
					case 2 :
						$autokode = "000".$autokode."/PO/PROM/".$blnRomawi."/".$thSekarang;
						break;
					case 3 :
						$autokode = "00".$autokode."/PO/PROM/".$blnRomawi."/".$thSekarang;
						break;
					case 4 :
						$autokode = "0".$autokode."/PO/PROM/".$blnRomawi."/".$thSekarang;
						break;
					case 5 :
						$autokode = $autokode."/PO/PROM/".$blnRomawi."/".$thSekarang;
						break;
				}
			}
			return $autokode;
		}
	}
	
	function generateKodeRealisasi() {	//000/LPB/PROM/XII/2015
		$blnSekarang = date("m");
		$thSekarang = date("Y");
		$cari = $thSekarang."-".$blnSekarang."-";
		$blnRomawi = $this->getRomawi($blnSekarang);
		
		if ($qKode = $this->runQuery("SELECT COUNT(`id`) AS hasil FROM `realisasi_po` WHERE DATE(`timestamp`) LIKE '$cari%'")) {
			$rsKode = $qKode->fetch_array();
			if ($rsKode['hasil'] == 0) {
				$autokode = "0001/LPB/PROM/".$blnRomawi."/".$thSekarang;
			} else {
				$autokode = $rsKode['hasil'] + 1;
				$lenkode = strlen($autokode);
				switch ($lenkode) {
					case 1 :
						$autokode = "000".$autokode."/LPB/PROM/".$blnRomawi."/".$thSekarang;
						break;
					case 2 :
						$autokode = "00".$autokode."/LPB/PROM/".$blnRomawi."/".$thSekarang;
						break;
					case 3 :
						$autokode = "0".$autokode."/LPB/PROM/".$blnRomawi."/".$thSekarang;
						break;
					case 4 :
						$autokode = $autokode."/LPB/PROM/".$blnRomawi."/".$thSekarang;
						break;
				}
			}
			return $autokode;
		}
	}
	
	function getRomawi($bulan) {
		switch ($bulan) {
			case "01" : $romawi = "I"; break;
			case "02" : $romawi = "II"; break;
			case "03" : $romawi = "III"; break;
			case "04" : $romawi = "IV"; break;
			case "05" : $romawi = "V"; break;
			case "06" : $romawi = "VI"; break;
			case "07" : $romawi = "VII"; break;
			case "08" : $romawi = "VIII"; break;
			case "09" : $romawi = "IX"; break;
			case "10" : $romawi = "X"; break;
			case "11" : $romawi = "XI"; break;
			case "12" : $romawi = "XII"; break;
		}
		return $romawi;
	}
	
	function simpan_po($no, $idSupplier, $tglPO, $top, $tglKirim, $totalBiaya, $status, $idKaryawan, $acc, $tglAcc, $hapus) {
		$no = $this->clearText($no);
		$idSupplier = $this->clearText($idSupplier);
		$tglPO = $this->clearText($tglPO);
		$top = $this->clearText($top);
		$tglKirim = $this->clearText($tglKirim);
		$totalBiaya = $this->clearText($totalBiaya);
		$status = $this->clearText($status);
		$idKaryawan = $this->clearText($idKaryawan);
		$acc = $this->clearText($acc);
		$tglAcc = $this->clearText($tglAcc);
		$hapus = $this->clearText($hapus);
		
		if ($simpan = $this->runQuery("INSERT INTO `po`(`no_po`, `id_supplier`, `tgl_po`, `top`, `tgl_kirim`, `total_biaya`, `status`, `id_karyawan`, `acc`, `tgl_acc`, `tgl_kirim_ke_supplier`, `hapus`) VALUES 
						('$no', '$idSupplier', '$tglPO', '$top', '$tglKirim', '$totalBiaya', '$status', '$idKaryawan', '$acc', '$tglAcc', '0000-00-00', '$hapus')")) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function simpan_detail_po($no, $idItem, $idLayar, $harga, $subtotal, $hapus) {
		$no = $this->clearText($no);
		$idItem = $this->clearText($idItem);
		$idLayar = $this->clearText($idLayar);
		$harga = $this->clearText($harga);
		$subtotal = $this->clearText($subtotal);
		$hapus = $this->clearText($hapus);
		
		if ($simpan = $this->runQuery("INSERT INTO `po_detail`(`id_po`, `id_do_detail`, `id_jenis_layar`, `harga`, `subtotal`, `tgl_kirim`, `tgl_kirim_ke_sales`, `hapus`) VALUES 
						('$no', '$idItem', '$idLayar', '$harga', '$subtotal', '0000-00-00', '0000-00-00', '$hapus')")) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function hapus_po($id) {
		$id = $this->clearText($id);
		if ($hapusDO = $this->runQuery("UPDATE `po` SET `hapus` = '1' WHERE `id` = $id")) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function hapus_detail_po($id) {
		$id = $this->clearText($id);
		
		if ($query = $this->runQuery("SELECT `id_po`, `subtotal` FROM po_detail WHERE `id` = '$id'")) {
			$rs = $query->fetch_array();
			$idPO = $rs['id_po'];
			$subtotal = $rs['subtotal'];
		}
		
		$qHapus = "UPDATE `po_detail` SET hapus = '1' WHERE `id` = '$id';";
		$qHapus .= "UPDATE `po` SET total_biaya = total_biaya - $subtotal WHERE `id` = '$idPO';";
		
		if ($hapusDetail = $this->runMultipleQueries($qHapus)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function simpan_acc_po($id, $acc) {
		$id = $this->clearText($id);
		$acc = $this->clearText($acc);
		$tgl = date("Y-m-d");
		if ($acc = $this->runQuery("UPDATE `po` SET `status` = '2', acc = '$acc', tgl_acc = '$tgl' WHERE `id` = $id")) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function simpan_tolak_po($id, $acc, $keterangan) {
		$id = $this->clearText($id);
		$acc = $this->clearText($acc);
		$keterangan = $this->clearText($keterangan);
		$tgl = date("Y-m-d");
		if ($acc = $this->runQuery("UPDATE `po` SET `status` = '3', acc = '$acc', tgl_acc = '$tgl', ket_acc = '$keterangan' WHERE `id` = $id")) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function simpan_realisasi($tgl, $idDetailPO, $jumlah, $idKaryawan, $hapus) {
		$no = $this->generateKodeRealisasi();
		$tgl = $this->clearText($tgl);
		$idDetailPO = $this->clearText($idDetailPO);
		$jumlah = $this->clearText($jumlah);
		$idKaryawan = $this->clearText($idKaryawan);
		$hapus = $this->clearText($hapus);
		
		if ($simpan = $this->runQuery("INSERT INTO realisasi_po(id, tgl, id_detail_po, jumlah, id_karyawan, hapus) VALUES('$no', '$tgl', '$idDetailPO', '$jumlah', '$idKaryawan', '$hapus')")) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function ubah_tgl_kirim_ke_supplier($idPO, $tgl) {
		$idPO = $this->clearText($idPO);
		$tgl = $this->clearText($tgl);
		
		if ($ubah = $this->runQuery("UPDATE `po` SET `tgl_kirim_ke_supplier` = '$tgl' WHERE `id` = $idPO")) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function ubah_tgl_kirim_ke_tujuan($idDetail, $tgl) {
		$idDetail = $this->clearText($idDetail);
		$tgl = $this->clearText($tgl);
		
		if ($ubah = $this->runQuery("UPDATE `po_detail` SET `tgl_kirim` = '$tgl' WHERE `id` = $idDetail")) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function ubah_tgl_kirim_ke_sales($idDetail, $tgl) {
		$idDetail = $this->clearText($idDetail);
		$tgl = $this->clearText($tgl);
		
		if ($ubah = $this->runQuery("UPDATE `po_detail` SET `tgl_kirim_ke_sales` = '$tgl' WHERE `id` = $idDetail")) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
}

?>