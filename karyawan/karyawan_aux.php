<?php
if( isset($_POST['apa'])  && $_POST['apa']<>""  ){

	include 'karyawan/class.karyawan.php';
	$data = new karyawan();

	switch ($_POST['apa']) {
		case 'input-karyawan':

			$arr=array();
			if( isset($_POST['nama']) && isset($_POST['area']) && isset($_POST['jabatan']) && $_POST['nama']<>"" && $_POST['area']<>"" && $_POST['jabatan']<>"" ){

				if( $insert = $data->input_karyawan($_POST['nama'],$_POST['jabatan'],$_POST['area']) ){
					$arr['status'] = TRUE;
					$arr['msg'] = "Data tersimpan";
				}else{
					$arr['status'] = FALSE;
					$arr['msg'] = "gagal menyimpan data.. Silahkan cek kembali";
				}

			}else{
				$arr['status'] = FALSE;
				$arr['msg'] = "Lengkapi terlebih dahulu..";

			}

			echo json_encode($arr);

			break;

	//------------------------------------------------
		case 'edit-karyawan':

			$arr=array();
			if( isset($_POST['id']) && isset($_POST['nama']) && isset($_POST['area']) && isset($_POST['jabatan']) && $_POST['id']<>"" && $_POST['nama']<>"" && $_POST['area']<>"" && $_POST['jabatan']<>"" ){

				if( $insert = $data->edit_karyawan($_POST['id'], $_POST['nama'],$_POST['jabatan'],$_POST['area']) ){
					$arr['status'] = TRUE;
					$arr['msg'] = "Data tersimpan";
				}else{
					$arr['status'] = FALSE;
					$arr['msg'] = "gagal menyimpan data.. Silahkan cek kembali";
				}

			}else{
				$arr['status'] = FALSE;
				$arr['msg'] = "Lengkapi terlebih dahulu..";

			}

			echo json_encode($arr);

			break;

	//-----------------------------------------

		case 'hapus-karyawan':
			$arr = array();
			if( isset($_POST['data']) ){
				if( $hapus = $data->hapus_karyawan($_POST['data']) ){
					$arr['status']= TRUE;
				}else{
					$arr['status']=FALSE;
				}

			}else{
				$arr['status']=FALSE;
			}
			echo json_encode($arr);

			break;



	}

}

?>