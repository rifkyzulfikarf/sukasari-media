<?php
	session_start();
	include "../inc/blob.php";
	include "../po/class.po.php";
	require_once "../inc/PHPExcel.php";
	
	$data = new po_po();
	$idLogin = $_SESSION['media-id'];
	$objExcel = PHPExcel_IOFactory::load("../template-report/penerimaan-barang.xls");
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
	
	$startRow = 7; $amount = 0; $totalHarga = 0; $totalJumlah = 0;
	
	$q = "SELECT `realisasi_po`.`id`, `realisasi_po`.`tgl`, `supplier`.`nama`, `tema_layar`.`tema`, `ukuran`.`panjang`
		, `ukuran`.`lebar`, `ukuran`.`pre`, `realisasi_po`.`jumlah`, `po_detail`.`harga` FROM `po_detail` 
		INNER JOIN `po` ON (`po_detail`.`id_po` = `po`.`id`) INNER JOIN `realisasi_po` 
		ON (`realisasi_po`.`id_detail_po` = `po_detail`.`id`) INNER JOIN `supplier` 
		ON (`po`.`id_supplier` = `supplier`.`id`) INNER JOIN `do_detail` 
		ON (`po_detail`.`id_do_detail` = `do_detail`.`id`) INNER JOIN `tema_layar` 
		ON (`do_detail`.`id_tema_layar` = `tema_layar`.`id`) INNER JOIN `ukuran` 
		ON (`do_detail`.`id_ukuran` = `ukuran`.`id`) WHERE `supplier`.`id` LIKE '$supplier' AND 
		`realisasi_po`.`tgl` BETWEEN '$tglAwal' AND '$tglAkhir';";
	if ($query = $data->runQuery($q)) {
		while ($rs = $query->fetch_array()) {
			$amount = $rs['panjang'] * $rs['lebar'] * $rs['jumlah'] * $rs['harga'];
			$objExcel->getActiveSheet()->SetCellValue('A'.$startRow, $rs['tgl']);
			$objExcel->getActiveSheet()->SetCellValue('C'.$startRow, $rs['id']);
			$objExcel->getActiveSheet()->SetCellValue('D'.$startRow, $rs['nama']);
			$objExcel->getActiveSheet()->SetCellValue('F'.$startRow, $rs['tema']);
			$objExcel->getActiveSheet()->SetCellValue('G'.$startRow, $rs['pre']." ".$rs['panjang']." x ".$rs['lebar']);
			$objExcel->getActiveSheet()->SetCellValue('H'.$startRow, $rs['jumlah']);
			$objExcel->getActiveSheet()->SetCellValue('I'.$startRow, $rs['harga']);
			$objExcel->getActiveSheet()->SetCellValue('J'.$startRow, $amount);
			
			
			$objExcel->getActiveSheet()->mergeCells('A'.$startRow.':B'.$startRow);
			$objExcel->getActiveSheet()->mergeCells('D'.$startRow.':E'.$startRow);
			$objExcel->getActiveSheet()->getRowDimension($startRow)->setRowHeight(-1);
			$objExcel->getActiveSheet()->getStyle('I'.$startRow)->getNumberFormat()->setFormatCode('#,##0.00');
			$objExcel->getActiveSheet()->getStyle('J'.$startRow)->getNumberFormat()->setFormatCode('#,##0.00');
			$startRow++; $totalHarga = $totalHarga + $amount; $totalJumlah = $totalJumlah + $rs['jumlah'];
			
		}
	}
	
	$objExcel->getActiveSheet()->SetCellValue('A'.$startRow, "Total");
	$objExcel->getActiveSheet()->SetCellValue('H'.$startRow, $totalJumlah);
	$objExcel->getActiveSheet()->SetCellValue('J'.$startRow, $totalHarga);
	$objExcel->getActiveSheet()->getStyle('J'.$startRow)->getNumberFormat()->setFormatCode('#,##0.00');
	$objExcel->getActiveSheet()->mergeCells('A'.$startRow.':G'.$startRow);
	$objExcel->getActiveSheet()->getStyle('A'.$startRow)->applyFromArray($styleCenter);
	$objExcel->getActiveSheet()->getStyle('A6:J'.$startRow)->applyFromArray($styleBorder);
	
	// WRITE DIGITAL SIGNATURE HEADER
	$startRow++; $startRow++;
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
			$offsetX =(103 - $objPrintedSign->getWidth())/2;
			$objPrintedSign->setOffsetX($offsetX);
			$objPrintedSign->setWorksheet($objExcel->getActiveSheet());
		}
	}
	
	// WRITE DIGITAL SIGNATURE FOOTER
	$objExcel->getActiveSheet()->SetCellValue('H'.($startRow+4), $printedBy);
	$objExcel->getActiveSheet()->mergeCells('H'.($startRow+4).':I'.($startRow+4));
	$objExcel->getActiveSheet()->getStyle('H'.($startRow+4))->getAlignment()->setWrapText(true);
	
	// APPLY STYLES IN DIGITAL SIGNATURE
	$objExcel->getActiveSheet()->getStyle('H'.$startRow.':I'.($startRow+4))->applyFromArray($styleBorder);
	$objExcel->getActiveSheet()->getStyle('H'.$startRow.':I'.($startRow+4))->applyFromArray($styleCenter);
	
	
	unset($styleBorder);
	unset($styleCenter);
	
	$objExcel->getActiveSheet()->getProtection()->setPassword('Sukasari1234');
	$objExcel->getActiveSheet()->getProtection()->setSheet(true);
	
	header('Content-type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="pb-'.$tglAwal.'-'.$tglAkhir.'-supplier-'.$namaSupplier.'.xls"');
	$objWriter->save('php://output');
	
?>