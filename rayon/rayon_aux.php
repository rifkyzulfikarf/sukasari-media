<?php
if( isset($_SESSION['media-data']) && isset($_POST['apa']) && $_POST['apa']<>"" ){

	include 'rayon/class.rayon.php';
	$data = new rayon();

	switch ($_POST['apa']) {
		case 'input-rayon':
			$arr=array();
			if( isset($_POST['rayon']) && isset($_POST['id_area']) && $_POST['rayon']<>"" && $_POST['id_area']<>"" ){
				if( $input = $data->input_rayon($_POST['rayon'], $_POST['id_area']) ){
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

		case 'edit-rayon':
			$arr=array();
			if( isset($_POST['id']) && isset($_POST['rayon']) && isset($_POST['id_area']) && $_POST['rayon']<>"" && $_POST['id']<>"" && $_POST['id_area']<>"" ){
				if( $input = $data->edit_rayon($_POST['id'],$_POST['rayon'], $_POST['id_area']) ){
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

		case 'hapus-rayon':
			$arr=array();
			if( isset($_POST['id']) && $_POST['id']<>"" ){
				if( $input = $data->hapus_rayon($_POST['id']) ){
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