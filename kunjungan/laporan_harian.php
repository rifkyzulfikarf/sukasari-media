<?php
	include 'class.kunjungan.php';
	$data =  new kunjungan();

?>

<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<h4 class="text-center">Laporan Harian Kunjungan Supervisor</h4>
		</div>
		<div class="col-md-3">
			<button data-toggle="modal" href='#modal_kriteria' class="btn btn-danger btn-sm btn-orange pull-right">Kriteria</button>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-12 wadah">
			<?php
				if(isset($_POST['tgl_awal']) && isset($_POST['spv']) && isset($_SESSION['media-data']) && $_POST['spv']!="" && $_POST['tgl_awal']!="" ){
					$spv = $data->detail_spv($_POST['spv']);	
			?>
				<div class="pull-right">
					<button class="btn btn-default btn-sm" onclick="ngePrint();"><i class="fa fa-print"></i> print</button>
				</div>
				
				<form action="#" method="post" id="detail_map">
					<input type="hidden" name="no_spa" id="no_spa" value="">
					<input type="hidden" name="data" id="data" value="">
					<input type="hidden" name="fawal" id="fawal" value="">
					<input type="hidden" name="fspv" id="fspv" value="">
					<input type="hidden" name="ftipe" id="ftipe" value="">
				</form>


				<table class="table-harian">
					<tr>
						<td><b>Tanggal</b></td><td>: <?php echo date("d M Y", strtotime($_POST['tgl_awal']) ); ?></td>
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
							<th>No.Register</th><th>Pelanggan</th><th>Alamat</th><th>Pasar</th><th>Sub Pasar</th><th>Waktu</th><th class="text-center">Tindakan</th><th>Geolokasi</th>
						</tr>
					</thead>
					<tbody>
					<?php 

					if( $daftar = $data->kunjungan_harian($_POST['tgl_awal'] , $_POST['spv']) ){
						while( $rs = $daftar->fetch_assoc() ){
							echo "<tr>
								<td>".$rs['noreg']."</td>
								<td>".$rs['nama']."</td>
								<td>".$rs['alamat']."</td>
								<td>".$rs['pasar']."</td>
								<td>".$rs['sub_pasar']."</td>
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
								<td>Lat:".$rs['latitude']." , long:".$rs['longitude']."<a class='detail_kunjungan' title='Lihat' data-hash='detail-kunjungan' data-link='".e_url('kunjungan/detail_map.php')."' data-data='".$rs['id']."' data-tgl='".$_POST['tgl_awal']."' data-spv='".$_POST['spv']."' data-tipe='harian' href='#'><i class='fa fa-search pull-right text-danger'></i></a></td>
							</tr>";
						}
					}

					?>


					</tbody>
				</table>
				<p class="text-muted small visible-print">Dicetak oleh <?php echo $_SESSION['media-nama'] ?>, pada <?php echo date("d M Y	"); ?> </p>
			<?php
				} else {
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

<!-- modal kriteria -->
<form action="./"  method="POST" class="form-kunjungan">
<div class="modal fade" id="modal_kriteria">
	<div class="modal-dialog modal-ryan">
		<div class="modal-content">
			<div class="modal-header custom orange">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Kriteria Laporan</h4>
			</div>
			<div class="modal-body">
					<input type="hidden" id="no_spa" name="no_spa" value="<?php echo e_url('kunjungan/laporan_harian.php'); ?>">

					<input type="text" name="tgl_awal" id="inputTgl" class="form-control datepicker" placeholder="Tanggal" value="<?php if (isset($_POST['tgl_awal'])) { echo $_POST['tgl_awal']; } ?>">
					<br>
					<select name="spv" id="inputSupervisor" class="form-control">
						<option value="">-- Pilih Supervisor --</option>
						<?php
							if( $list = $data->select_spv() ){
								while($rs = $list->fetch_assoc()){
									echo "<option value='".$rs['id']."'>".stripslashes($rs['nama'])."</option>";
								}
							}
						?>
						

					</select>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-danger btn-orange lihat">cari sesuai kriteria diatas <i class="fa fa-chevron-circle-right"></i></button>
				
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</form>
<!-- tutup modal kriteria -->

<script>

    $('#tabel-laporan').DataTable();
    
	$('.detail_kunjungan').on('click', function(event){

		event.preventDefault();
		$('#detail_map').find('#no_spa').val( $(this).data('link') );
		$('#detail_map').find('#data').val( $(this).data('data') );
		$('#detail_map').find('#fawal').val( $(this).data('tgl') );
		$('#detail_map').find('#fspv').val( $(this).data('spv') );
		$('#detail_map').find('#ftipe').val( $(this).data('tipe') );

		$('#detail_map').submit();


	});
	
    // function lihat(){
    	// $('.wadah').append("<div class='pull-right loading'><h1><i class='fa fa-refresh fa-spin'></i></h1></div>");
        // var ini = $('.form-kunjungan').serialize();

        // $.ajax({
        	// url : "./",
            // method: "POST",
            // cache: false,
            // data: ini,
            // success: function(event){
            
            	// $('.loading').remove();
            	// $('.wadah').html(event);
				// /* $('.table').dataTable(); */
                // $('.datepicker').datepicker({dateFormat: "yy-mm-dd"});
                // $('.modal').modal('hide');


			// },
            // error: function(){
            	// $('.loading').remove();
                // alert('Gagal terkoneksi dengan server, coba lagi..!');
                                
			// }
                
        // });
    // }


    // $('.form-kunjungan').submit(function(ev){
    	// ev.preventDefault();
    	// lihat();
	// });

    // $('.lihat').on('click', function(ev){
    	// ev.preventDefault();
    	// lihat();
    // });

</script>