<?php
	include './pin/class.pin.php';

	$data = new pin();

?>

<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<center>
				<h4>Master Data Pin User</h4>
			</center>
		</div>
		<div class="col-md-3">
			<a class="btn btn-danger btn-orange btn-sm pull-right input-pin" href='#'><i class="fa fa-plus"></i> Tambah Pin User</a>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-mod" id="tabel-pin">
				<thead>
					<tr>
						<th>#</th><th>Nama Karyawan</th><th>Area</th><th>Pin User</th><th></th>
					</tr>
				</thead>
				<tbody>
				<?php

					if( $cari = $data->daftar_pin() ){
						$i = 1;
						while( $rs = $cari->fetch_assoc() ){
							echo "<tr>
								<td>".$i++."</td><td>".stripslashes($rs['nama'])."</td><td>".stripslashes($rs['nm_area'])."</td><td>".stripslashes($rs['pin'])."</td><td class='text-right'><a href='#' class='btn btn-sm btn-danger btn-orange edit-pin' data-id_karyawan='".$rs['id_karyawan']."' data-pin='".stripslashes($rs['pin'])."' data-nama='".stripslashes($rs['nama'])."' > edit <i class='fa fa-edit'></i></a>  <a href='#' class='btn btn-sm btn-danger hapus-pin' data-id_karyawan='".$rs['id_karyawan']."' data-pin='".stripslashes($rs['pin'])."' data-nama='".stripslashes($rs['nama'])."'  ><i class='fa fa-trash-o'></i></a></td>
							</tr>";
						}
					}

				?>
					
				</tbody>
			</table>
		</div>
	</div>

<!-- modal tambah pin -->
<div class="modal fade" id="modal-input">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header custom orange">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><i class="fa fa-plus"></i> Daftarkan Pin </h4>
						</div>
						<div class="modal-body">
							<form action="#" id="form-input" class="form-horizontal" method="POST">
								
								<input type="hidden" id="apa" name="apa" value="">
								<input type="hidden" id="aksi" name="aksi" value="<?php echo e_url('./pin/pin_aux.php'); ?>">
								
								
								<div class="form-group">
									<label for="inputNama" class="col-sm-3 control-label">Supervisor </label>
									<div class="col-sm-9">
										<select name="id_karyawan" id="id_karyawan" class="form-control" required="required" placeholder="Pilih karyawan">
										<?php
											if( $list = $data->daftar_spv() ){
												while($rs = $list->fetch_assoc() ){
													echo "<option value='".$rs['id']."'>".stripslashes($rs['nama']." - ".$rs['nm_area'])."</option>";
												}
											}

										?>
											
											
										</select>
									</div>
								</div>
								<br>
								<div class="form-group">
									<label for="inputNama" class="col-sm-3 control-label">Pin </label>
									<div class="col-sm-9">
										<input type="text" name="pin" id="pin" class="form-control input-min"    placeholder="pin">
									</div>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-danger btn-simpan">Simpan <i class="fa fa-send"></i></button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

<script>
$(document).ready(function(){


	function reloading(){
		$('#isi_halaman').append("<div class='pull-right loading'><h1><i class='fa fa-refresh fa-spin'></i></h1></div>");


		$.ajax({
        	url : "./",
            method: "POST",
            cache: false,
            data: {"mod" : "<?php echo e_url('pin/pin.php'); ?>", "title" : "pin" },
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


	$('#tabel-pin').DataTable();

	$('.input-pin').on('click', function(ev){
		ev.preventDefault();
		$('#modal-input').find('.modal-title').html('<i class="fa fa-plus"></i> Daftarkan Pin ');
		$('#apa').val('input-pin');
		$('#id_karyawan').val('');
		$('#pin').val('');
		$('.btn-simpan').html('Simpan <i class="fa fa-send"></i>');
		$('#modal-input').modal('show');

	});

	$(document).on('click', '.edit-pin',function(ev){
		ev.preventDefault();
		$('#modal-input').find('.modal-title').html('<i class="fa fa-edit"></i> Ubah Pin ');
		$('#apa').val('edit-pin');
		$('#id_karyawan').val($(this).data('id_karyawan'));
		$('#pin').val($(this).data('pin'));
		$('.btn-simpan').html('Simpan <i class="fa fa-send"></i>');
		$('#modal-input').modal('show');

	});

	$(document).on('click', '.hapus-pin',function(ev){
		ev.preventDefault();
		$('#modal-input').find('.modal-title').html('<i class="fa fa-trash"></i> Hapus Pin ');
		$('#apa').val('hapus-pin');
		$('#id_karyawan').val($(this).data('id_karyawan'));
		$('#pin').val($(this).data('pin'));
		$('.btn-simpan').html('Hapus <i class="fa fa-trash"></i>');
		$('#modal-input').modal('show');

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


	$('#form-input').submit(function(event){
		event.preventDefault();
		$('.btn-simpan').click();
	});





});

</script>