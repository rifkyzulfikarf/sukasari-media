<?php
session_start();
$ds          = DIRECTORY_SEPARATOR;
 
if (!empty($_FILES)) {
	
	include 'blob.php';
	$id = $_POST['id'];
     
    $tempFile = $_FILES['file']['tmp_name'];
      
    $targetPath = "../img/";
     
	$temp = explode(".",$_FILES["file"]["name"]);
	
	$newFileName = rand(1,99999999) . '.' .end($temp);
	
	$targetFile =  $targetPath. $newFileName;
	
	$koneksi = new koneksi();
	
	if ($cek = $koneksi->runQuery("SELECT ttd FROM karyawan WHERE id = '$id'")) {
		while ($rs = $cek->fetch_array()) {
			if ($rs['ttd'] != null) {
				if (file_exists("../img/".$rs['ttd'])) {
					unlink("../img/".$rs['ttd']);
				}
			}
		}
	}
	
	if ($simpan = $koneksi->runQuery("UPDATE karyawan SET ttd = '$newFileName' WHERE id = '$id'")) {
		move_uploaded_file($tempFile,$targetFile);
    }
}
?>