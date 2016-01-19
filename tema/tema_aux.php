<?php
if( isset($_POST['apa'])  && $_POST['apa']<>""  ){

	include 'tema/class.tema.php';
	$data = new tema();

	switch ($_POST['apa']) {
		case 'input-tema':

			$arr=array();
			if(isset($_POST['tema']) && $_POST['tema']!=""){

				if( $insert = $data->tambah($_POST['tema']) ){
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
		case 'edit-tema':

			$arr=array();
			if( isset($_POST['id']) && isset($_POST['tema']) && $_POST['id']!="" && $_POST['tema']!="" ){

				if( $insert = $data->ubah($_POST['id'],$_POST['tema']) ){
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



	}

}

?>