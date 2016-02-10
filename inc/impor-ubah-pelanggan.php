<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Jakarta');
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br \>');

include "blob.php";
require_once "PHPExcel.php";
	
$data = new koneksi();
$ds   = DIRECTORY_SEPARATOR;
 
if (!empty($_FILES)) {
     
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = "../template-report/";
	$temp = explode(".",$_FILES["file"]["name"]);
	$newFileName = rand(1,99999999) . '.' .end($temp);
	$targetFile =  $targetPath. $newFileName;
	move_uploaded_file($tempFile,$targetFile);
	
	$objReader = new PHPExcel_Reader_Excel5();
	$objReader->setReadDataOnly(true);
	$objExcel = $objReader->load("../template-report/".$newFileName);
	
	$objExcel->setActiveSheetIndex(0);
	$highestRow = $objExcel->setActiveSheetIndex(0)->getHighestRow();
	
	for ($row = 2; $row <= $highestRow; $row++) {
		$noreg = $objExcel->getSheet(0)->getCell('A'.$row)->getValue();
		$nama = $objExcel->getSheet(0)->getCell('B'.$row)->getValue();
		$alamat = $objExcel->getSheet(0)->getCell('C'.$row)->getValue();
		$pasar = $objExcel->getSheet(0)->getCell('D'.$row)->getValue();
		$subpasar = $objExcel->getSheet(0)->getCell('E'.$row)->getValue();
		
		$query = $data->runQuery("UPDATE `pelanggan` SET `nama` = '$nama', `alamat` = '$alamat', `pasar` = '$pasar', 
				`sub_pasar` = '$subpasar' WHERE `noreg` = '$noreg';");
	}
	
	
	$objExcel->disconnectWorksheets();
	unset($objExcel);
	unlink($targetFile);
	
}
?>