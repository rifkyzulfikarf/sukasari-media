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
			
				<div class="text-center text-muted">
				<p style="font-size:120px;"><i class="fa fa-question-circle"></i></p>
				<p>silakan isi kriteria laporan dengan meng-klik tombol kriteria</p>
				</div>
			
		</div>
	</div>

</div>

<!-- modal kriteria -->
<div class="modal fade" id="modal_kriteria">
	<div class="modal-dialog modal-ryan">
		<div class="modal-content">
			<div class="modal-header custom orange">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Kriteria Laporan</h4>
			</div>
			<div class="modal-body">
				<form action="#" method="POST" class="form-kunjungan">

					<input type="hidden" name="apa" value="laporan_harian">
					<input type="hidden" name="aksi" value="<?php echo e_url('kunjungan/laporan_harian_detail.php'); ?>">

					<input type="text" name="tgl" id="inputTgl" class="form-control datepicker" placeholder="Tanggal">
					<br>
					<select name="supervisor" id="inputSupervisor" class="form-control">
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
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- tutup modal kriteria -->

<script>

    $('#tabel-laporan').DataTable();
    
    function lihat(){
    	$('.wadah').append("<div class='pull-right loading'><h1><i class='fa fa-refresh fa-spin'></i></h1></div>");
        var ini = $('.form-kunjungan').serialize();

        $.ajax({
        	url : "./",
            method: "POST",
            cache: false,
            data: ini,
            success: function(event){
            
            	$('.loading').remove();
            	$('.wadah').html(event);
				/* $('.table').dataTable(); */
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

    



    

	


</script>