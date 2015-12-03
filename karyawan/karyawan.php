<?php

include './karyawan/class.karyawan.php';
$data = new karyawan();

?>

<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
		<center>
				<h4>Master Data Karyawan </h4>
			</center>
		</div>
		<div class="col-md-3">
			<a class="btn btn-danger btn-orange btn-sm pull-right baru" ><i class="fa fa-plus"></i> Daftarkan Karyawan</a>
			<div class="modal fade" id="modal_karyawan" data-backdrop="static">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header custom orange">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><i class="fa fa-plus"></i> Daftarkan Karyawan</h4>
						</div>
						<div class="modal-body">
							<form action="#" id="form-input" class="form-horizontal" method="POST">
								<input type="hidden" name="apa" id="apa" value="">
								<input type="hidden" name="aksi" id="aksi" value="<?php echo e_url('karyawan/karyawan_aux.php'); ?>">
								<input type="hidden" name="id" id="id" value="">
								<input type="text" name="nama" id="nama" class="form-control" placeholder="nama karyawan">
								<br>
								<select name="jabatan" id="jabatan" class="form-control" required="required">
									<option value="">-- pilih jabatan --</option>
									<?php
										if( $daftar = $data->select_level() ){
											while($rs = $daftar->fetch_assoc() ){
												echo "<option value='".$rs['id']."'> ".$rs['jabatan']." </option>";
											}
										}
									?>
								</select>
								<br>
								<select name="area" id="area" class="form-control" required="required">
									<option value="">-- area  --</option>
									<?php
										if( $daftar = $data->select_area() ){
											while( $rs = $daftar->fetch_assoc() ){
												echo "<option value='".$rs['id']."' >".$rs['area']."</option>";
											}
										}
									?>
								</select>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-danger btn-simpan">Simpan <i class="fa fa-send"></i></button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped table-mod" id="tabel-karyawan">
				<thead>
					<tr>
						<th>#</th><th>NAMA</th><th>JABATAN</th><th>AREA</th><th></th>
					</tr>
				</thead>
				<tbody>

				<?php
					$i = 1;
					if( $daftar = $data->daftar_karyawan() ){
						while( $rs = $daftar->fetch_assoc() ){

							echo "<tr>
							<td>".$i++."</td>
							<td>".$rs['nama']."</td>
							<td>".$rs['nama_jabatan']."</td>
							<td>".$rs['nama_area']."</td>
							<td> <a href='#' class='btn btn-sm btn-danger btn-orange edit-karyawan' data-id='".$rs['id']."' data-nama='".$rs['nama']."' data-area='".$rs['area']."' data-jabatan='".$rs['level']."'  >edit</a>  
							<a href='#' class='btn btn-sm btn-orange upload-ttd' data-id='".$rs['id']."' ><i class='fa fa-upload'></i></a> 
							<a href='#' class='btn btn-sm btn-danger hapus-karyawan' data-id='".$rs['id']."' ><i class='fa fa-trash-o'></i></a> 
							</td>

							</tr>";

						}
					}

				?>

				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-ttd">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header custom orange">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-upload"></i> Upload Digital Signature</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="id-ttd" id="id-ttd" value="">
				<div id="dropzone" class="dropzone"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal" id="close-ttd">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
$(document).ready( function () {
	
	var myDropzone = $("#dropzone").dropzone({ 
		url: "inc/upload.php",
		maxFilesize: 1,
		acceptedFiles: "image/*",
		init: function () {
			this.on("sending", function(file, xhr, data) {
				data.append("id", $('#id-ttd').val());
			});
		}
	});

	function reloading(){
		$('#isi_halaman').append("<div class='pull-right loading'><h1><i class='fa fa-refresh fa-spin'></i></h1></div>");
		
		$.ajax({
        	url : "./",
            method: "POST",
            cache: false,
            data: {"mod" : "<?php echo e_url('karyawan/karyawan.php'); ?>", "title" : "karyawan" },
            success: function(event){
            
            	
            	$('.loading').remove();	
            	$('#isi_halaman').html(event);
            	
			},
            error: function(){
            	$('.loading').remove();
                alert('Gagal terkoneksi dengan server, coba lagi..!');
                                
			}
                
        });

	}

    $('#tabel-karyawan').DataTable();

    $(document).on('click', '.baru', function(event) {
    	event.preventDefault();
    	$('#apa').val('input-karyawan');
    	$('#nama').val('');
    	$('#area').val('');
    	$('#jabatan').val('');
    	$('#modal_karyawan').modal('show');
    });

    $(document).on('click', '.edit-karyawan', function(event){
    	event.preventDefault();
    	$('#apa').val('edit-karyawan');
    	$('#id').val( $(this).data('id') );
    	$('#nama').val( $(this).data('nama') );
    	$('#area').val( $(this).data('area') );
    	$('#jabatan').val( $(this).data('jabatan') );
    	$('#modal_karyawan').modal('show');

    });
	
	$(document).on('click', '.upload-ttd', function(event){
    	event.preventDefault();
    	$('#id-ttd').val( $(this).data('id') );
    	$('#modal-ttd').modal('show');
		$('.dz-preview').remove();
    });


    $('.btn-simpan').on('click', function(ev){
    	ev.preventDefault();
        var ini = $('#form-input').serialize();

        $('.btn-simpan').addClass('disabled').html('Processing... <i class="fa fa-spinner fa-pulse"></i>');
        
		$.ajax({
            url: "./",
            method: "POST",
            cache: false,
            dataType: "JSON",
            data: ini,
            success: function(eve){

            	if( eve.status ){
            		$('.btn-close-modal').click();
            		alert(eve.msg);
            		reloading();
            	}else{
            		$('.btn-simpan').html('Simpan <i class="fa fa-send"></i>').removeClass('disabled');
            		alert(eve.msg);
            	}
  

            },
            error: function(){
            	alert('Gagal terkoneksi dengan server..');
          		$('.btn-simpan').html('Simpan <i class="fa fa-send"></i>').removeClass('disabled');
            }

         });

    });

    $(document).on('click','.hapus-karyawan', function(event){
    	event.preventDefault();
    	
    	if( confirm('Apakah benar akan dihapus ?') ){
    		$.ajax({
	            url: "./",
	            method: "POST",
	            cache: false,
	            dataType: "JSON",
	            data: {"aksi" : "<?php echo e_url('karyawan/karyawan_aux.php'); ?>", "apa" : "hapus-karyawan", "data" : $(this).data('id') },
	            success: function(eve){

	            	if( eve.status ){
	            		
	            		alert('Berhasil dihapus..');
	            		reloading();
	            	}else{
	            		
	            		alert('Gagl menghapus');
	            		$(this).removeAttr('disabled', 'disabled');
	            	}
	  

	            },
	            error: function(){
	            	alert('Gagal terkoneksi dengan server..');
	          		$(this).removeAttr('disabled', 'disabled');
	            }

	        });
	        $(this).addAttr('disabled', 'disabled');	

    	}
    	

    });


    $('#form-input').on('submit', function(event){
    	event.preventDefault();
    	$('.btn-simpan').click();
    });


    



} );
</script>
