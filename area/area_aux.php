<?php
if( isset($_SESSION['media-data']) && isset($_POST['apa']) && $_POST['apa']<>"" ){

	include 'area/class.area.php';
	$data = new area();

	switch ($_POST['apa']) {
		case 'input-area':
			$arr=array();
			if( isset($_POST['area']) && $_POST['area']<>"" ){
				if( $input = $data->input_area($_POST['area']) ){
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

		case 'edit-area':
			$arr=array();
			if( isset($_POST['id']) && isset($_POST['area']) && $_POST['area']<>"" && $_POST['id']<>"" ){
				if( $input = $data->edit_area($_POST['id'],$_POST['area']) ){
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

		case 'hapus-area':
			$arr=array();
			if( isset($_POST['id']) && $_POST['id']<>"" ){
				if( $input = $data->hapus_area($_POST['id']) ){
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