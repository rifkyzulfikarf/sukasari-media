<?php

class layar extends koneksi {

	function getLayar() {
		if ($query = $this->runQuery("SELECT * FROM jenis_layar")) {
			if ($query->num_rows > 0) {
				return $query;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	
}

?>