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
	$objExcel = PHPExcel_IOFactory::load("../template-report/impor-add.xls");
	$objWriter = new PHPExcel_Writer_Excel5($objExcel);
	
	$objExcel->setActiveSheetIndex(1);
	
	$startRow = 4;
	if ($query = $data->runQuery("SELECT `id`,`rayon` FROM `rayon` WHERE `hapus` = '0'")) {
		while ($rs = $query->fetch_array()) {
			$objExcel->getActiveSheet()->SetCellValue('A'.$startRow, $rs['id']);
			$objExcel->getActiveSheet()->SetCellValue('B'.$startRow, $rs['rayon']);
			$startRow++;
		}
	}
	
	$startRow = 4;
	if ($query = $data->runQuery("SELECT `id`,`area` FROM `area` WHERE `hapus` = '0'")) {
		while ($rs = $query->fetch_array()) {
			$objExcel->getActiveSheet()->SetCellValue('G'.$startRow, $rs['id']);
			$objExcel->getActiveSheet()->SetCellValue('H'.$startRow, $rs['area']);
			$startRow++;
		}
	}
	
	$objExcel->setActiveSheetIndex(0);
	
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="impor-add.xls"');
	$objWriter->save('php://output');
?>