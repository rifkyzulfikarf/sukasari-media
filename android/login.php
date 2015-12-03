<?php
include('../inc/blob.php');

class data extends koneksi{



  function cek_pin($pin){
    $pin=$this->clearText($pin);
    if( $query=$this->runQuery("SELECT `karyawan`.`nama` , `karyawan`.`id` FROM `karyawan` INNER JOIN `pin` ON `pin`.`id_karyawan`=`karyawan`.`id` WHERE `pin`.`pin`='$pin' ") ){
      if( $query->num_rows > 0 ){
        $rs=$query->fetch_array();
        return array("id" => $rs['id'], "nama" => $rs['nama']);

      }else{
        return FALSE;
      }
    }else{
      return FALSE;
    }

  }

  function jenis_pekerjaan(){
    $jenis=array();
    if( $query=$this->runQuery("SELECT `id`,`nama` FROM `jenis_pekerjaan` WHERE `hapus`='0' ") ){
      if( $query->num_rows > 0 ){
        while( $rs=$query->fetch_assoc() ){
          $jenis[]=$rs;
        }
        return $jenis;
      }else{
        return FALSE;
      }
    }else{
      return FALSE;
    }

  }

}




header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");


$input=json_decode(file_get_contents("php://input"),true);
$data=new data();


if( isset($input['pin']) && $input['pin']<>"" ){

  if( $pin=$data->cek_pin($input['pin']) ){

    if( $jenis=$data->jenis_pekerjaan() ){
      $feedback['token'] = $pin['id'];
      $feedback['nama']=$pin['nama'];      

      $feedback['jenis']=$jenis;
      echo json_encode($feedback);
    }
  }

}





//echo json_encode(array("pin"=>$coba));

?>
