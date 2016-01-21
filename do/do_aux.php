<?php
if( isset($_POST['apa']) && $_POST['apa']<>"" ){

	// include '../inc/tes.php';
	// include 'class.do.php';
	include 'do/class.do.php';
	$data = new do_do();

	switch ($_POST['apa']) {
		case 'help':
			if( isset($_POST['deskripsi']) && isset($_POST['tema']) && isset($_POST['ukuran']) && isset($_POST['jumlah']) && isset($_POST['ket']) ){
				if( $help = $data->runQuery("INSERT INTO `do_help`(`deskripsi`,`id_tema_layar`,`id_ukuran`, `jumlah`,`ket`) VALUES ('".$_POST['deskripsi']."', '".$_POST['tema']."', '".$_POST['ukuran']."', '".$_POST['jumlah']."', '".$_POST['ket']."' ) ") ){
					$id = $data->lastInsertID();

					if( $cek = $data->runQuery("SELECT `do_help`.* , `tema_layar`.`tema`,`ukuran`.`pre`,`ukuran`.`panjang`,`ukuran`.`lebar` FROm `do_help` INNER JOIN `tema_layar` ON `tema_layar`.`id`=`do_help`.`id_tema_layar` INNER JOIN `ukuran` ON `ukuran`.`id` = `do_help`.`id_ukuran` WHERE `id` = '".$id."'") ){
						if( $cek->num_rows > 0 ){
							$rs = $cek->fetch_array();
							echo "<tr>
								<td>".$rs['deskripsi']."</td>
								<td>".$rs['tema']."</td>
								<td>".$rs['pre']." ".$rs['panjang']." x ".$rs['lebar']."</td>
								<td>".$rs['jumlah']."</td>
								<td>".$rs['ket']."</td>
								<td></td>
							</tr>";
						}else{
							echo "<script>alert('Gagal menyimpan detail..');</script>";
						}
					}else{
						echo "<script>alert('Gagal menyimpan detail..');</script>";	
					}
					
				}else{
					echo "<script>alert('Gagal menyimpan detail..');</script>";
				}


			}
			break;
		case "simpan":
			$arr=array();
			if (isset($_POST['data-detail']) && $_POST['data-detail'] != "" && isset($_POST['idPelanggan']) && $_POST['idPelanggan'] != "" && 
			isset($_POST['tglDO']) && $_POST['tglDO'] != "") {
				
				$idPelanggan = $_POST['idPelanggan'];
				
				if ($query = $data->runQuery("Select noreg, area From pelanggan Where id = '$idPelanggan'")) {
					if ($query->num_rows > 0) {
						$rs = $query->fetch_array();
						$noregPelanggan = $rs['noreg'];
						$area = $rs['area'];
					}
				}
				
				$noDO = $data->generateKodeDO();
				$tglDO = $_POST['tglDO'];
				$status = "1";
				$hapus = "0";
				$idKaryawan = $_SESSION['media-id'];
				$acc = "0";
				$tglAcc = "0000-00-00";
				
				if ($simpan = $data->simpan_do($noDO, $idPelanggan, $noregPelanggan, $area, $tglDO, $status, $hapus, $idKaryawan, $acc, $tglAcc)) {
					
					if ($query = $data->runQuery("Select id From do Where no = '$noDO'")) {
						if ($query->num_rows > 0) {
							$rs = $query->fetch_array();
							$idDO = $rs['id'];
						}
					}
					
					$detail = json_decode($_POST['data-detail'], true);
					
					
					foreach ($detail as $item) {
						
						if ($simpanDetail = $data->simpan_detail_do($idDO, $item['deskripsi'], $item['tema'], $item['ukuran'], $item['jumlah'], $item['ket'])) {
							$arr['status']=TRUE;
						}
					}
					$simpanNotif = $data->runQuery("INSERT INTO notif(`jenis`, `keterangan`, `untuk_level`, `read`) VALUES('1','DO Baru $idDO','4','0');");
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
		case "daftar-do":
			if (isset($_POST['tglAwal']) && isset($_POST['tglAkhir'])) {
				$collect = array();
				$tglAwal = $_POST['tglAwal'];
				$tglAkhir = $_POST['tglAkhir'];
				
				if ($_SESSION['media-status'] == e_code("2") || $_SESSION['media-status'] == e_code("9") || $_SESSION['media-level'] == "2") {
					$area = "%";
				} else {
					$area = $_SESSION['media-area'];
				}
				
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
							<button class='btn btn-sm btn-danger btn-delete-do' id='btn-delete-do' data-id='".$rs["id"]."'><i class='fa fa-trash'></i></button>");
						array_push($collect, $detail);
						unset($detail);
					}
				}
				echo json_encode(array("data"=>$collect));
			}
			break;
		case "daftar-detail-do":
			if (isset($_POST['idDO'])) {
				$idDO = $_POST['idDO'];
				$detail = array();
				
				if ($query = $data->detail_do($idDO)) {
					while ($rs = $query->fetch_array()) {
						$btn = "<button class='btn btn-sm btn-danger btn-delete-item-detail' id='btn-delete-item-detail' data-id='".$rs[0]."' data-iddo='".$rs[1]."'><i class='fa fa-trash'></i></button>";
						$detail[] = array("deskripsi"=>$rs["deskripsi"],"tema"=>$rs["tema"],"ukuran"=>($rs["pre"]." ".$rs["panjang"]." x ".$rs["lebar"]),"jml"=>$rs["jml"],"ket"=>$rs["ket"],"btn"=>$btn);
					}
				}
				echo json_encode($detail);
			}
			break;
		case "hapus-do":
			$arr=array();
			if (isset($_POST['idDO'])) {
				$idDO = $_POST['idDO'];
				
				if ($hapus = $data->hapus_do($idDO)) {
					$arr['status']=TRUE;
					$arr['msg']="Data terhapus..";
				} else {
					$arr['status']=FALSE;
					$arr['msg']="Gagal menghapus..";
				}
			}
			echo json_encode($arr);
			break;
		case "hapus-detail-do":
			$arr = array();
			if (isset($_POST['idDO'])) {
				$idDO = $_POST['idDO'];
				
				if ($hapus = $data->hapus_detail_do($idDO)) {
					$arr['status'] = TRUE;
					$arr['msg'] = "Data terhapus..";
				} else {
					$arr['status'] = FALSE;
					$arr['msg'] = "Gagal menghapus..";
				}
			}
			echo json_encode($arr);
			break;
		case "acc-daftar-do":
			if (isset($_POST['tglAwal']) && isset($_POST['tglAkhir']) && isset($_POST['area'])) {
				$collect = array();
				$tglAwal = $_POST['tglAwal'];
				$tglAkhir = $_POST['tglAkhir'];
				
				if ($query = $data->daftar_do($_POST['area'], $_SESSION['media-id'], $tglAwal, $tglAkhir, "%")) {
					while ($rs = $query->fetch_array()) {
						$detail = array();
						array_push($detail, $rs["no"]);
						array_push($detail, $rs["tgl_do"]);
						array_push($detail, $rs["nama_rayon"]);
						array_push($detail, $rs["nama"]." ".$rs["alamat"]);
						array_push($detail, $rs["nama_area"]);
						switch ($rs["status"]) {
							case "1":
								$status = "Diajukan";
								$btn = "<button class='btn btn-sm btn-orange btn-show-detail' id='btn-show-detail' data-id='".$rs["id"]."'><i class='fa fa-eye'></i></button>
										<button class='btn btn-sm btn-orange btn-acc-do' id='btn-acc-do' data-id='".$rs["id"]."'><i class='fa fa-check'></i></button>
										<button class='btn btn-sm btn-orange btn-tolak-do' id='btn-tolak-do' data-id='".$rs["id"]."'><i class='fa fa-remove'></i></button>";
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
		case "acc-daftar-detail-do":
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
		case "simpan-acc-do":
			$arr=array();
			if (isset($_POST['idDO'])) {
				$idDO = $_POST['idDO'];
				
				if ($acc = $data->simpan_acc_do($idDO, $_SESSION['media-id'])) {
					//$simpanNotif = $data->runQuery("INSERT INTO notif(`jenis`, `keterangan`, `untuk_level`, `read`) VALUES('2','Acc DO $idDO','2','0');");
					$simpanNotif = $data->runQuery("INSERT INTO notif(`jenis`, `keterangan`, `untuk_level`, `read`) VALUES('2','Acc DO $idDO','3','0');");
					$arr['status']=TRUE;
					$arr['msg']="Data tersimpan..";
				} else {
					$arr['status']=FALSE;
					$arr['msg']="Gagal menyimpan..";
				}
			}
			echo json_encode($arr);
			break;
		case "simpan-tolak-do":
			$arr=array();
			if (isset($_POST['idDO'])) {
				$idDO = $_POST['idDO'];
				
				if ($tolak = $data->simpan_tolak_do($idDO, $_SESSION['media-id'])) {
					$simpanNotif = $data->runQuery("INSERT INTO notif(`jenis`, `keterangan`, `untuk_level`, `read`) VALUES('3','Tolak DO $idDO','5','0');");
					$arr['status']=TRUE;
					$arr['msg']="Data tersimpan..";
				} else {
					$arr['status']=FALSE;
					$arr['msg']="Gagal menyimpan..";
				}
			}
			echo json_encode($arr);
			break;
	}
}




?>