<?php
if( isset($_SESSION['media-data']) && isset($_POST['apa']) && $_POST['apa']<>"" ){

	include 'pelanggan/class.pelanggan.php';
	$data = new pelanggan();

	switch ($_POST['apa']) {
		case 'get-rayon':
			if (isset($_POST['area']) && $_POST['area'] != "") {
				if ($query = $data->runQuery("SELECT `id`, `rayon` FROM `rayon` WHERE `id_area` = '".$_POST['area']."' AND `hapus` = '0';")) {
					while ($rs = $query->fetch_array()) {
						echo "<option value='".$rs['id']."'>".$rs['rayon']."</option>";
					}
				}
				break;
			}
			break;
		case 'get-pelanggan':
			$collect = array();
			if (isset($_POST['area']) && $_POST['area'] != "" && isset($_POST['rayon']) && $_POST['rayon'] != "") {
				$area = $_POST['area'];
				$rayon = $_POST['rayon'];
				
				$qCari = "SELECT `pelanggan`.*, `area`.`area` as `nm_area`, `rayon`.`rayon` as `nm_rayon` FROM `pelanggan` 
						INNER JOIN `area` ON `area`.`id`=`pelanggan`.`area` INNER JOIN `rayon` ON `rayon`.`id`=`pelanggan`.`rayon` 
						WHERE `pelanggan`.`area` = '$area' AND `pelanggan`.`rayon` = '$rayon' AND `pelanggan`.`hapus`= '0' ORDER BY `pelanggan`.`id` DESC ";
				
				if ($query = $data->runQuery($qCari)) {
					while ($rs = $query->fetch_array()) {
						$detail = array();
						array_push($detail, $rs["noreg"]);
						array_push($detail, stripslashes($rs["nama"]));
						array_push($detail, stripslashes($rs["alamat"]));
						array_push($detail, stripslashes($rs["nm_rayon"]));
						array_push($detail, stripslashes($rs["pasar"]));
						array_push($detail, stripslashes($rs["sub_pasar"]));
						array_push($detail, stripslashes($rs["type"]));
						array_push($detail, stripslashes($rs["nm_area"]));
						array_push($detail, stripslashes($rs["kode_pos"]));
						array_push($detail, "<a href='#' class='btn btn-sm btn-danger btn-orange edit-pelanggan' data-id='".$rs['id']."' data-noreg='".$rs['noreg']."' 
									data-nama='".stripslashes($rs['nama'])."' data-alamat='".stripslashes($rs['alamat'])."' data-rayon='".$rs['rayon']."' 
									data-pasar='".stripslashes($rs['pasar'])."' data-sub_pasar='".stripslashes($rs['sub_pasar'])."' data-type='".stripslashes($rs['type'])."' 
									data-area='".$rs['area']."' data-kode_pos='".stripslashes($rs['kode_pos'])."'  ><i class='fa fa-edit'></i></a>  
									<a href='#' class='btn btn-sm btn-danger hapus-pelanggan' data-id='".$rs['id']."' data-noreg='".$rs['noreg']."' 
									data-nama='".stripslashes($rs['nama'])."' data-alamat='".stripslashes($rs['alamat'])."' data-rayon='".$rs['rayon']."' 
									data-pasar='".stripslashes($rs['pasar'])."' data-sub_pasar='".stripslashes($rs['sub_pasar'])."' data-type='".stripslashes($rs['type'])."' 
									data-area='".$rs['area']."' data-kode_pos='".stripslashes($rs['kode_pos'])."'  ><i class='fa fa-trash-o'></i></a>");
						array_push($collect, $detail);
						unset($detail);
					}
				}
			}
			echo json_encode(array("data"=>$collect));
			break;
		case 'input-pelanggan':
			$arr=array();
			if( isset($_POST['noreg']) && isset($_POST['nama']) && isset($_POST['alamat']) && isset($_POST['rayon']) && isset($_POST['pasar']) && isset($_POST['sub_pasar']) && isset($_POST['type']) && isset($_POST['area']) && isset($_POST['kode_pos']) && $_POST['noreg']<>"" && $_POST['nama']<>"" && $_POST['alamat']<>"" && $_POST['rayon']<>"" && $_POST['area']<>"" ){
				if( $input = $data->input_pelanggan($_POST['noreg'], $_POST['nama'],$_POST['alamat'], $_POST['rayon'], $_POST['pasar'], $_POST['sub_pasar'], $_POST['type'], $_POST['area'], $_POST['kode_pos'] ) ){
					$arr['status']=TRUE;
					$arr['msg']="Data tersimpan..";
				}else{
					$arr['status']=FALSE;
					$arr['msg']="Gagal menyimpan..";	
				}
			}else{
				$arr['status']=FALSE;
				$arr['msg']="Lengkapi terlebih dahulu..";
			}

			echo json_encode($arr);

			break;
		//----------------------------

		case 'edit-pelanggan':
			$arr=array();

			if( isset($_POST['id']) && isset($_POST['noreg']) && isset($_POST['nama']) && isset($_POST['alamat']) && isset($_POST['rayon']) && isset($_POST['pasar']) && isset($_POST['sub_pasar']) && isset($_POST['type']) && isset($_POST['area']) && isset($_POST['kode_pos']) && $_POST['id']<>"" && $_POST['noreg']<>"" && $_POST['nama']<>"" && $_POST['alamat']<>"" && $_POST['rayon']<>"" && $_POST['area']<>"" ){

				if( $input = $data->edit_pelanggan( $_POST['id'], $_POST['noreg'], $_POST['nama'],$_POST['alamat'], $_POST['rayon'], $_POST['pasar'], $_POST['sub_pasar'], $_POST['type'], $_POST['area'], $_POST['kode_pos'] ) ){

					$arr['status']=TRUE;
					$arr['msg']="Data tersimpan..";
				}else{
					$arr['status']=FALSE;
					$arr['msg']="Gagal menyimpan..";	
				}
			}else{
				$arr['status']=FALSE;
				$arr['msg']="Lengkapi terlebih dahulu..";
			}

			echo json_encode($arr);

			break;

		case 'hapus-pelanggan':
			$arr=array();
			if( isset($_POST['id']) && $_POST['id']<>"" ){

				if( $hapus = $data->hapus_pelanggan( $_POST['id'] ) ){
					$arr['status']=TRUE;
					$arr['msg']="Berhasil dihapus..";
					
					
					
				}else{
					$arr['status']=FALSE;
					$arr['msg']="Gagal menghapus..";
				}
			}else{
				$arr['status']=FALSE;
				$arr['msg']="Insufficient data stored..";
				
			}

			echo json_encode($arr);

			break;

		
		
	}

}

?>