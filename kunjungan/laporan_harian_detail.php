<?php  

if( isset($_POST['apa']) && isset($_POST['tgl']) && isset($_POST['supervisor']) && isset($_SESSION['media-data']) && $_POST['supervisor']<>"" && $_POST['tgl']<>"" ){

	include 'class.kunjungan.php';
	$data = new kunjungan();

	$spv = $data->detail_spv($_POST['supervisor']);


?>

				<div class="pull-right">
					<button class="btn btn-default btn-sm" onclick="ngePrint();"><i class="fa fa-print"></i> print</button>
				</div>
				
				<form action="#" method="post" id="detail_map">
					<input type="hidden" name="no_spa" id="no_spa" value="">
					<input type="hidden" name="data" id="data" value="">


				</form>


				<table class="table-harian">
					<tr>
						<td><b>Tanggal</b></td><td>: <?php echo date("d M Y", strtotime($_POST['tgl']) ); ?></td>
					</tr>
					<tr>
						<td><b>Nama SPV</b></td><td>: <?php echo ($spv ? $spv['nama'] : "No name"); ?></td>
					</tr>
					<tr>
						<td><b>Area</b></td><td>: <?php echo ($spv ? $spv['nama_area'] : "No name"); ?></td>
					</tr>
				</table>
				<br>
				<table class="table table-hover table-striped table-mod">
					<thead>
						<tr>
							<th>No.Register</th><th>Pelanggan</th><th>Alamat</th><th>Pasar</th><th>Kota</th><th>Waktu</th><th class="text-center">Tindakan</th><th>Geolokasi</th>
						</tr>
					</thead>
					<tbody>
					<?php 

					if( $daftar = $data->kunjungan_harian($_POST['tgl'] , $_POST['supervisor']) ){
						while( $rs = $daftar->fetch_assoc() ){
							echo "<tr>
								<td>".$rs['noreg']."</td>
								<td>".$rs['nama']."</td>
								<td>".$rs['alamat']."</td>
								<td>".$rs['sub_pasar']."</td>
								<td class='text-center'>".$rs['kota']."</td>
								<td class='text-center'>".$rs['jam']."</td>
								<td>";
								$details = "";
								if( $job = $data->detail_job($rs['id']) ){
									while( $drs = $job->fetch_assoc() ){
										$details.=$drs['nama'].", ";
									}
								}
								echo substr($details,0,-1);

							echo "</td>
								<td>Lat:".$rs['latitude']." , long:".$rs['longitude']."<a class='detail_kunjungan' title='Lihat' data-hash='detail-kunjungan' data-link='".e_url('kunjungan/detail_map.php')."' data-data='".$rs['id']."' href='#'><i class='fa fa-search pull-right text-danger'></i></a></td>
							</tr>";
						}
					}

					?>


					</tbody>
				</table>
				<p class="text-muted small visible-print">Dicetak oleh <?php echo $_SESSION['media-nama'] ?>, pada <?php echo date("d M Y	"); ?> </p>

<script>

	$('.detail_kunjungan').on('click', function(event){

		event.preventDefault();
		$('#detail_map').find('#no_spa').val( $(this).data('link') );
		$('#detail_map').find('#data').val( $(this).data('data') );

		$('#detail_map').submit();


	});

</script>

<?php
}

?>