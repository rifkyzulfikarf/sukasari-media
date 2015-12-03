<?php
	include './pelanggan/class.pelanggan.php';
	include './area/class.area.php';
	include './rayon/class.rayon.php';
	$data = new pelanggan();
	$area = new area();
	$rayon = new rayon();

?>

<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<center>
				<h4>Master Data Pelanggan</h4>
			</center>
		</div>
		<div class="col-md-3">
			<a class="btn btn-danger btn-orange btn-sm pull-right input-pelanggan" href='#'>Daftarkan Pelanggan</a>
		</div>
	</div>
	<hr>
		<select name="cari-area" id="cari-area" class="form-control" required="required" placeholder="Pilih Area">
		<?php
			if( $list = $area->daftar_area() ){
				while($rs = $list->fetch_assoc() ){
					echo "<option value='".$rs['id']."'>".stripslashes($rs['area'])."</option>";
				}
			}

		?>
		</select><br>
		<a class="btn btn-primary btn-orange btn-sm" href='#' id="btn-cari-rayon"><i class="fa fa-"></i> Cari Rayon</a><br><br>
		<select name="cari-rayon" id="cari-rayon" class="form-control" required="required" placeholder="Pilih Rayon">
		<?php
			// if( $list = $rayon->daftar_rayon() ){
				// while($rs = $list->fetch_assoc() ){
					// echo "<option value='".$rs['id']."'>".stripslashes($rs['rayon'])."</option>";
				// }
			// }
		?>
		</select><br>
		<a class="btn btn-primary btn-orange btn-sm" href='#' id="cari-pelanggan"><i class="fa fa-"></i> Cari Pelanggan</a>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-mod" id="tabel-pelanggan">
				<thead>
					<tr>
						<th>#</th><th>Nama Pelanggan</th><th>Alamat</th><th>Rayon</th><th>Pasar</th><th>Sub-pasar</th><th>type</th><th>Area</th><th>Kode Pos</th><th></th>
					</tr>
				</thead>
				<tbody>
				<?php

					// if( $cari = $data->daftar_pelanggan() ){
						
						// while( $rs = $cari->fetch_assoc() ){
							// echo "<tr>
								//<td>".$rs['noreg']."</td><td>".stripslashes($rs['nama'])."</td><td>".stripslashes($rs['alamat'])."</td><td>".stripslashes($rs['nm_rayon'])."</td><td>".stripslashes($rs['pasar'])."</td><td>".stripslashes($rs['sub_pasar'])."</td><td>".stripslashes($rs['type'])."</td><td>".stripslashes($rs['nm_area'])."</td><td>".stripslashes($rs['kode_pos'])."</td><td><a href='#' class='btn btn-sm btn-danger btn-orange edit-pelanggan' data-id='".$rs['id']."' data-noreg='".$rs['noreg']."' data-nama='".stripslashes($rs['nama'])."' data-alamat='".stripslashes($rs['alamat'])."' data-rayon='".$rs['rayon']."' data-pasar='".stripslashes($rs['pasar'])."' data-sub_pasar='".stripslashes($rs['sub_pasar'])."' data-type='".stripslashes($rs['type'])."' data-area='".$rs['area']."' data-kode_pos='".stripslashes($rs['kode_pos'])."'  ><i class='fa fa-edit'></i></a>  <a href='#' class='btn btn-sm btn-danger hapus-pelanggan' data-id='".$rs['id']."' data-noreg='".$rs['noreg']."' data-nama='".stripslashes($rs['nama'])."' data-alamat='".stripslashes($rs['alamat'])."' data-rayon='".$rs['rayon']."' data-pasar='".stripslashes($rs['pasar'])."' data-sub_pasar='".stripslashes($rs['sub_pasar'])."' data-type='".stripslashes($rs['type'])."' data-area='".$rs['area']."' data-kode_pos='".stripslashes($rs['kode_pos'])."'  ><i class='fa fa-trash-o'></i></a></td>
							// </tr>";
						// }
					// }

				?>
					
				</tbody>
			</table>
		</div>
	</div>

<!-- modal tambah pelanggan -->
<div class="modal fade" id="modal-input">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header custom orange">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><i class="fa fa-plus"></i> Daftarkan Pelanggan</h4>
						</div>
						<div class="modal-body">
							<form action="#" id="form-input" class="form-horizontal" method="POST">
								
								<input type="hidden" id="apa" name="apa" value="">
								<input type="hidden" id="aksi" name="aksi" value="<?php echo e_url('./pelanggan/pelanggan_aux.php'); ?>">
								<input type="hidden" id="id" name="id" value="">

								
								<div class="form-group">
									<label for="inputAlamat" class="col-sm-3 control-label">No Reg</label>
									<div class="col-sm-9">

								        <input type="text" class="form-control input-min" name="noreg" id="noreg" placeholder="no. reg , ex: 99.99999">
								        
								      </div>
								</div>
								<div class="form-group">
									<label for="inputNama" class="col-sm-3 control-label">Nama Pelanggan</label>
									<div class="col-sm-9">
										<input type="text" name="nama" id="nama" class="form-control input-min"    placeholder="nama pelanggan">
									</div>
								</div>
								<div class="form-group">
									<label for="inputAlamat" class="col-sm-3 control-label">Alamat</label>
									<div class="col-sm-9">
										<textarea name="alamat" id="alamat" cols="30" rows="2" class="form-control input-min" placeholder="alamat pelanggan"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="inputNama" class="col-sm-3 control-label">Rayon</label>
									<div class="col-sm-9">
										<select name="rayon" id="rayon" class="form-control" required="required" placeholder="Pilih Rayon">
										<?php
											if( $list = $rayon->daftar_rayon() ){
												while($rs = $list->fetch_assoc() ){
													echo "<option value='".$rs['id']."'>".stripslashes($rs['rayon'])."</option>";
												}
											}

										?>
											
											
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="inputNama" class="col-sm-3 control-label">Pasar</label>
									<div class="col-sm-9">
										<input type="text" name="pasar" id="pasar" class="form-control input-min"    placeholder="pasar">
									</div>
								</div>
								<div class="form-group">
									<label for="inputNama" class="col-sm-3 control-label">Sub Pasar</label>
									<div class="col-sm-9">
										<input type="text" name="sub_pasar" id="sub_pasar" class="form-control input-min"    placeholder="Sub pasar">
									</div>
								</div>
								<div class="form-group">
									<label for="inputNama" class="col-sm-3 control-label">Type</label>
									<div class="col-sm-9">
										<input type="text" name="type" id="type" class="form-control input-min"    placeholder="type">
									</div>
								</div>
								<div class="form-group">
									<label for="inputNama" class="col-sm-3 control-label">Area</label>
									<div class="col-sm-9">
										<select name="area" id="area" class="form-control" required="required" placeholder="Pilih Area">
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
								<div class="form-group">
									<label for="inputNama" class="col-sm-3 control-label">Kode Pos</label>
									<div class="col-sm-9">
										<input type="text" name="kode_pos" id="kode_pos" class="form-control input-min"    placeholder="Kode Pos">
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
            data: {"mod" : "<?php echo e_url('pelanggan/pelanggan.php'); ?>", "title" : "pelanggan" },
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
	
	tabelpelanggan = $('#tabel-pelanggan').DataTable({
		ajax:{
			url : "./",
			type : "POST",
			data : function(d) {
				d.aksi = "<?php echo e_url('pelanggan/pelanggan_aux.php'); ?>";
				d.title = "Daftar Pelanggan";
				d.apa = "get-pelanggan";
				d.area = $('#cari-area').val();
				d.rayon = $('#cari-rayon').val();
			}
		}
	});

	$('.input-pelanggan').on('click', function(ev){
		ev.preventDefault();
		$('#modal-input').find('.modal-title').html('<i class="fa fa-plus"></i> Daftarkan Pelanggan');
		$('#apa').val('input-pelanggan');
		$('#id').val('');
		
		$('#noreg').val('');
		$('#nama').val('');
		$('#alamat').val('');
		$('#rayon').val('');
		$('#pasar').val('');
		$('#sub_pasar').val('');
		$('#type').val('');
		$('#area').val('');
		$('#kode_pos').val('');
		$('.btn-simpan').html('Simpan <i class="fa fa-send"></i>');
		$('#modal-input').modal('show');

	});

	$(document).on('click', '.edit-pelanggan',function(ev){
		ev.preventDefault();
		$('#modal-input').find('.modal-title').html('<i class="fa fa-edit"></i> Ubah Pelanggan');
		$('#apa').val('edit-pelanggan');
		$('#id').val($(this).data('id'));
		
		$('#noreg').val($(this).data('noreg'));
		$('#nama').val($(this).data('nama'));
		$('#alamat').val($(this).data('alamat'));
		$('#rayon').val($(this).data('rayon'));
		$('#pasar').val($(this).data('pasar'));
		$('#sub_pasar').val($(this).data('sub_pasar'));
		$('#type').val($(this).data('type'));
		$('#area').val($(this).data('area'));
		$('#kode_pos').val($(this).data('kode_pos'));
		$('.btn-simpan').html('Simpan <i class="fa fa-send"></i>');
		$('#modal-input').modal('show');

	});

	$(document).on('click', '.hapus-pelanggan',function(ev){
		ev.preventDefault();
		$('#modal-input').find('.modal-title').html('<i class="fa fa-trash"></i> Hapus Pelanggan');
		$('#apa').val('hapus-pelanggan');
		$('#id').val($(this).data('id'));
		
		$('#noreg').val($(this).data('noreg'));
		$('#nama').val($(this).data('nama'));
		$('#alamat').val($(this).data('alamat'));
		$('#rayon').val($(this).data('rayon'));
		$('#pasar').val($(this).data('pasar'));
		$('#sub_pasar').val($(this).data('sub_pasar'));
		$('#type').val($(this).data('type'));
		$('#area').val($(this).data('area'));
		$('#kode_pos').val($(this).data('kode_pos'));
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
	
	$('#cari-pelanggan').click(function(ev){
		ev.preventDefault();
		tabelpelanggan.ajax.reload();
	});
	
	$('#btn-cari-rayon').click(function(ev){
		ev.preventDefault();
		$.ajax({
			url : "./",
			method: "POST",
			cache: false,
			data: {"aksi" : "<?php echo e_url('pelanggan/pelanggan_aux.php'); ?>", "apa" : "get-rayon", "area" : $('#cari-area').val()},
			success: function(event){
				$('#cari-rayon').empty();	
				$('#cari-rayon').html(event);
			},
			error: function(){
				alert('Gagal terkoneksi dengan server, coba lagi..!');
			}
		});
	});






});

</script>