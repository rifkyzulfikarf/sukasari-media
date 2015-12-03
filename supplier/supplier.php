<?php
	include './supplier/class.supplier.php';

	$data = new supplier();

?>

<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<center>
				<h4>Master Data Supplier</h4>
			</center>
		</div>
		<div class="col-md-3">
			<a class="btn btn-danger btn-orange btn-sm pull-right input-supplier" href='#'><i class="fa fa-plus"></i> Daftarkan Supplier</a>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-mod" id="tabel-supplier">
				<thead>
					<tr>
						<th>#</th><th>Nama Supplier</th><th>Alamat</th><th>Telp</th><th>Fax</th><th>Email</th><th>CP</th><th></th>
					</tr>
				</thead>
				<tbody>
				<?php

					if( $cari = $data->daftar_supplier() ){
						$i = 1;
						while( $rs = $cari->fetch_assoc() ){
							echo "<tr>
								<td>".$i++."</td><td>".stripslashes($rs['nama'])."</td><td>".stripslashes($rs['alamat'])."</td><td>".stripslashes($rs['telp'])."</td><td>".stripslashes($rs['fax'])."</td><td>".stripslashes($rs['email'])."</td><td>".stripslashes($rs['cp'])."</td><td><a href='#' class='btn btn-sm btn-danger btn-orange edit-supplier' data-id='".$rs['id']."' data-nama='".stripslashes($rs['nama'])."' data-alamat='".stripslashes($rs['alamat'])."' data-telp='".stripslashes($rs['telp'])."' data-fax='".stripslashes($rs['fax'])."' data-email='".stripslashes($rs['email'])."' data-cp='".stripslashes($rs['cp'])."'  ><i class='fa fa-edit'></i></a>  <a href='#' class='btn btn-sm btn-danger hapus-supplier' data-id='".$rs['id']."'  data-nama='".stripslashes($rs['nama'])."' data-alamat='".stripslashes($rs['alamat'])."' data-telp='".stripslashes($rs['telp'])."' data-fax='".stripslashes($rs['fax'])."' data-email='".stripslashes($rs['email'])."' data-cp='".stripslashes($rs['cp'])."' ><i class='fa fa-trash-o'></i></a></td>
							</tr>";
						}
					}

				?>
					
				</tbody>
			</table>
		</div>
	</div>

<!-- modal tambah supplier -->
<div class="modal fade" id="modal-input">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header custom orange">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><i class="fa fa-plus"></i> Daftarkan Supplier</h4>
						</div>
						<div class="modal-body">
							<form action="#" id="form-input" class="form-horizontal" method="POST">
								
								<input type="hidden" id="apa" name="apa" value="">
								<input type="hidden" id="aksi" name="aksi" value="<?php echo e_url('./supplier/supplier_aux.php'); ?>">
								<input type="hidden" id="id" name="id" value="">


								<div class="form-group">
									<label for="inputNama" class="col-sm-3 control-label">Nama Supplier</label>
									<div class="col-sm-9">
										<input type="text" name="nama" id="nama" class="form-control input-min"    placeholder="nama supplier">
									</div>
								</div>
								<div class="form-group">
									<label for="inputAlamat" class="col-sm-3 control-label">Alamat</label>
									<div class="col-sm-9">
										<textarea name="alamat" id="alamat" cols="30" rows="2" class="form-control input-min" placeholder="alamat supplier"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="inputTelp" class="col-sm-3 control-label">Telp:</label>
									<div class="col-sm-9">
										<input type="text" name="telp" id="telp" class="form-control input-min" placeholder="Telp">
									</div>
								</div>
								<div class="form-group">
									<label for="inputTelp" class="col-sm-3 control-label">Fax</label>
									<div class="col-sm-9">
										<input type="text" name="fax" id="fax" class="form-control input-min" placeholder="fax">
									</div>
								</div>
								<div class="form-group">
									<label for="inputTelp" class="col-sm-3 control-label">Email</label>
									<div class="col-sm-9">
										<input type="text" name="email" id="email" class="form-control input-min" placeholder="email">
									</div>
								</div>
								<div class="form-group">
									<label for="inputTelp" class="col-sm-3 control-label">Contact Person</label>
									<div class="col-sm-9">
										<input type="text" name="cp" id="cp" class="form-control input-min" placeholder="contact person">
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
            data: {"mod" : "<?php echo e_url('supplier/supplier.php'); ?>", "title" : "supplier" },
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


	$('#tabel-supplier').DataTable();

	$('.input-supplier').on('click', function(ev){
		ev.preventDefault();
		$('#modal-input').find('.modal-title').html('<i class="fa fa-plus"></i> Daftarkan Supplier');
		$('#apa').val('input-supplier');
		$('#id').val('');
		$('#nama').val('');
		$('#alamat').val('');
		$('#telp').val('');
		$('#fax').val('');
		$('#email').val('');
		$('#cp').val('');
		$('.btn-simpan').html('Simpan <i class="fa fa-send"></i>');
		$('#modal-input').modal('show');

	});

	$(document).on('click', '.edit-supplier',function(ev){
		ev.preventDefault();
		$('#modal-input').find('.modal-title').html('<i class="fa fa-edit"></i> Ubah Supplier');
		$('#apa').val('edit-supplier');
		$('#id').val($(this).data('id'));
		$('#nama').val($(this).data('nama'));
		$('#alamat').val($(this).data('alamat'));
		$('#telp').val($(this).data('telp'));
		$('#fax').val($(this).data('fax'));
		$('#email').val($(this).data('email'));
		$('#cp').val($(this).data('cp'));
		$('.btn-simpan').html('Simpan <i class="fa fa-send"></i>');
		$('#modal-input').modal('show');

	});

	$(document).on('click', '.hapus-supplier',function(ev){
		ev.preventDefault();
		$('#modal-input').find('.modal-title').html('<i class="fa fa-trash"></i> Hapus Supplier');
		$('#apa').val('hapus-supplier');
		$('#id').val($(this).data('id'));
		$('#nama').val($(this).data('nama'));
		$('#alamat').val($(this).data('alamat'));
		$('#telp').val($(this).data('telp'));
		$('#fax').val($(this).data('fax'));
		$('#email').val($(this).data('email'));
		$('#cp').val($(this).data('cp'));
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