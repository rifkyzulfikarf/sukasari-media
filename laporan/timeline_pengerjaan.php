<?php
	//include 'class.kunjungan.php';
	$data =  new koneksi();
?>
<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<h4 class="text-center">Laporan Timeline Pengerjaan</h4>
		</div>
		<div class="col-md-3">
			<button data-toggle="modal" href='#modal_kriteria' class="btn btn-danger btn-sm btn-orange pull-right">Kriteria</button>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12 wadah">
<?php  

if (isset($_POST['no_do']) && $_POST['no_do'] != ""){
?>

				<div class="pull-right">
					<button class="btn btn-default btn-sm" onclick="ngePrint();"><i class="fa fa-print"></i> print</button>
				</div>

				<table class="table-harian">
					<tr>
						<td><b>Nomor DO</b></td><td>: <?php echo $_POST['no_do']; ?></td>
						<td></td><td></td>
					</tr>

				</table>
				<br>
				<table class="table table-hover table-striped table-mod">
					<thead>
						<tr>
							<th class="text-center">Keterangan</th>
							<th class="text-center">Ukuran</th>
							<th class="text-center">Input DO</th>
							<th class="text-center">Acc DO</th>
							<th class="text-center">No PO</th>
							<th class="text-center">Input PO</th>
							<th class="text-center">Acc PO</th>
							<th class="text-center">Kirim</th>
							<th class="text-center">Realisasi</th>
							<th class="text-center">Distribusi</th>
							<th class="text-center">Terima</th>
							<th class="text-center">Durasi</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					$query = "SELECT `po_detail`.`id` AS `id_detail_po`, `do_detail`.`deskripsi`, `ukuran`.`panjang`, `ukuran`.`lebar`, `ukuran`.`pre`, `do_detail`.`jml`, 
							`do`.`tgl_do`, `do`.`tgl_acc` AS `tgl_acc_do` , `po`.`no_po`, `po`.`tgl_po` AS `tgl_po`, `po`.`tgl_acc` AS `tgl_acc_po`, `po`.`tgl_kirim_ke_supplier`, 
							`po_detail`.`tgl_kirim`, `po_detail`.`tgl_kirim_ke_sales` FROM `do_detail` INNER JOIN `do` ON (`do_detail`.`id_do` = `do`.`id`) INNER JOIN `po_detail` 
							ON (`po_detail`.`id_do_detail` = `do_detail`.`id`) INNER JOIN `tema_layar` ON (`do_detail`.`id_tema_layar` = `tema_layar`.`id`) 
							INNER JOIN `ukuran` ON (`do_detail`.`id_ukuran` = `ukuran`.`id`) INNER JOIN `po` ON (`po_detail`.`id_po` = `po`.`id`) WHERE 
							`do`.`no` = '".$_POST['no_do']."';";
					if ($daftar = $data->runQuery($query)){
						while( $rs = $daftar->fetch_assoc() ){
						
							$qRealisasi = "SELECT MAX(`tgl`) FROM `realisasi_po` WHERE `id_detail_po` = '".$rs['id_detail_po']."';";
							if ($resultRealisasi = $data->runQuery($qRealisasi)) {
								$rsRealisasi = $resultRealisasi->fetch_array();
								if ($rsRealisasi[0] == null) {
									$tglRealisasi = "00-00-00";
								} else {
									$tglRealisasi = date("d-m-y",strtotime($rsRealisasi[0]));
								}
							}
							
							$tgldo = ($rs['tgl_do']!="0000-00-00")?date("d-m-y",strtotime($rs['tgl_do'])):"00-00-00";
							$tglaccdo = ($rs['tgl_acc_do']!="0000-00-00")?date("d-m-y",strtotime($rs['tgl_acc_do'])):"00-00-00";
							$tglpo = ($rs['tgl_po']!="0000-00-00")?date("d-m-y",strtotime($rs['tgl_po'])):"00-00-00";
							$tglaccpo = ($rs['tgl_acc_po']!="0000-00-00")?date("d-m-y",strtotime($rs['tgl_acc_po'])):"00-00-00";
							$tglkesup = ($rs['tgl_kirim_ke_supplier']!="0000-00-00")?date("d-m-y",strtotime($rs['tgl_kirim_ke_supplier'])):"00-00-00";
							$tglkirim = ($rs['tgl_kirim']!="0000-00-00")?date("d-m-y",strtotime($rs['tgl_kirim'])):"00-00-00";
							$tglkirimsales = ($rs['tgl_kirim_ke_sales']!="0000-00-00")?date("d-m-y",strtotime($rs['tgl_kirim_sales'])):"00-00-00";
							
							if ($tglpo != "00-00-00" && $tglkirim != "00-00-00") {
								$durasi = floor((strtotime($rs['tgl_kirim'])-strtotime($rs['tgl_po']))/(60*60*24));
							} else {
								$durasi = "0";
							}
						
							echo "<tr>
								<td>".substr($rs['deskripsi'],0,20)."</td>
								<td>".$rs['jml']."x".$rs['panjang']."x".$rs['lebar']."</td>
								<td>".$tgldo."</td>
								<td class='text-center'>".$tglaccdo."</td>
								<td class='text-center'>".$rs['no_po']."</td>
								<td class='text-center'>".$tglpo."</td>
								<td class='text-center'>".$tglaccpo."</td>
								<td class='text-center'>".$tglkesup."</td>
								<td class='text-center'>".$tglRealisasi."</td>
								<td class='text-center'>".$tglkirimsales."</td>
								<td class='text-center'>".$tglkirim."</td>
								<td class='text-center'>".$durasi."</td>";
							echo "</tr>";
						}
					}
					?>


					</tbody>
				</table>
				<p class="text-muted small">*) Kirim : PO kirim ke supplier *) Realisasi : Terima barang dari supplier 
				*) Distribusi : Kirim barang ke sales / depo *) Terima : Barang diterima pelanggan</p>
				<p class="text-muted small visible-print">Dicetak oleh <?php echo $_SESSION['media-nama'] ?>, pada <?php echo date("d M Y	"); ?> </p>

<?php
}else{
?>
			<div class="text-center text-muted">
				<p style="font-size:120px;"><i class="fa fa-question-circle"></i></p>
				<p>silakan isi kriteria laporan dengan meng-klik tombol kriteria</p>
			</div>
	

<?php
}

?>
			
		
				
		</div>
	</div>
</div>
<form action="./" class="form-kunjungan" method="POST">
<div class="modal fade" id="modal_kriteria">
	<div class="modal-dialog modal-ryan">
		<div class="modal-content">
			<div class="modal-header custom orange">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Kriteria</h4>
			</div>
			<div class="modal-body">
					<input type="hidden" id="no_spa" name="no_spa" value="<?php echo e_url('laporan/timeline_pengerjaan.php'); ?>">
					<div class="form-group">
						<div class="col-sm-12">
							<input type="text" name="no_do" id="no_do" placeholder="Nomor D.O."></input>
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-danger btn-orange lihat">cari Sesuai Kriteria Diatas <i class="fa fa-chevron-circle-right"></i></button>
				
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</form>
<!-- skrip untuk table.js -->
<script></script>