<?php

if( isset($_SESSION['media-data']) && isset($_POST['apa']) && $_POST['apa']<>"" ){

	include 'pin/class.pin.php';
	$data = new pin();

	switch ($_POST['apa']) {
		case 'input-pin':
			$arr = array();

			if( isset($_POST['pin']) && isset($_POST['id_karyawan']) && $_POST['pin']<>"" && $_POST['id_karyawan']<>"" ){
				if( $input = $data->input_pin($_POST['id_karyawan'], $_POST['pin']) ){
					
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
		
		case 'edit-pin':
			$arr = array();

			if( isset($_POST['pin']) && isset($_POST['id_karyawan']) && $_POST['pin']<>"" && $_POST['id_karyawan']<>"" ){
				if( $input = $data->edit_pin($_POST['id_karyawan'], $_POST['pin']) ){
					
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

		case 'hapus-pin':
			$arr = array();

			if(  isset($_POST['id_karyawan']) && $_POST['id_karyawan']<>"" ){
				if( $input = $data->hapus_pin($_POST['id_karyawan']) ){
					
					$arr['status']=TRUE;
					$arr['msg']="Berhasil dihapus..";
				}else{
					$arr['status']=FALSE;
					$arr['msg']="Gagal menghapus..";
				}
			}else{
				$arr['status']=FALSE;
				$arr['msg']="Lengkapi terlebih dahulu..";
			}

			echo json_encode($arr);
			
			break;
		
	}


}


?>