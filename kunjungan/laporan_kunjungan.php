<?php
	include 'class.kunjungan.php';
	$data =  new kunjungan();
?>
<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<h4 class="text-center">Laporan Kunjungan</h4>
		</div>
		<div class="col-md-3">
			<button data-toggle="modal" href='#modal_kriteria' class="btn btn-danger btn-sm btn-orange pull-right">Kriteria</button>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12 wadah">
<?php  

if( isset($_REQUEST['tgl_awal']) && isset($_REQUEST['tgl_akhir']) && isset($_REQUEST['spv']) && isset($_REQUEST['cust']) && isset($_REQUEST['job']) &&  $_REQUEST['spv']<>"" && $_REQUEST['tgl_awal']<>"" && $_REQUEST['tgl_akhir']<>"" && $_REQUEST['cust']<>"" && $_REQUEST['job']<>""  ){


	$spv = $data->detail_spv($_REQUEST['spv']);
	$cust = $data->detail_cust($_REQUEST['cust']);
	$job = $data->nama_job($_REQUEST['job']);


?>

				<div class="pull-right">
					<button class="btn btn-default btn-sm" onclick="ngePrint();"><i class="fa fa-print"></i> print</button>
				</div>
				
				<form action="#" method="post" id="detail_map">
					<input type="hidden" name="no_spa" id="no_spa" value="">
					<input type="hidden" name="data" id="data" value="">
					<input type="hidden" name="fawal" id="fawal" value="">
					<input type="hidden" name="fakhir" id="fakhir" value="">
					<input type="hidden" name="fspv" id="fspv" value="">
					<input type="hidden" name="fcust" id="fcust" value="">
					<input type="hidden" name="fjob" id="fjob" value="">
					<input type="hidden" name="ftipe" id="ftipe" value="">
				</form>


				<table class="table-harian">
					<tr>
						<td><b>Customer</b></td><td>: <?php echo ($cust ? $cust['nama'] : "-") ?></td>
					</tr>
					<tr>
						<td><b>Nama SPV</b></td><td>: <?php echo ($spv ? $spv['nama'] : "-"); ?></td>
						<td><b>Kegiatan</b></td><td>: <?php echo ($job ? $job['nama'] : "-") ?></td>
					</tr>
					<tr>
						<td><b>Area</b></td><td>: <?php echo ($spv ? $spv['nama_area'] : "-"); ?></td>
						<td></td><td></td>
					</tr>

				</table>
				<br>
				<table class="table table-hover table-striped table-mod">
					<thead>
						<tr>
							<th>No.Register</th><th>Tanggal</th><th>Pelanggan</th><th>Alamat</th><th>Pasar</th><th>Sub Pasar</th><th>Waktu</th><th class="text-center">Tindakan</th><th>Geolokasi</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					if( $daftar = $data->kunjungan_list($_REQUEST['spv'] , $_REQUEST['tgl_awal'], $_REQUEST['tgl_akhir'], $_REQUEST['cust'], $_REQUEST['job']) ){
						while( $rs = $daftar->fetch_assoc() ){
							echo "<tr>
								<td>".$rs['noreg']."</td>
								<td>".date("d-m-Y", strtotime($rs['tanggal']))."</td>
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
								<td>Lat:".$rs['latitude']." , long:".$rs['longitude']."<a class='detail_kunjungan' title='Lihat' data-hash='detail-kunjungan' data-link='".e_url('kunjungan/detail_map.php')."' data-data='".$rs['id']."' data-awal='".$_REQUEST['tgl_awal']."' data-akhir='".$_REQUEST['tgl_akhir']."' data-spv='".$_REQUEST['spv']."' data-cust='".$_REQUEST['cust']."' data-job='".$_REQUEST['job']."' data-tipe='rekap' href='#'><i class='fa fa-search pull-right text-danger'></i></a></td>
							</tr>";
						}
					}

					?>


					</tbody>
				</table>
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
				

					
					<input type="hidden" id="no_spa" name="no_spa" value="<?php echo e_url('kunjungan/laporan_kunjungan.php'); ?>">

					<div class="form-group">
						<div class="col-sm-6">
							<input type="text" id="tgl_awal" name="tgl_awal" id="inputTgl_awal" class="form-control datepicker" placeholder="tgl awal" value="<?php if (isset($_POST['tgl_awal'])) { echo $_POST['tgl_awal']; } ?>">
						</div>
						<div class="col-sm-6">
							<input type="text" id="tgl_akhir" name="tgl_akhir" id="inputTgl_akhir" class="form-control datepicker" placeholder="tgl akhir" value="<?php if (isset($_POST['tgl_akhir'])) { echo $_POST['tgl_akhir']; } ?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<select name="spv" id="spv" class="form-control">
								<option value="%">Pilih Supervisor</option>
								<?php
									if( $list = $data->select_spv() ){
										while($rs = $list->fetch_assoc()){
											echo "<option value='".$rs['id']."'>".stripslashes($rs['nama'])."</option>";
										}
									}
								?>
								
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<select name="cust" id="inputCust" class="form-control"></select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<select name="job" id="inputJob" class="form-control">
								<option value="%">pilih kegiatan/job</option>
								<?php
									if( $list = $data->select_job() ){
										while($rs = $list->fetch_assoc()){
											echo "<option value='".$rs['id']."'>".stripslashes($rs['nama'])."</option>";
										}
									}
								?>
							</select>
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
<script>

    $('#tabel-laporan').DataTable();

    $('.detail_kunjungan').on('click', function(event){

		event.preventDefault();
		$('#detail_map').find('#no_spa').val( $(this).data('link') );
		$('#detail_map').find('#data').val( $(this).data('data') );
		$('#detail_map').find('#fawal').val( $(this).data('awal') );
		$('#detail_map').find('#fakhir').val( $(this).data('akhir') );
		$('#detail_map').find('#fspv').val( $(this).data('spv') );
		$('#detail_map').find('#fcust').val( $(this).data('cust') );
		$('#detail_map').find('#fjob').val( $(this).data('job') );
		$('#detail_map').find('#ftipe').val( $(this).data('tipe') );

		$('#detail_map').submit();


	});
	
	$('#spv').change(function(ev){
		ev.preventDefault();
		$.ajax({
			url : "./",
			method: "POST",
			cache: false,
			data: {"aksi" : "<?php echo e_url('kunjungan/cari_customer.php'); ?>", "title" : "Kunjungan", "spv" : $("#spv").val()},
			success: function(event){
				$('#inputCust').html(event);
			},
			error: function(){
				alert('Gagal terkoneksi dengan server, coba lagi..!');
			}
		});	
	});
 
/*   
    function lihat(){
    	$('.wadah').append("<div class='pull-right loading'><h1><i class='fa fa-refresh fa-spin'></i></h1></div>");
        var ini = $('.form-kunjungan').serialize();

        alert($('#aksi').val());

        $.ajax({
        	url : "./",
            method: "POST",
            cache: false,
            data: ini,
            success: function(event){
            
            	$('.loading').remove();
            	$('.wadah').html(event);
				
                $('.datepicker').datepicker({dateFormat: "yy-mm-dd"});
                $('.modal').modal('hide');


			},
            error: function(){
            	$('.loading').remove();
                alert('Gagal terkoneksi dengan server, coba lagi..!');
                                
			}
                
        });
    }


    $('.form-kunjungan').submit(function(ev){
    	ev.preventDefault();
    	lihat();
	});

    $('.lihat').on('click', function(ev){
    	ev.preventDefault();
    	lihat();
    });


*/
    

	


</script>