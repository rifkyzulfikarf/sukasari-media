<?php
	include './rayon/class.rayon.php';
	include './area/class.area.php';
	$data = new rayon();
	$area = new area();

?>

<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<center>
				<h4>Master Data Rayon</h4>
			</center>
		</div>
		<div class="col-md-3">
			<a class="btn btn-danger btn-orange btn-sm pull-right input-rayon" href='#'><i class="fa fa-plus"></i> Tambah Rayon</a>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-mod" id="tabel-rayon">
				<thead>
					<tr>
						<th>#</th><th>Nama Rayon</th><th>Area</th><th></th>
					</tr>
				</thead>
				<tbody>
				<?php

					if( $cari = $data->daftar_rayon() ){
						$i = 1;
						while( $rs = $cari->fetch_assoc() ){
							echo "<tr>
								<td>".$i++."</td><td>".stripslashes($rs['rayon'])."</td><td>".stripslashes($rs['area'])."</td><td class='text-right'><a href='#' class='btn btn-sm btn-danger btn-orange edit-rayon' data-id='".$rs['id']."' data-rayon='".stripslashes($rs['rayon'])."' data-id_area='".$rs['id_area']."' > edit <i class='fa fa-edit'></i></a>  <a href='#' class='btn btn-sm btn-danger hapus-rayon' data-id='".$rs['id']."' data-rayon='".stripslashes($rs['rayon'])."' data-id_area='".$rs['id_area']."' ><i class='fa fa-trash-o'></i></a></td>
							</tr>";
						}
					}

				?>
					
				</tbody>
			</table>
		</div>
	</div>

<!-- modal tambah rayon -->
<div class="modal fade" id="modal-input">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header custom orange">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><i class="fa fa-plus"></i> Daftarkan Rayon</h4>
						</div>
						<div class="modal-body">
							<form action="#" id="form-input" class="form-horizontal" method="POST">
								
								<input type="hidden" id="apa" name="apa" value="">
								<input type="hidden" id="aksi" name="aksi" value="<?php echo e_url('./rayon/rayon_aux.php'); ?>">
								<input type="hidden" id="id" name="id" value="">


								<div class="form-group">
									<label for="inputNama" class="col-sm-3 control-label">Nama Rayon</label>
									<div class="col-sm-9">
										<input type="text" name="rayon" id="rayon" class="form-control input-min"    placeholder="nama rayon">
									</div>
								</div>

								<div class="form-group">
									<label for="inputNama" class="col-sm-3 control-label">Area </label>
									<div class="col-sm-9">
										<select name="id_area" id="id_area" class="form-control" required="required" placeholder="Pilih karyawan">
										<?php
											if( $list = $area->daftar_area() ){
												while($rs = $list->fetch_assoc() ){
													echo "<option value='".$rs['id']."'>".stripslashes($rs['area'])."</option>";
												}
											}

										?>
											
											
										</select>
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
            data: {"mod" : "<?php echo e_url('rayon/rayon.php'); ?>", "title" : "rayon" },
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


	$('#tabel-rayon').DataTable();

	$('.input-rayon').on('click', function(ev){
		ev.preventDefault();
		$('#modal-input').find('.modal-title').html('<i class="fa fa-plus"></i> Daftarkan Rayon');
		$('#apa').val('input-rayon');
		$('#id').val('');
		$('#rayon').val('');
		$('#id_area').val('');
		$('.btn-simpan').html('Simpan <i class="fa fa-send"></i>');
		$('#modal-input').modal('show');

	});

	$(document).on('click', '.edit-rayon',function(ev){
		ev.preventDefault();
		$('#modal-input').find('.modal-title').html('<i class="fa fa-edit"></i> Ubah Rayon');
		$('#apa').val('edit-rayon');
		$('#id').val($(this).data('id'));
		$('#rayon').val($(this).data('rayon'));
		$('#id_area').val($(this).data('id_area'));
		$('.btn-simpan').html('Simpan <i class="fa fa-send"></i>');
		$('#modal-input').modal('show');

	});

	$(document).on('click', '.hapus-rayon',function(ev){
		ev.preventDefault();
		$('#modal-input').find('.modal-title').html('<i class="fa fa-trash"></i> Hapus Rayon');
		$('#apa').val('hapus-rayon');
		$('#id').val($(this).data('id'));
		$('#rayon').val($(this).data('rayon'));
		$('#id_area').val($(this).data('id_area'));
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