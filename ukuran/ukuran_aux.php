<?php
if( isset($_POST['apa'])  && $_POST['apa']<>""  ){

	include 'ukuran/class.ukuran.php';
	$data = new ukuran();

	switch ($_POST['apa']) {
		case 'input-ukuran':

			$arr=array();
			if(isset($_POST['panjang']) && isset($_POST['lebar']) && $_POST['panjang']!="" && $_POST['lebar']!="" ){

				if( $insert = $data->input_ukuran("-",$_POST['panjang'],$_POST['lebar'],"P MMT") ){
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
		case 'edit-ukuran':

			$arr=array();
			if( isset($_POST['id']) && isset($_POST['panjang']) && isset($_POST['lebar']) && $_POST['id']!="" && $_POST['panjang']!="" && $_POST['lebar']!="" ){

				if( $insert = $data->edit_ukuran($_POST['id'],"-",$_POST['panjang'],$_POST['lebar'],"P MMT") ){
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