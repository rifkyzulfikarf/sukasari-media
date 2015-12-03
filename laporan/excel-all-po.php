<?php
	session_start();
	include "../inc/blob.php";
	include "../po/class.po.php";
	require_once "../inc/PHPExcel.php";
	
	$data = new po_po();
	$idLogin = $_SESSION['media-id'];
	$objExcel = PHPExcel_IOFactory::load("../template-report/all-po.xls");
	$objWriter = new PHPExcel_Writer_Excel5($objExcel);
	$objPrintedSign = new PHPExcel_Worksheet_Drawing();
	
	$tglAwal = $_GET['tglAwal'];
	$tglAkhir = $_GET['tglAkhir'];
	$supplier = $_GET['supplier'];
	$namaSupplier = $_GET['namasupplier'];
	
	$objExcel->setActiveSheetIndex(0);
	
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
	
	$q = "SELECT nama, ttd FROM karyawan WHERE id = '$idLogin'";	
	if ($query = $data->runQuery($q)) {
		while ($rs = $query->fetch_array()) {
			$printedBy = $rs['nama'];
			$ttdPrintedBy = ($rs['ttd'] != null) ? $rs['ttd']:"-";
		}
	}
	
	$objExcel->getActiveSheet()->SetCellValue('C3', $tglAwal." s/d ".$tglAkhir);
	$objExcel->getActiveSheet()->SetCellValue('C4', $namaSupplier);
	
	$startRow = 7;
	if ($query = $data->getDaftarPO("%", $supplier, $tglAwal, $tglAkhir, "%")) {
		while ($rs = $query->fetch_array()) {
			switch ($rs['status']) {
				case "1":
					$status = "Diajukan";
					break;
				case "2":
					$status = "Acc";
					break;
				case "3":
					$status = "Ditolak";
					break;
			}
			
			$q = "SELECT `po`.*, `karyawan`.`nama` AS `nama_karyawan`, `level`.`jabatan` FROM `po` 
					INNER JOIN `karyawan` ON `karyawan`.`id` = `po`.`acc`
					INNER JOIN `level` ON `karyawan`.`level` = `level`.`id` 
					WHERE `po`.`id` = '$rs[0]'";
					
			if ($qAcc = $data->runQuery($q)) {
				while ($rsAcc = $qAcc->fetch_array()) {
					$asesor = $rsAcc['nama_karyawan'];
				}
			}
			
			$objExcel->getActiveSheet()->SetCellValue('A'.$startRow, $rs['no_po']);
			$objExcel->getActiveSheet()->SetCellValue('D'.$startRow, $rs['tgl_po']);
			$objExcel->getActiveSheet()->SetCellValue('E'.$startRow, $rs['tgl_kirim']);
			$objExcel->getActiveSheet()->SetCellValue('F'.$startRow, $rs['nama']);
			$objExcel->getActiveSheet()->SetCellValue('G'.$startRow, $rs['alamat']);
			$objExcel->getActiveSheet()->SetCellValue('H'.$startRow, $status);
			$objExcel->getActiveSheet()->SetCellValue('I'.$startRow, ($rs['tgl_acc'] == "0000-00-00"?"-":$rs['tgl_acc']));
			$objExcel->getActiveSheet()->SetCellValue('J'.$startRow, $asesor);
			
			$objExcel->getActiveSheet()->mergeCells('A'.$startRow.':C'.$startRow);
			$objExcel->getActiveSheet()->getStyle('G'.$startRow)->getAlignment()->setWrapText(true);
			$objExcel->getActiveSheet()->getRowDimension($startRow)->setRowHeight(40);
			$startRow++;
			
		}
	}

	$objExcel->getActiveSheet()->getStyle('A6:J'.($startRow-1))->applyFromArray($styleBorder);
	
	// WRITE DIGITAL SIGNATURE HEADER
	$startRow++;
	$objExcel->getActiveSheet()->SetCellValue('H'.$startRow, "Printed By");
	$objExcel->getActiveSheet()->mergeCells('H'.$startRow.':I'.$startRow);
	
	// PROVIDE SPACE FOR DIGITAL SIGNATURE
	$objExcel->getActiveSheet()->mergeCells('H'.($startRow+1).':I'.($startRow+3));
	
	// DRAW DIGITAL SIGNATURE
	if ($ttdPrintedBy != "-") {
		if (file_exists('../img/'.$ttdPrintedBy)) {
			$objPrintedSign->setName('ttdOrdered');
			$objPrintedSign->setDescription('ttd ordered image');
			$objPrintedSign->setPath('../img/'.$ttdPrintedBy);
			$objPrintedSign->setHeight(60);
			$objPrintedSign->setCoordinates('H'.($startRow+1));
			$offsetX =(137 - $objPrintedSign->getWidth())/2;
			$objPrintedSign->setOffsetX($offsetX);
			$objPrintedSign->setWorksheet($objExcel->getActiveSheet());
		}
	}
	
	// WRITE DIGITAL SIGNATURE FOOTER
	$objExcel->getActiveSheet()->SetCellValue('H'.($startRow+4), $printedBy);
	$objExcel->getActiveSheet()->mergeCells('H'.($startRow+4).':I'.($startRow+4));
	
	// APPLY STYLES IN DIGITAL SIGNATURE
	$objExcel->getActiveSheet()->getStyle('H'.$startRow.':I'.($startRow+4))->applyFromArray($styleBorder);
	$objExcel->getActiveSheet()->getStyle('H'.$startRow.':I'.($startRow+4))->applyFromArray($styleCenter);
	
	
	unset($styleBorder);
	unset($styleCenter);
	
	$objExcel->getActiveSheet()->getProtection()->setPassword('Sukasari1234');
	$objExcel->getActiveSheet()->getProtection()->setSheet(true);
	
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="po-'.$tglAwal.'-'.$tglAkhir.'-supplier-'.$namaSupplier.'.xls"');
	$objWriter->save('php://output');
	
?>