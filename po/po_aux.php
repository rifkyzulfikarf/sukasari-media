<?php
if( isset($_POST['apa']) && $_POST['apa']<>"" ){
	//include '../inc/tes.php';
	//include 'class.po.php';
	include 'po/class.po.php';
	$data = new po_po();
	
	switch ($_POST['apa']) {
		case "isi-daftar-supplier" :
			include 'supplier/class.supplier.php';
			$supplier = new supplier();
			if ($daftar = $supplier->daftar_supplier()) {
				while ($rs = $daftar->fetch_array() ) {
					echo "<option value='".$rs['id']."'>".stripslashes($rs['nama']).", ".$rs['alamat']."</option>";
				}
			}
			break;
		case "isi-daftar-do" :
			if (isset($_POST['tglAwal']) && isset($_POST['tglAkhir'])) {
				include 'do/class.do.php';
				$do = new do_do();
				if ($daftar = $do->daftar_do("%", "%", $_POST['tglAwal'], $_POST['tglAkhir'], "2")) {
					while ($rs = $daftar->fetch_array()) {
						echo "<option value='".$rs['id']."'>".$rs['no'].", ".$rs['tgl_do'].", ".stripslashes($rs['nama']).", ".$rs['nama_area']."</option>";
					}
				}
			}
			break;
		case "isi-daftar-item-do" :
			if (isset($_POST['idDO'])) {
				include 'do/class.do.php';
				$do = new do_do();
				if ($daftar = $do->detail_do($_POST['idDO'])) {
					while ($rs = $daftar->fetch_array()) {
						echo "<option value='".$rs[0]."' data-tema='".$rs[9]."' data-pre='".$rs[14]."' data-panjang='".$rs[12]."' data-lebar='".$rs[13]."' data-jml='".$rs[5]."'>".$rs[5]." ".$rs[9].", ".$rs[14]." ".$rs[12]." x ".$rs[13]."</option>";
					}
				}
			}
			break;
		case "isi-daftar-layar" :
			include 'layar/class.layar.php';
			$layar = new layar();
			if ($daftar = $layar->getLayar()) {
				while ($rs = $daftar->fetch_array()) {
					echo "<option value='".$rs['no']."' data-harga='".$rs['harga/m']."'>".$rs['bahan']."</option>";
				}
			}
			break;
		case "simpan" :
			$arr=array();
			if (isset($_POST['data-detail']) && isset($_POST['idSupplier']) && isset($_POST['tglPO']) && isset($_POST['tglKirim']) && isset($_POST['top']) && isset($_POST['totalBiaya'])) {
				
				$noPO = $data->generateKodePO();
				$idSupplier = $_POST['idSupplier'];
				$tglPO = $_POST['tglPO'];
				$tglKirim = $_POST['tglKirim'];
				$totalBiaya = $_POST['totalBiaya'];
				$top = $_POST['top'];
				$status = "1";
				$hapus = "0";
				$idKaryawan = $_SESSION['media-id'];
				$acc = "0";
				$tglAcc = "0000-00-00";
				 
				if ($simpan = $data->simpan_po($noPO, $idSupplier, $tglPO, $top, $tglKirim, $totalBiaya, $status, $idKaryawan, $acc, $tglAcc, $hapus)) {
					
					if ($query = $data->runQuery("Select id From po Where no_po = '$noPO'")) {
						if ($query->num_rows > 0) {
							$rs = $query->fetch_array();
							$idPO = $rs['id'];
						}
					}
					
					$detail = json_decode($_POST['data-detail'], true);
					
					
					foreach ($detail as $item) {
						if ($simpanDetail = $data->simpan_detail_po($idPO, $item['idItem'], $item['idJenisLayar'], $item['harga'], $item['subtotal'], "0")) {
							$arr['status']=TRUE;
						}
					}
					$simpanNotif = $data->runQuery("INSERT INTO notif(`jenis`, `keterangan`, `untuk_level`,`read`) VALUES('4','PO Baru $idPO','-','0');");
					$arr['msg']="Data tersimpan..";
				} else {
					$arr['status']=FALSE;
					$arr['msg']="Gagal menyimpan..";
				}
			} else {
				$arr['status']=FALSE;
				$arr['msg']="Lengkapi terlebih dahulu..";
			}

			echo json_encode($arr);
			break;
		case "daftar-po":
			if (isset($_POST['tglAwal']) && isset($_POST['tglAkhir'])) {
				$collect = array();
				$tglAwal = $_POST['tglAwal'];
				$tglAkhir = $_POST['tglAkhir'];
				
				if ($query = $data->getDaftarPO("%", "%", $tglAwal, $tglAkhir, "%")) {
					while ($rs = $query->fetch_array()) {
						$detail = array();
						array_push($detail, $rs["no_po"]);
						array_push($detail, $rs["tgl_po"]);
						array_push($detail, $rs["tgl_kirim"]);
						array_push($detail, $rs["nama"]);
						array_push($detail, "Rp ".number_format($rs["total_biaya"],0,",","."));
						array_push($detail, $rs["tgl_kirim_ke_supplier"]);
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
							"<button class='btn btn-sm btn-orange btn-ubah-tgl-kirim' id='btn-ubah-tgl-kirim' data-id='".$rs["id"]."'><i class='fa fa-calendar'></i></button> 
							<button class='btn btn-sm btn-orange btn-show-detail' id='btn-show-detail' data-id='".$rs["id"]."'><i class='fa fa-eye'></i></button>
							<button class='btn btn-sm btn-danger btn-delete-po' id='btn-delete-po' data-id='".$rs["id"]."'><i class='fa fa-trash'></i></button>");
						array_push($collect, $detail);
						unset($detail);
					}
				}
				echo json_encode(array("data"=>$collect));
			}
			break;
		case "acc-daftar-po":
			if (isset($_POST['tglAwal']) && isset($_POST['tglAkhir'])) {
				$collect = array();
				$tglAwal = $_POST['tglAwal'];
				$tglAkhir = $_POST['tglAkhir'];
				
				if ($query = $data->getDaftarPO("%", "%", $tglAwal, $tglAkhir, "%")) {
					while ($rs = $query->fetch_array()) {
						$detail = array();
						array_push($detail, $rs["no_po"]);
						array_push($detail, $rs["tgl_po"]);
						array_push($detail, $rs["tgl_kirim"]);
						array_push($detail, $rs["nama"]);
						array_push($detail, "Rp ".number_format($rs["total_biaya"],0,",","."));
						switch ($rs["status"]) {
							case "1":
								$status = "Diajukan";
								$btn = "<button class='btn btn-sm btn-orange btn-show-detail' id='btn-show-detail' data-id='".$rs["id"]."'><i class='fa fa-eye'></i></button>
										<button class='btn btn-sm btn-orange btn-acc-po' id='btn-acc-po' data-id='".$rs["id"]."'><i class='fa fa-check'></i></button>
										<button class='btn btn-sm btn-orange btn-tolak-po' id='btn-tolak-po' data-id='".$rs["id"]."'><i class='fa fa-remove'></i></button>";
								break;
							case "2":
								$status = "Acc";
								$btn = "<button class='btn btn-sm btn-orange btn-show-detail' id='btn-show-detail' data-id='".$rs["id"]."'><i class='fa fa-eye'></i></button>";
								break;
							case "3":
								$status = "Ditolak";
								$btn = "<button class='btn btn-sm btn-orange btn-show-detail' id='btn-show-detail' data-id='".$rs["id"]."'><i class='fa fa-eye'></i></button>";
								break;
						}
						array_push($detail, $status);
						array_push($detail, $btn);
						array_push($collect, $detail);
						unset($detail);
					}
				}
				echo json_encode(array("data"=>$collect));
			}
			break;
		case "daftar-detail-po":
			if (isset($_POST['idPO'])) {
				$idDO = $_POST['idPO'];
				$detail = array();
				
				if ($query = $data->getDetailPO($idDO)) {
					while ($rs = $query->fetch_array()) {
						$btn = "<button class='btn btn-sm btn-ubah-tgl-kirim btn-orange' id='btn-ubah-tgl-kirim' data-id='".$rs[0]."'><i class='fa fa-calendar'></i></button> 
								<button class='btn btn-sm btn-danger btn-delete-item-detail' id='btn-delete-item-detail' data-id='".$rs[0]."' data-idpo='".$rs[1]."'><i class='fa fa-trash'></i></button>";
						$luas = $rs["panjang"] * $rs["lebar"] * $rs["jml"];
						$detail[] = array("gsm"=>$rs["bahan"],"deskripsi"=>$rs["deskripsi"],"tema"=>$rs["tema"],"ukuran"=>($rs["panjang"]." x ".$rs["lebar"]),"jml"=>$rs["jml"],"luas"=>$luas,"unit"=>("Rp ".number_format($rs["harga/m"],0,",",".")),"subtotal"=>("Rp ".number_format($rs["subtotal"],0,",",".")),"tglkirim"=>$rs["tgl_kirim"],"btn"=>$btn);
					}
				}
				echo json_encode($detail);
			}
			break;
		case "acc-daftar-detail-po":
			if (isset($_POST['idPO'])) {
				$idDO = $_POST['idPO'];
				$detail = array();
				
				if ($query = $data->getDetailPO($idDO)) {
					while ($rs = $query->fetch_array()) {
						$luas = $rs["panjang"] * $rs["lebar"] * $rs["jml"];
						$detail[] = array("pelanggan"=>($rs["rayon"]."-".$rs["nama"]." ".$rs["alamat"]),"gsm"=>$rs["bahan"],
						"deskripsi"=>$rs["deskripsi"],"tema"=>$rs["tema"],"ukuran"=>($rs["panjang"]." x ".$rs["lebar"]),
						"jml"=>$rs["jml"],"luas"=>$luas,"unit"=>("Rp ".number_format($rs["harga/m"],0,",",".")),
						"subtotal"=>("Rp ".number_format($rs["subtotal"],0,",",".")));
					}
				}
				echo json_encode($detail);
			}
			break;
		case "hapus-po":
			$arr=array();
			if (isset($_POST['idPO'])) {
				$idPO = $_POST['idPO'];
				
				if ($hapus = $data->hapus_po($idPO)) {
					$arr['status']=TRUE;
					$arr['msg']="Data terhapus..";
				} else {
					$arr['status']=FALSE;
					$arr['msg']="Gagal menghapus..";
				}
			}
			echo json_encode($arr);
			break;
		case "hapus-detail-po":
			$arr = array();
			if (isset($_POST['id'])) {
				$id = $_POST['id'];
				
				if ($hapus = $data->hapus_detail_po($id)) {
					$arr['status'] = TRUE;
					$arr['msg'] = "Data terhapus..";
				} else {
					$arr['status'] = FALSE;
					$arr['msg'] = "Gagal menghapus..";
				}
			}
			echo json_encode($arr);
			break;
		case "simpan-acc-po":
			$arr=array();
			if (isset($_POST['idPO'])) {
				$idPO = $_POST['idPO'];
				
				if ($acc = $data->simpan_acc_po($idPO, $_SESSION['media-id'])) {
					$simpanNotif = $data->runQuery("INSERT INTO notif(`jenis`, `keterangan`, `untuk_level`, `read`) VALUES('5','Acc PO $idPO','-','0');");
					$arr['status']=TRUE;
					$arr['msg']="Data tersimpan..";
				} else {
					$arr['status']=FALSE;
					$arr['msg']="Gagal menyimpan..";
				}
			}
			echo json_encode($arr);
			break;
		case "simpan-tolak-po":
			$arr=array();
			if (isset($_POST['idPO'])) {
				$idPO = $_POST['idPO'];
				
				if ($tolak = $data->simpan_tolak_po($idPO, $_SESSION['media-id'])) {
					$simpanNotif = $data->runQuery("INSERT INTO notif(`jenis`, `keterangan`, `untuk_level`, `read`) VALUES('6','Tolak PO $idPO','-','0');");
					$arr['status']=TRUE;
					$arr['msg']="Data tersimpan..";
				} else {
					$arr['status']=FALSE;
					$arr['msg']="Gagal menyimpan..";
				}
			}
			echo json_encode($arr);
			break;
		case "realisasi-daftar-po":
			if (isset($_POST['tglAwal']) && isset($_POST['tglAkhir'])) {
				$collect = array();
				$tglAwal = $_POST['tglAwal'];
				$tglAkhir = $_POST['tglAkhir'];
				
				if ($query = $data->getDaftarPO("%", "%", $tglAwal, $tglAkhir, "2")) {
					while ($rs = $query->fetch_array()) {
						$detail = array();
						array_push($detail, $rs["no_po"]);
						array_push($detail, $rs["tgl_po"]);
						array_push($detail, $rs["tgl_kirim"]);
						array_push($detail, $rs["nama"]);
						array_push($detail, 
							"<button class='btn btn-sm btn-orange btn-show-detail' id='btn-show-detail' data-id='".$rs["id"]."'><i class='fa fa-eye'></i></button>");
						array_push($collect, $detail);
						unset($detail);
					}
				}
				echo json_encode(array("data"=>$collect));
			}
			break;
		case "realisasi-daftar-detail-po":
			if (isset($_POST['idPO'])) {
				$idDO = $_POST['idPO'];
				$detail = array();
				
				if ($query = $data->getDetailPO($idDO)) {
					while ($rs = $query->fetch_array()) {
						
						if ($qJumlahKirim = $data->runQuery("SELECT SUM(jumlah) FROM realisasi_po WHERE id_detail_po = '".$rs[0]."'")) {
							$rsJumlahKirim = $qJumlahKirim->fetch_array();
							if ($rsJumlahKirim[0] === NULL) {
								$jumlahKirim = 0;
							} else {
								$jumlahKirim = $rsJumlahKirim[0];
							}
						}
						if ($jumlahKirim <> $rs["jml"]) {
							$btn = "<button class='btn btn-sm btn-realisasi-item-detail btn-orange' id='btn-realisasi-item-detail' data-id='".$rs[0]."' data-idpo='".$rs[1]."'><i class='fa fa-pencil'></i></button>";
						} else {
							$btn = "<button class='btn btn-sm disabled'><i class='fa fa-check'></i></button>";
						}
						$detail[] = array("gsm"=>$rs["bahan"],"deskripsi"=>$rs["deskripsi"],"tema"=>$rs["tema"],"ukuran"=>($rs["panjang"]." x ".$rs["lebar"]),"jml"=>$rs["jml"],"jmlKirim"=>$jumlahKirim,"btn"=>$btn);
					}
				}
				echo json_encode($detail);
			}
			break;
		case "simpan-realisasi" :
			$arr=array();
			if (isset($_POST['tgl']) && isset($_POST['idDetailPO']) && isset($_POST['jumlah']) && $_POST['jumlah'] <> "" ) {
				if ($simpan = $data->simpan_realisasi($_POST['tgl'], $_POST['idDetailPO'], $_POST['jumlah'], $_SESSION['media-id'], "0")) {
					$simpanNotif = $data->runQuery("INSERT INTO notif(`jenis`, `keterangan`, `untuk_level`, `read`) VALUES('7','Realisasi PO ".$_POST['idDetailPO']."','4','0');");
					$arr['status']=TRUE;
					$arr['msg']="Data tersimpan..";
				} else {
					$arr['status']=FALSE;
					$arr['msg']="Gagal menyimpan..";
				}
			} else {
				$arr['status']=FALSE;
				$arr['msg']="Lengkapi dahulu..";
			}
			echo json_encode($arr);
			break;
		case "ubah-tgl-kirim-ke-supplier" :
			$arr=array();
			if (isset($_POST['idPO']) && isset($_POST['tgl']) && $_POST['idPO'] != "" && $_POST['tgl'] != "") {
				if ($ubah = $data->ubah_tgl_kirim_ke_supplier($_POST['idPO'], $_POST['tgl'])) {
					$arr['status']=TRUE;
					$arr['msg']="Data tersimpan..";
				} else {
					$arr['status']=FALSE;
					$arr['msg']="Gagal menyimpan..";
				}
			} else {
				$arr['status']=FALSE;
				$arr['msg']="Lengkapi dahulu..";
			}
			echo json_encode($arr);
			break;
		case "ubah-tgl-kirim-ke-tujuan" :
			$arr=array();
			if (isset($_POST['idDetail']) && isset($_POST['tgl']) && $_POST['idDetail'] != "" && $_POST['tgl'] != "") {
				if ($ubah = $data->ubah_tgl_kirim_ke_tujuan($_POST['idDetail'], $_POST['tgl'])) {
					$arr['status']=TRUE;
					$arr['msg']="Data tersimpan..";
				} else {
					$arr['status']=FALSE;
					$arr['msg']="Gagal menyimpan..";
				}
			} else {
				$arr['status']=FALSE;
				$arr['msg']="Lengkapi dahulu..";
			}
			echo json_encode($arr);
			break;
	}
}	
?>