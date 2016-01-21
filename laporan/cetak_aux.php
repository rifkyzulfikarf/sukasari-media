<?php
if( isset($_POST['apa']) && $_POST['apa']<>"" ){

	switch ($_POST['apa']) {
		case "cetak-do-daftar-do":
			include 'do/class.do.php';
			$data = new do_do();
			if (isset($_POST['tglAwal']) && isset($_POST['tglAkhir']) && isset($_POST['area'])) {
				$collect = array();
				$tglAwal = $_POST['tglAwal'];
				$tglAkhir = $_POST['tglAkhir'];
				$area = $_POST['area'];
				
				if ($query = $data->daftar_do($area, $_SESSION['media-id'], $tglAwal, $tglAkhir, "%")) {
					while ($rs = $query->fetch_array()) {
						$detail = array();
						array_push($detail, $rs["no"]);
						array_push($detail, $rs["tgl_do"]);
						array_push($detail, $rs["nama"]);
						array_push($detail, $rs["nama_area"]);
						switch ($rs["status"]) {
							case "1":
								$status = "Diajukan";
								break;
							case "2":
								$status = "Acc";
								break;
							case "3":
								$status = "Ditolak";
								break;
						}
						array_push($detail, $status);
						array_push($detail, 
							"<button class='btn btn-sm btn-orange btn-show-detail' id='btn-show-detail' data-id='".$rs["id"]."'><i class='fa fa-eye'></i></button>
							<button class='btn btn-sm btn-orange btn-cetak-do' id='btn-cetak-do' data-id='".$rs["id"]."'><i class='fa fa-print'></i></button>");
						array_push($collect, $detail);
						unset($detail);
					}
				}
				echo json_encode(array("data"=>$collect));
			}
			break;
		case "cetak-do-daftar-detail-do":
			include 'do/class.do.php';
			$data = new do_do();
			if (isset($_POST['idDO'])) {
				$idDO = $_POST['idDO'];
				$detail = array();
				
				if ($query = $data->detail_do($idDO)) {
					while ($rs = $query->fetch_array()) {
						$detail[] = array("deskripsi"=>$rs["deskripsi"],"tema"=>$rs["tema"],"ukuran"=>($rs["pre"]." ".$rs["panjang"]." x ".$rs["lebar"]),"jml"=>$rs["jml"],"ket"=>$rs["ket"]);
					}
				}
				echo json_encode($detail);
			}
			break;
		case "cetak-po-daftar-po":
			include 'po/class.po.php';
			$data = new po_po();
			if (isset($_POST['tglAwal']) && isset($_POST['tglAkhir']) && isset($_POST['supplier'])) {
				$collect = array();
				$tglAwal = $_POST['tglAwal'];
				$tglAkhir = $_POST['tglAkhir'];
				$supplier = $_POST['supplier'];
				
				if ($query = $data->getDaftarPO("%", "$supplier", $tglAwal, $tglAkhir, "%")) {
					while ($rs = $query->fetch_array()) {
						$detail = array();
						array_push($detail, $rs["no_po"]);
						array_push($detail, $rs["tgl_po"]);
						array_push($detail, $rs["tgl_kirim"]);
						array_push($detail, $rs["nama"]);
						array_push($detail, "Rp ".number_format($rs["total_biaya"], 0, ",", "."));
						switch ($rs["status"]) {
							case "1":
								$status = "Diajukan";
								break;
							case "2":
								$status = "Acc";
								break;
							case "3":
								$status = "Ditolak";
								break;
						}
						array_push($detail, $status);
						array_push($detail, 
							"<button class='btn btn-sm btn-orange btn-show-detail' id='btn-show-detail' data-id='".$rs["id"]."'><i class='fa fa-eye'></i></button>
							<button class='btn btn-sm btn-orange btn-cetak-po' id='btn-cetak-po' data-id='".$rs["id"]."'><i class='fa fa-print'></i></button>");
						array_push($collect, $detail);
						unset($detail);
					}
				}
				echo json_encode(array("data"=>$collect));
			}
			break;
		case "cetak-po-daftar-detail-po":
			include 'po/class.po.php';
			$data = new po_po();
			if (isset($_POST['idPO'])) {
				$idDO = $_POST['idPO'];
				$detail = array();
				
				if ($query = $data->getDetailPO($idDO)) {
					while ($rs = $query->fetch_array()) {
						$luas = $rs["panjang"] * $rs["lebar"] * $rs["jml"];
						$detail[] = array("gsm"=>$rs["bahan"],"deskripsi"=>$rs["deskripsi"],"tema"=>$rs["tema"],"ukuran"=>($rs["panjang"]." x ".$rs["lebar"]),"jml"=>$rs["jml"],"luas"=>$luas,"unit"=>"Rp ".number_format($rs["harga/m"], 0, ",", "."),"subtotal"=>"Rp ".number_format($rs["subtotal"], 0, ",", "."));
					}
				}
				echo json_encode($detail);
			}
			break;
		case "cetak-penerimaan-daftar-penerimaan":
			include 'po/class.po.php';
			$data = new po_po();
			if (isset($_POST['tglAwal']) && isset($_POST['tglAkhir']) && isset($_POST['supplier'])) {
				$collect = array();
				$tglAwal = $_POST['tglAwal'];
				$tglAkhir = $_POST['tglAkhir'];
				$supplier = $_POST['supplier'];
				$q = "SELECT `realisasi_po`.`id`, `realisasi_po`.`tgl`, `supplier`.`nama`, `tema_layar`.`tema`, `ukuran`.`panjang`
						, `ukuran`.`lebar`, `ukuran`.`pre`, `realisasi_po`.`jumlah` FROM `po_detail` 
						INNER JOIN `po` ON (`po_detail`.`id_po` = `po`.`id`) INNER JOIN `realisasi_po` 
						ON (`realisasi_po`.`id_detail_po` = `po_detail`.`id`) INNER JOIN `supplier` 
						ON (`po`.`id_supplier` = `supplier`.`id`) INNER JOIN `do_detail` 
						ON (`po_detail`.`id_do_detail` = `do_detail`.`id`) INNER JOIN `tema_layar` 
						ON (`do_detail`.`id_tema_layar` = `tema_layar`.`id`) INNER JOIN `ukuran` 
						ON (`do_detail`.`id_ukuran` = `ukuran`.`id`) WHERE `supplier`.`id` LIKE '$supplier' AND 
						`realisasi_po`.`tgl` BETWEEN '$tglAwal' AND '$tglAkhir';";
				
				if ($query = $data->runQuery($q)) {
					while ($rs = $query->fetch_array()) {
						$detail = array();
						array_push($detail, $rs["id"]);
						array_push($detail, $rs["tgl"]);
						array_push($detail, $rs["nama"]);
						array_push($detail, $rs["tema"]);
						$ukuran = $rs['pre']." ".$rs['panjang']." x ".$rs['lebar'];
						array_push($detail, $ukuran);
						array_push($detail, $rs['jumlah']);
						array_push($collect, $detail);
						unset($detail);
					}
				}
				echo json_encode(array("data"=>$collect));
			}
			break;
		case "data-pesanan-daftar":
			include 'po/class.po.php';
			$data = new po_po();
			if (isset($_POST['tglAwal']) && isset($_POST['tglAkhir'])) {
				$collect = array();
				$tglAwal = $_POST['tglAwal'];
				$tglAkhir = $_POST['tglAkhir'];
				$id = $_POST['id'];
				
				// $q = "SELECT `pelanggan`.`id`, `pelanggan`.`noreg`, `pelanggan`.`nama`, `pelanggan`.`alamat`, `area`.`area`, SUM(`do_detail`.`jml`) AS jumlah 
						// FROM `do_detail` INNER JOIN `do` ON (`do_detail`.`id_do` = `do`.`id`) INNER JOIN `pelanggan` 
						// ON (`do`.`id_pelanggan` = `pelanggan`.`id`) INNER JOIN `area` ON (`do`.`area` = `area`.`id`) 
						// WHERE `pelanggan`.`id` = '$id' AND `do_detail`.`hapus` = '0' AND `do`.`hapus` = '0' AND `do`.`tgl_do` BETWEEN '$tglAwal' AND '$tglAkhir'  
						// GROUP BY `pelanggan`.`nama`";
				
				$q = "SELECT `pelanggan`.`id`, `pelanggan`.`noreg`, `pelanggan`.`nama`, `pelanggan`.`alamat`, `area`.`area` 
						FROM `pelanggan` INNER JOIN `area` ON (`pelanggan`.`area` = `area`.`id`) 
						WHERE `pelanggan`.`id` = '$id'";
				
				if ($query = $data->runQuery($q)) {
					while ($rs = $query->fetch_array()) {
						$detail = array();
						array_push($detail, $rs["noreg"]." - ".$rs["nama"]);
						array_push($detail, $rs["alamat"]);
						array_push($detail, $rs["area"]);
						
						$qJumlah = "SELECT SUM(`do_detail`.`jml`) AS `jumlah` FROM `do_detail` 
									INNER JOIN `do` ON(`do_detail`.`id_do` = `do`.`id`) WHERE `do`.`id_pelanggan` = '".$rs["id"]."' 
									AND `do`.`tgl_do` BETWEEN '$tglAwal' AND '$tglAkhir'";
						if ($queryJumlah = $data->runQuery($qJumlah)) {
							$rsJumlah = $queryJumlah->fetch_array();
							
							if ($rsJumlah["jumlah"] != null) {
								array_push($detail, $rsJumlah["jumlah"]);
							} else {
								array_push($detail, "0");
							}
						}
						
						array_push($detail, "<button class='btn btn-primary' data-id='".$rs['id']."' data-awal='".$_POST['tglAwal']."' 
									data-akhir='".$_POST['tglAkhir']."' id='btn-show-detail'><i class='fa fa-eye'></i></button>");
						array_push($collect, $detail);
						unset($detail);
					}
				}
				echo json_encode(array("data"=>$collect));
			}
			break;
		case "detail-pesanan-daftar":
			include 'po/class.po.php';
			$data = new po_po();
			
			if (isset($_POST['id']) && $_POST['id'] != "" && isset($_POST['awal']) && $_POST['awal'] != "" && 
			isset($_POST['akhir']) && $_POST['akhir']) {
				
				$detail = array();
				
				$q = "SELECT `do_detail`.`deskripsi`, `tema_layar`.`tema`, `ukuran`.`panjang`, `ukuran`.`lebar`, `ukuran`.`pre`, 
				`do_detail`.`jml`, `do_detail`.`ket` FROM `do` INNER JOIN `do_detail` ON (`do`.`id` = `do_detail`.`id_do`) 
				INNER JOIN `tema_layar` ON (`do_detail`.`id_tema_layar` = `tema_layar`.`id`) 
				INNER JOIN `ukuran` ON (`do_detail`.`id_ukuran` = `ukuran`.`id`) 
				WHERE `do`.`id_pelanggan` = '".$_POST['id']."' AND `do_detail`.`hapus` = '0' AND `do`.`hapus` = '0' AND 
				`do`.`tgl_do` BETWEEN '".$_POST['awal']."' AND '".$_POST['akhir']."';";
				
				if ($query = $data->runQuery($q)) {
					while ($rs = $query->fetch_array()) {
						$detail[] = array("deskripsi"=>$rs["deskripsi"],"tema"=>$rs["tema"],"ukuran"=>($rs["pre"]." ".$rs["panjang"]." x ".$rs["lebar"]),"jml"=>$rs["jml"],"ket"=>$rs["ket"]);
					}
				}
				echo json_encode($detail);
			}
			break;
	}
}




?>