<?php
	include "inc/blob.php";
	$data = new koneksi();
	$queryUpdate = "";
	
	if ($res = $data->runQuery("SELECT id, noreg, area FROM pelanggan ORDER BY id ASC")) {
		while ($rs = $res->fetch_array()) {
			$noreg = explode(".", $rs['noreg']);
			
			switch ($rs['area']) {
				case "1" : $newNoReg = "14.".$noreg[1]; break;
				case "2" : $newNoReg = "10.".$noreg[1]; break;
				case "3" : $newNoReg = "08.".$noreg[1]; break;
				case "4" : $newNoReg = "12.".$noreg[1]; break;
				case "5" : $newNoReg = "11.".$noreg[1]; break;
				case "6" : $newNoReg = "13.".$noreg[1]; break;
				case "7" : $newNoReg = "07.".$noreg[1]; break;
				case "8" : $newNoReg = "06.".$noreg[1]; break;
				case "9" : $newNoReg = "15.".$noreg[1]; break;
				case "10" : $newNoReg = "01.".$noreg[1]; break;
				case "11" : $newNoReg = "04.".$noreg[1]; break;
				case "12" : $newNoReg = "05.".$noreg[1]; break;
				case "13" : $newNoReg = "09.".$noreg[1]; break;
				case "14" : $newNoReg = "03.".$noreg[1]; break;
				case "32" : $newNoReg = "02.".$noreg[1]; break;
			}
			
			if ($newNoReg != $rs['noreg']) {
				$queryUpdate .= "UPDATE pelanggan SET noreg = '$newNoReg' WHERE id = '".$rs['id']."';";
			}
			
		}
		
		echo $queryUpdate;
		//if ($q = $data->runMultipleQueries($queryUpdate)) {
			//echo "Update sukses";
		//}
		
		
	}
?>