<?php
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Europe/London');

	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br \>');

	include "../inc/blob.php";
	include "../do/class.do.php";
	require_once "../inc/PHPExcel.php";
	
	// DEFINE ALL CLASSES
	$data = new do_do();
	$objExcel = PHPExcel_IOFactory::load("../template-report/each-do.xls");
	$objWriter = new PHPExcel_Writer_Excel5($objExcel);
	$objOrderedSign = new PHPExcel_Worksheet_Drawing();
	$objApprovedSign = new PHPExcel_Worksheet_Drawing();
	
	$id = $_GET['id'];
	$layout = $_GET['layout'];
	
	$objExcel->setActiveSheetIndex(0);
	
	// DEFINE STYLES MAY NEED IN EXCEL DOCUMENT
	$styleBorder = array(
	  'borders' => array(
		'allborders' => array(
		  'style' => PHPExcel_Style_Border::BORDER_THIN
		)
	  )
	);
	
	$styleCenter = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
        )
    );
	
	// RETRIEVE DATA AND BIND IN VARIABLES
	$q = "SELECT `do`.*, `pelanggan`.`noreg`, `pelanggan`.`nama`,`pelanggan`.`alamat`,`karyawan`.`nama` as `nama_karyawan`, `level`.`jabatan`, `area`.`area` AS nama_area FROM `do` 
			INNER JOIN `pelanggan` ON `pelanggan`.`id` = `do`.`id_pelanggan`
			INNER JOIN `karyawan` ON `karyawan`.`id` = `do`.`id_karyawan`
			INNER JOIN `level` ON `karyawan`.`level` = `level`.`id` 
			INNER JOIN `area` ON `area`.`id` = `do`.`area`
			WHERE `do`.`id` = '$id' ";
	
	if ($query = $data->runQuery($q)) {
		while ($rs = $query->fetch_array()) {
			$noDO = $rs['no'];
			$tglDO = $rs['tgl_do'];
			$noreg = $rs['noreg'];
			$nama = $rs['nama'];
			$alamat = $rs['alamat'];
			$area = $rs['nama_area'];
			$acc = $rs['acc'];
		}
	}
	
	$q = "SELECT `do`.*, `karyawan`.`nama` AS `nama_karyawan`, `karyawan`.`ttd` AS `ttd`, `level`.`jabatan` FROM `do` 
			INNER JOIN `karyawan` ON `karyawan`.`id` = `do`.`id_karyawan`
			INNER JOIN `level` ON `karyawan`.`level` = `level`.`id` 
			WHERE `do`.`id` = '$id'";
			
	if ($query = $data->runQuery($q)) {
		while ($rs = $query->fetch_array()) {
			$orderedBy = $rs['nama_karyawan'];
			$ttdOrderedBy = ($rs['ttd'] != null) ? $rs['ttd']:"-";
		}
	}
	
	if ($acc != "0") {
		$q = "SELECT `do`.*, `karyawan`.`nama` AS `nama_karyawan`, `karyawan`.`ttd` AS `ttd`, `level`.`jabatan` FROM `do` 
				INNER JOIN `karyawan` ON `karyawan`.`id` = `do`.`acc`
				INNER JOIN `level` ON `karyawan`.`level` = `level`.`id` 
				WHERE `do`.`id` = '$id'";
		if ($query = $data->runQuery($q)) {
			while ($rs = $query->fetch_array()) {
				$approvedBy = $rs['nama_karyawan'];
				$ttdApprovedBy = ($rs['ttd'] != null) ? $rs['ttd']:"-";
			}
		}
	} else {
		$approvedBy = "Belum acc";
		$ttdApprovedBy = 0;
	}
	
	// WRITE REPORT SUMMARY
	$objExcel->getActiveSheet()->SetCellValue('H3', $noDO);
	$objExcel->getActiveSheet()->SetCellValue('H4', $tglDO);
	$objExcel->getActiveSheet()->SetCellValue('D3', $noreg);
	$objExcel->getActiveSheet()->SetCellValue('D4', $nama);
	$objExcel->getActiveSheet()->SetCellValue('D5', $alamat);
	$objExcel->getActiveSheet()->SetCellValue('D6', $area);
	
	// WRITE DO DETAIL ITEMS
	$q = "SELECT * FROM `do_detail` 
			INNER JOIN `tema_layar` ON `do_detail`.`id_tema_layar` = `tema_layar`.`id`
			INNER JOIN `ukuran` ON `do_detail`.`id_ukuran` = `ukuran`.`id`
			WHERE `do_detail`.`id_do` = $id && `do_detail`.`hapus` ='0'";
	$no = 1;
	$startRow = 9;
	if ($query = $data->runQuery($q)) {
		while ($rs = $query->fetch_array()) {
			$objExcel->getActiveSheet()->SetCellValue('A'.$startRow, $no);
			$objExcel->getActiveSheet()->SetCellValue('B'.$startRow, $rs['deskripsi'].".ket : ".$rs['ket']);
			$objExcel->getActiveSheet()->SetCellValue('E'.$startRow, $rs['tema']);
			$objExcel->getActiveSheet()->SetCellValue('F'.$startRow, $rs['pre']." ".$rs['panjang']." x ".$rs['lebar']);
			$objExcel->getActiveSheet()->SetCellValue('H'.$startRow, $rs['jml']);
			
			$objExcel->getActiveSheet()->getStyle('B'.$startRow)->getAlignment()->setWrapText(true);
			$objExcel->getActiveSheet()->getStyle('C'.$startRow)->getAlignment()->setWrapText(true);
			$objExcel->getActiveSheet()->getStyle('D'.$startRow)->getAlignment()->setWrapText(true);
			
			
			if ($layout == "minim") {		//dibalik karena entah kenapa auto height ngga jalan disini
				$objExcel->getActiveSheet()->getRowDimension($startRow)->setRowHeight(-1);
			} else {
				$objExcel->getActiveSheet()->getRowDimension($startRow)->setRowHeight(70);
			}
			
			$objExcel->getActiveSheet()->mergeCells('B'.$startRow.':D'.$startRow);
			$objExcel->getActiveSheet()->mergeCells('F'.$startRow.':G'.$startRow);
			
			$objExcel->getActiveSheet()->getStyle('A'.$startRow)->applyFromArray($styleCenter);
			$objExcel->getActiveSheet()->getStyle('H'.$startRow)->applyFromArray($styleCenter);
			$no++; $startRow++;
		}
	}
	
	// DRAW BORDER ON DO DETAIL ITEMS
	$objExcel->getActiveSheet()->getStyle('A9:H'.($startRow-1))->applyFromArray($styleBorder);
	
	// WRITE DIGITAL SIGNATURE HEADER
	$startRow++;
	$objExcel->getActiveSheet()->SetCellValue('A'.$startRow, "Ordered by ".$orderedBy);
	$objExcel->getActiveSheet()->SetCellValue('A'.($startRow+1), "Approved by ".$approvedBy);
	$objExcel->getActiveSheet()->SetCellValue('H'.$startRow, "Penerima");
	// $objExcel->getActiveSheet()->SetCellValue('F'.$startRow, "Ordered By");
	// $objExcel->getActiveSheet()->SetCellValue('H'.$startRow, "Approved By");
	// $objExcel->getActiveSheet()->mergeCells('F'.$startRow.':G'.$startRow);
	
	// PROVIDE SPACE FOR DIGITAL SIGNATURE
	// $objExcel->getActiveSheet()->mergeCells('E'.($startRow+1).':E'.($startRow+3));
	// $objExcel->getActiveSheet()->mergeCells('F'.($startRow+1).':G'.($startRow+3));
	$objExcel->getActiveSheet()->mergeCells('H'.($startRow+1).':H'.($startRow+3));
	
	// DRAW DIGITAL SIGNATURE
	// if ($ttdOrderedBy != "-") {
		// if (file_exists('../img/'.$ttdOrderedBy)) {
			// $objOrderedSign->setName('ttdOrdered');
			// $objOrderedSign->setDescription('ttd ordered image');
			// $objOrderedSign->setPath('../img/'.$ttdOrderedBy);
			// $objOrderedSign->setHeight(60);
			// $objOrderedSign->setCoordinates('F'.($startRow+1));
			// $offsetX =(146 - $objOrderedSign->getWidth())/2;
			// $objOrderedSign->setOffsetX($offsetX);
			// $objOrderedSign->setWorksheet($objExcel->getActiveSheet());
		// }
	// }
	
	// if ($ttdApprovedBy != 0 || $ttdApprovedBy != "-") {
		// if (file_exists('../img/'.$ttdApprovedBy)) {
			// $objApprovedSign->setName('ttdApproved');
			// $objApprovedSign->setDescription('ttd approved image');
			// $objApprovedSign->setPath('../img/'.$ttdApprovedBy);
			// $objApprovedSign->setHeight(60);
			// $objApprovedSign->setCoordinates('H'.($startRow+1));
			// $offsetX =(146 - $objApprovedSign->getWidth())/2;
			// $objApprovedSign->setOffsetX($offsetX);
			// $objApprovedSign->setWorksheet($objExcel->getActiveSheet());
		// }
	// }
	
	// WRITE DIGITAL SIGNATURE FOOTER
	// $objExcel->getActiveSheet()->SetCellValue('E'.($startRow+4), $nama);
	// $objExcel->getActiveSheet()->SetCellValue('F'.($startRow+4), $orderedBy);
	$objExcel->getActiveSheet()->SetCellValue('H'.($startRow+4), $nama);
	//$objExcel->getActiveSheet()->mergeCells('F'.($startRow+4).':G'.($startRow+4));
	
	// APPLY STYLES IN DIGITAL SIGNATURE
	$objExcel->getActiveSheet()->getStyle('H'.$startRow.':H'.($startRow+4))->applyFromArray($styleBorder);
	$objExcel->getActiveSheet()->getStyle('H'.$startRow.':H'.($startRow+4))->applyFromArray($styleCenter);
	
	// UNSET STYLE VARIABLES
	unset($styleBorder);
	unset($styleCenter);
	
	// PROTECT EXCEL DOCUMENT FOR BEING EDITING
	$objExcel->getActiveSheet()->getProtection()->setPassword('Sukasari1234');
	$objExcel->getActiveSheet()->getProtection()->setSheet(true);
	
	// TELL BROWSER TO DOWNLOAD EXCEL DOCUMENT
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="'.$noDO.'_'.$layout.'.xls"');
	$objWriter->save('php://output');
	
?>