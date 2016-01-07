<?php
	$level = $_SESSION['media-level'];
	
	if ($_POST['apa'] == "get") {
		$data = new koneksi();
		$arr=array();
		$listNotif = "";
		$jumlahNotif = 0;
		
		if ($level == "1" || $level == "4") {
			if ($query = $data->runQuery("SELECT COUNT(id) FROM notif WHERE `jenis` = '1' AND `read` = '0' AND untuk_level = '$level'")) {
				$rs = $query->fetch_array();
				if ($rs[0] > 0) {
					$listNotif .= "<li><a>".$rs[0]." DO Diajukan</a></li>";
					$jumlahNotif = $jumlahNotif + 1;
				}
			}
		}
		
		if ($level == "1" || $level == "3" || $level == "2") {
			if ($query = $data->runQuery("SELECT COUNT(id) FROM notif WHERE `jenis` = '2' AND `read` = '0' AND untuk_level = '$level'")) {
				$rs = $query->fetch_array();
				if ($rs[0] > 0) {
					$listNotif .= "<li><a>".$rs[0]." DO Diacc</a></li>";
					$jumlahNotif = $jumlahNotif + 1;
				}
			}
		}
		
		if ($level == "1" || $level == "5") {
			if ($query = $data->runQuery("SELECT COUNT(id) FROM notif WHERE `jenis` = '3' AND `read` = '0' AND untuk_level = '$level'")) {
				$rs = $query->fetch_array();
				if ($rs[0] > 0) {
					$listNotif .= "<li><a>".$rs[0]." DO Ditolak</a></li>";
					$jumlahNotif = $jumlahNotif + 1;
				}
			}
		}
		
		if ($level == "1" || $level == "2") {
			if ($query = $data->runQuery("SELECT COUNT(id) FROM notif WHERE `jenis` = '4' AND `read` = '0'")) {
				$rs = $query->fetch_array();
				if ($rs[0] > 0) {
					$listNotif .= "<li><a>".$rs[0]." PO Diajukan</a></li>";
					$jumlahNotif = $jumlahNotif + 1;
				}
			}
		}
		
		if ($level == "1" || $level == "3") {
			if ($query = $data->runQuery("SELECT COUNT(id) FROM notif WHERE `jenis` = '5' AND `read` = '0'")) {
				$rs = $query->fetch_array();
				if ($rs[0] > 0) {
					$listNotif .= "<li><a>".$rs[0]." PO Diacc</a></li>";
					$jumlahNotif = $jumlahNotif + 1;
				}
			}
		}
		
		if ($level == "1") {
			if ($query = $data->runQuery("SELECT COUNT(id) FROM notif WHERE `jenis` = '6' AND `read` = '0'")) {
				$rs = $query->fetch_array();
				if ($rs[0] > 0) {
					$listNotif .= "<li><a>".$rs[0]." PO Ditolak</a></li>";
					$jumlahNotif = $jumlahNotif + 1;
				}
			}
		}
		
		if ($level == "1" || $level == "4") {
			if ($query = $data->runQuery("SELECT COUNT(id) FROM notif WHERE `jenis` = '7' AND `read` = '0' AND untuk_level = '$level'")) {
				$rs = $query->fetch_array();
				if ($rs[0] > 0) {
					$listNotif .= "<li><a>".$rs[0]." PO Terealisasi</a></li>";
					$jumlahNotif = $jumlahNotif + 1;
				}
			}
		}
		
		$listNotif .= "<li><a href='#' class='notif-read'> Tandai sudah dibaca</a></li>";
		
		$arr['listNotif']=$listNotif;
		$arr['jumlahNotif']=$jumlahNotif;
		
		
		echo json_encode($arr);
	} elseif ($_POST['apa'] == "set") {
		$data = new koneksi();
		$arr=array();
		$query = $data->runQuery("UPDATE notif SET `read` = '1' WHERE untuk_level = '$level'");
		$arr['pesan']="Notifikasi sudah dibaca..";
		echo json_encode($arr);
	}


?>