<?php
if( isset($_SESSION['media-data']) && isset($_POST['apa']) && $_POST['apa']<>"" ){

	include 'jabatan/class.jabatan.php';
	$data = new jabatan();

	switch ($_POST['apa']) {
		case 'input-jabatan':
			$arr=array();
			if( isset($_POST['jabatan']) && $_POST['jabatan']<>"" ){
				if( $input = $data->input_jabatan($_POST['jabatan']) ){
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

		case 'edit-jabatan':
			$arr=array();
			if( isset($_POST['id']) && isset($_POST['jabatan']) && $_POST['jabatan']<>"" && $_POST['id']<>"" ){
				if( $input = $data->edit_jabatan($_POST['id'],$_POST['jabatan']) ){
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

		case 'hapus-jabatan':
			$arr=array();
			if( isset($_POST['id']) && $_POST['id']<>"" ){
				if( $input = $data->hapus_jabatan($_POST['id']) ){
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