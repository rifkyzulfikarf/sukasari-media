<?php
if( isset($_SESSION['media-data']) && isset($_POST['apa']) && $_POST['apa']<>"" ){
	
	include 'supplier/class.supplier.php';
	$data = new supplier();

	switch ($_POST['apa']) {
		case 'input-supplier':
			
			$arr = array();

			if( isset($_POST['nama']) && isset($_POST['alamat']) && isset($_POST['telp']) && isset($_POST['fax']) && isset($_POST['email']) && isset($_POST['cp']) && $_POST['nama']<>"" && $_POST['alamat']<>"" ){

				if( $input = $data->input_supplier($_POST['nama'], $_POST['alamat'], $_POST['telp'], $_POST['fax'], $_POST['email'], $_POST['cp']) ){

					$arr['status']=TRUE;
					$arr['msg']="Data tersimpan";
				}else{
					$arr['status']=FALSE;
					$arr['msg']="Gagal menyimpan data..";	
				}

			}else{
				$arr['status']=FALSE;
				$arr['msg']="Lengkapi terlebih dahulu..";
			}

			echo json_encode($arr);

			break;

		case 'edit-supplier':

			$arr = array();

			if( isset($_POST['id']) && isset($_POST['nama']) && isset($_POST['alamat']) && isset($_POST['telp']) && isset($_POST['fax']) && isset($_POST['email']) && isset($_POST['cp']) && $_POST['id']<>"" && $_POST['nama']<>"" && $_POST['alamat']<>"" ){

				if( $edit = $data->edit_supplier( $_POST['id'], $_POST['nama'], $_POST['alamat'], $_POST['telp'], $_POST['fax'], $_POST['email'], $_POST['cp'])  ){

					$arr['status']=TRUE;
					$arr['msg']="Data tersimpan";
				}else{
					$arr['status']=FALSE;
					$arr['msg']="Gagal menyimpan data..";
				}


			}else{
				$arr['status']=FALSE;
				$arr['msg']="Lengkapi terlebih dahulu..";
			}

			echo json_encode($arr);

			break;
			
		case 'hapus-supplier':
			$arr=array();
			if( isset($_POST['id']) && $_POST['id']<>"" ){
				if( $hapus = $data->hapus_supplier($_POST['id']) ){
					$arr['status']=TRUE;
					$arr['msg']="Berhasil dihapus..";
				}else{
					$arr['status']=FALSE;
					$arr['msg']="gagal menghapus";
				}
			}else{
				$arr['status']=FALSE;
				$arr['msg']="Lengkapi data dahulu";
			}

			echo json_encode($arr);

			break;
		
	}



}

?>