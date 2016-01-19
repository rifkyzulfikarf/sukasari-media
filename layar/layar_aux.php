<?php
if( isset($_POST['apa'])  && $_POST['apa']<>""  ){

	include 'layar/class.layar.php';
	$data = new layar();

	switch ($_POST['apa']) {
		case 'input-layar':

			$arr=array();
			if(isset($_POST['bahan']) && isset($_POST['harga']) && $_POST['bahan']!="" && $_POST['harga']!="" ){

				if( $insert = $data->tambah($_POST['bahan'],$_POST['harga']) ){
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
		case 'edit-layar':

			$arr=array();
			if( isset($_POST['id']) && isset($_POST['bahan']) && isset($_POST['harga']) && $_POST['id']!="" && $_POST['bahan']!="" && $_POST['harga']!="" ){

				if( $insert = $data->ubah($_POST['id'],$_POST['bahan'],$_POST['harga']) ){
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