<?php
	include './jabatan/class.jabatan.php';

	$data = new jabatan();

?>

<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<center>
				<h4>Master Data Jabatan</h4>
			</center>
		</div>
		<div class="col-md-3">
			<a class="btn btn-danger btn-orange btn-sm pull-right input-jabatan" href='#'><i class="fa fa-plus"></i> Tambah Jabatan</a>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-mod" id="tabel-jabatan">
				<thead>
					<tr>
						<th>#</th><th>Nama Jabatan</th><th></th>
					</tr>
				</thead>
				<tbody>
				<?php

					if( $cari = $data->daftar_jabatan() ){
						$i = 1;
						while( $rs = $cari->fetch_assoc() ){
							echo "<tr>
								<td>".$i++."</td><td>".stripslashes($rs['jabatan'])."</td><td class='text-right'><a href='#' class='btn btn-sm btn-danger btn-orange edit-jabatan' data-id='".$rs['id']."' data-jabatan='".stripslashes($rs['jabatan'])."' > edit <i class='fa fa-edit'></i></a>  <a href='#' class='btn btn-sm btn-danger hapus-jabatan' data-id='".$rs['id']."'  data-jabatan='".stripslashes($rs['jabatan'])."'  ><i class='fa fa-trash-o'></i></a></td>
							</tr>";
						}
					}

				?>
					
				</tbody>
			</table>
		</div>
	</div>

	<form action="#" method="post" id="form-hapus">
		<input type="hidden" id="apa" name="apa" value="hapus-jabatan">
		<input type="hidden" id="aksi" name="aksi" value="<?php echo e_url('jabatan/jabatan_aux.php'); ?>">
		<input type="hidden" id="id" name="id" value="">
	</form>
<!-- modal tambah jabatan -->
<div class="modal fade" id="modal-input">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header custom orange">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><i class="fa fa-plus"></i> Daftarkan Jabatan</h4>
						</div>
						<div class="modal-body">
							<form action="#" id="form-input" class="form-horizontal" method="POST">
								
								<input type="hidden" id="apa" name="apa" value="">
								<input type="hidden" id="aksi" name="aksi" value="<?php echo e_url('./jabatan/jabatan_aux.php'); ?>">
								<input type="hidden" id="id" name="id" value="">


								<div class="form-group">
									<label for="inputNama" class="col-sm-3 control-label">Nama Jabatan</label>
									<div class="col-sm-9">
										<input type="text" name="jabatan" id="jabatan" class="form-control input-min"    placeholder="nama jabatan">
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
            data: {"mod" : "<?php echo e_url('jabatan/jabatan.php'); ?>", "title" : "jabatan" },
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


	$('#tabel-jabatan').DataTable(); 

	$('.input-jabatan').click(function(ev){
		ev.preventDefault();
		$('#modal-input').find('.modal-title').html('<i class="fa fa-plus"></i> Daftarkan Jabatan');
		$('#apa').val('input-jabatan');
		$('#id').val('');
		$('#jabatan').val('');
		$('.btn-simpan').html('Simpan <i class="fa fa-send"></i>');
		$('#modal-input').modal('show');

	});



	$('.edit-jabatan').click(function(ev){
		ev.preventDefault();
		$('#modal-input').find('.modal-title').html('<i class="fa fa-edit"></i> Ubah Jabatan');
		$('#apa').val('edit-jabatan');
		$('#id').val($(this).data('id'));
		$('#jabatan').val($(this).data('jabatan'));
		$('.btn-simpan').html('Simpan <i class="fa fa-send"></i>');
		$('#modal-input').modal('show');

	});

	$('.hapus-jabatan').click(function(ev){
		ev.preventDefault();
		$('#modal-input').find('.modal-title').html('<i class="fa fa-edit"></i> Ubah Jabatan');
		$('#apa').val('hapus-jabatan');
		$('#id').val($(this).data('id'));
		$('#jabatan').val($(this).data('jabatan'));
		$('.btn-simpan').html('Hapus <i class="fa fa-trash"></i>');
		$('#modal-input').modal('show');

	});


	$('.btn-simpan').click( function(ev){
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