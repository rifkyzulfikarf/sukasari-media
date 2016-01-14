<?php
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Europe/London');

	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br \>');

	include "../inc/blob.php";
	include "../po/class.po.php";
	require_once "../inc/PHPExcel.php";
	include "../inc/phpqrcode/qrlib.php";
	
	// DEFINE ALL CLASSES
	$data = new po_po();
	$objExcel = PHPExcel_IOFactory::load("../template-report/each-po.xls");
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
	$q = "SELECT `po`.*, `supplier`.`nama`,`supplier`.`alamat`,`supplier`.`telp`, `supplier`.`email`,`supplier`.`cp` FROM `po` 
			INNER JOIN `supplier` ON `supplier`.`id` = `po`.`id_supplier`
			WHERE `po`.`id` = '$id'";
			
	if ($query = $data->runQuery($q)) {
		while ($rs = $query->fetch_array()) {
			$noPO = $rs['no_po'];
			$tglPO = date("d-m-Y",strtotime($rs['tgl_po']));
			$top = $rs['top'];
			$tglKirim = date("d-m-Y",strtotime($rs['tgl_kirim']));
			$nama = $rs['nama'];
			$alamat = $rs['alamat'];
			$telp = $rs['telp'];
			$email = $rs['email'];
			$cp = $rs['cp'];
			$acc = $rs['acc'];
		}
	}
	
	$q = "SELECT `po`.*, `karyawan`.`nama` AS `nama_karyawan`, `karyawan`.`ttd` AS `ttd`, `level`.`jabatan` FROM `po` 
			INNER JOIN `karyawan` ON `karyawan`.`id` = `po`.`id_karyawan`
			INNER JOIN `level` ON `karyawan`.`level` = `level`.`id` 
			WHERE `po`.`id` = '$id'";
			
	if ($query = $data->runQuery($q)) {
		while ($rs = $query->fetch_array()) {
			$orderedBy = $rs['nama_karyawan'];
			$ttdOrderedBy = ($rs['ttd'] != null) ? $rs['ttd']:"-";
		}
	}
	
	if ($acc != "0") {
		$q = "SELECT `po`.*, `karyawan`.`nama` AS `nama_karyawan`, `karyawan`.`ttd` AS `ttd`, `level`.`jabatan` FROM `po` 
				INNER JOIN `karyawan` ON `karyawan`.`id` = `po`.`acc`
				INNER JOIN `level` ON `karyawan`.`level` = `level`.`id` 
				WHERE `po`.`id` = '$id'";
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
	$objExcel->getActiveSheet()->SetCellValue('A4', $nama);
	$objExcel->getActiveSheet()->SetCellValue('A5', $alamat);
	$objExcel->getActiveSheet()->SetCellValue('A6', "Tel. ".$telp);
	$objExcel->getActiveSheet()->SetCellValue('A7', "Email ".$email);
	$objExcel->getActiveSheet()->SetCellValue('A8', "CP. ".$cp);
	$objExcel->getActiveSheet()->SetCellValue('G4', $noPO);
	$objExcel->getActiveSheet()->SetCellValue('G5', $tglPO);
	$objExcel->getActiveSheet()->SetCellValue('G6', $top);
	$objExcel->getActiveSheet()->SetCellValue('G7', $tglKirim);
	
	// WRITE DO DETAIL ITEMS
	$no = 1;
	$startRow = 11;
	$summeter = 0;
	$total = 0;
	if ($query = $data->getDetailPO($id)) {
		while ($rs = $query->fetch_array()) {
			$meter = ($rs['panjang']*$rs['lebar']*$rs['jml']);
			
			$objExcel->getActiveSheet()->SetCellValue('A'.$startRow, $no);
			$objExcel->getActiveSheet()->SetCellValue('B'.$startRow, $rs['bahan']);
			$objExcel->getActiveSheet()->SetCellValue('C'.$startRow, $rs['deskripsi'].".ket:".$rs['ket']);
			$objExcel->getActiveSheet()->SetCellValue('D'.$startRow, $rs['tema']);
			$objExcel->getActiveSheet()->SetCellValue('E'.$startRow, $rs['panjang']." x ".$rs['lebar']);
			$objExcel->getActiveSheet()->SetCellValue('F'.$startRow, $rs['jml']);
			$objExcel->getActiveSheet()->SetCellValue('G'.$startRow, $meter);
			$objExcel->getActiveSheet()->SetCellValue('H'.$startRow, $rs['harga/m']);
			$objExcel->getActiveSheet()->SetCellValue('I'.$startRow, $rs['subtotal']);
			
			$objExcel->getActiveSheet()->getStyle('B'.$startRow)->getAlignment()->setWrapText(true);
			$objExcel->getActiveSheet()->getStyle('C'.$startRow)->getAlignment()->setWrapText(true);
			$objExcel->getActiveSheet()->getStyle('D'.$startRow)->getAlignment()->setWrapText(true);
			
			if ($layout == "full") {
				$objExcel->getActiveSheet()->getRowDimension($startRow)->setRowHeight(-1);
			} else {
				$objExcel->getActiveSheet()->getRowDimension($startRow)->setRowHeight(15);
			}
			
			$objExcel->getActiveSheet()->getStyle('A'.$startRow)->applyFromArray($styleCenter);
			$objExcel->getActiveSheet()->getStyle('B'.$startRow)->applyFromArray($styleCenter);
			$objExcel->getActiveSheet()->getStyle('F'.$startRow)->applyFromArray($styleCenter);
			$objExcel->getActiveSheet()->getStyle('G'.$startRow)->applyFromArray($styleCenter);
			$objExcel->getActiveSheet()->getStyle('H'.$startRow)->applyFromArray($styleCenter);
			$objExcel->getActiveSheet()->getStyle('H'.$startRow)->getNumberFormat()->setFormatCode('#,##0.00');
			$objExcel->getActiveSheet()->getStyle('I'.$startRow)->getNumberFormat()->setFormatCode('#,##0.00');
			$no++; $startRow++; $summeter = $summeter + $meter; $total = $total + $rs['subtotal'];
		}
	}
	
	// WRITE TOTAL
	$objExcel->getActiveSheet()->SetCellValue('A'.$startRow, "Total");
	$objExcel->getActiveSheet()->mergeCells('A'.$startRow.':F'.$startRow);
	$objExcel->getActiveSheet()->getStyle('A'.$startRow)->applyFromArray($styleCenter);
	$objExcel->getActiveSheet()->SetCellValue('G'.$startRow, $summeter);
	$objExcel->getActiveSheet()->getStyle('G'.$startRow)->applyFromArray($styleCenter);
	$objExcel->getActiveSheet()->SetCellValue('I'.$startRow, $total);
	$objExcel->getActiveSheet()->getStyle('I'.$startRow)->getNumberFormat()->setFormatCode('#,##0.00');
	
	// DRAW BORDER ON DO DETAIL ITEMS
	$objExcel->getActiveSheet()->getStyle('A11:I'.$startRow)->applyFromArray($styleBorder);
	
	//create qrcode
	$fileName = 'qrcode.png'; 
    $pngAbsoluteFilePath = $fileName;
	QRcode::png(base64_encode($noPO), $pngAbsoluteFilePath, QR_ECLEVEL_L, 2);
	
	// WRITE DIGITAL SIGNATURE HEADER
	$startRow++; $startRow++;
	$objExcel->getActiveSheet()->SetCellValue('A'.$startRow, "Ordered By ".$orderedBy);
	$objExcel->getActiveSheet()->SetCellValue('A'.($startRow+1), "Approved By ".$approvedBy);
	//$objExcel->getActiveSheet()->SetCellValue('A'.($startRow+2), base64_encode(base64_encode($noPO)));
	// $objExcel->getActiveSheet()->SetCellValue('E'.$startRow, "Ordered By");
	// $objExcel->getActiveSheet()->SetCellValue('G'.$startRow, "Approved By");
	$objExcel->getActiveSheet()->SetCellValue('I'.$startRow, "Confirmed By");
	// $objExcel->getActiveSheet()->mergeCells('E'.$startRow.':F'.$startRow);
	// $objExcel->getActiveSheet()->mergeCells('G'.$startRow.':H'.$startRow);
	
	// PROVIDE SPACE FOR DIGITAL SIGNATURE
	// $objExcel->getActiveSheet()->mergeCells('E'.($startRow+1).':F'.($startRow+3));
	// $objExcel->getActiveSheet()->mergeCells('G'.($startRow+1).':H'.($startRow+3));
	$objExcel->getActiveSheet()->mergeCells('I'.($startRow+1).':I'.($startRow+3));
	
	//DRAW QRCODE
	$objOrderedSign->setName('QRCode');
	$objOrderedSign->setDescription('QRCode');
	$objOrderedSign->setPath('qrcode.png');
	//$objOrderedSign->setHeight(60);
	$objOrderedSign->setCoordinates('A'.($startRow+2));
	//$offsetX =(132 - $objOrderedSign->getWidth())/2;
	//$objOrderedSign->setOffsetX($offsetX);
	$objOrderedSign->setWorksheet($objExcel->getActiveSheet());
	
	// DRAW DIGITAL SIGNATURE
	// if ($ttdOrderedBy != "-") {
		// if (file_exists('../img/'.$ttdOrderedBy)) {
			// $objOrderedSign->setName('ttdOrdered');
			// $objOrderedSign->setDescription('ttd ordered image');
			// $objOrderedSign->setPath('../img/'.$ttdOrderedBy);
			// $objOrderedSign->setHeight(60);
			// $objOrderedSign->setCoordinates('E'.($startRow+1));
			// $offsetX =(132 - $objOrderedSign->getWidth())/2;
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
			// $objApprovedSign->setCoordinates('G'.($startRow+1));
			// $offsetX =(132 - $objApprovedSign->getWidth())/2;
			// $objApprovedSign->setOffsetX($offsetX);
			// $objApprovedSign->setWorksheet($objExcel->getActiveSheet());
		// }
	// }
	
	// WRITE DIGITAL SIGNATURE FOOTER
	// $objExcel->getActiveSheet()->SetCellValue('E'.($startRow+4), $orderedBy);
	// $objExcel->getActiveSheet()->SetCellValue('G'.($startRow+4), $approvedBy);
	$objExcel->getActiveSheet()->SetCellValue('I'.($startRow+4), $cp);
	// $objExcel->getActiveSheet()->mergeCells('E'.($startRow+4).':F'.($startRow+4));
	// $objExcel->getActiveSheet()->mergeCells('G'.($startRow+4).':H'.($startRow+4));
	
	// APPLY STYLES IN DIGITAL SIGNATURE
	// $objExcel->getActiveSheet()->getStyle('E'.($startRow+4))->getAlignment()->setWrapText(true);
	// $objExcel->getActiveSheet()->getStyle('G'.($startRow+4))->getAlignment()->setWrapText(true);
	$objExcel->getActiveSheet()->getStyle('I'.($startRow+4))->getAlignment()->setWrapText(true);
	$objExcel->getActiveSheet()->getRowDimension($startRow+4)->setRowHeight(30);
	$objExcel->getActiveSheet()->getStyle('I'.$startRow.':I'.($startRow+4))->applyFromArray($styleBorder);
	$objExcel->getActiveSheet()->getStyle('I'.$startRow.':I'.($startRow+4))->applyFromArray($styleCenter);
	
	// UNSET STYLE VARIABLES
	unset($styleBorder);
	unset($styleCenter);
	
	// PROTECT EXCEL DOCUMENT FOR BEING EDITING
	$objExcel->getActiveSheet()->getProtection()->setPassword('Sukasari1234');
	$objExcel->getActiveSheet()->getProtection()->setSheet(true);
	
	// TELL BROWSER TO DOWNLOAD EXCEL DOCUMENT
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="'.$noPO.'_'.$layout.'.xls"');
	$objWriter->save('php://output');
	unlink('qrcode.png');
	
?>