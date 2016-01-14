<?php
	include './do/class.do.php';
	
	$data = new do_do();

	$data->runQuery("TRUNCATE TABLE `do_help`");

?>

<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<center>
				<h4>Input D.O.</h4>
			</center>
		</div>
		<div class="col-md-3">
			
		</div>
	</div>
	<hr>
	<form action="#" method="POST" id="form-do" name="form-do" >
	<div class="row">
		<div class="col-xs-12">
			
			<div class="form-group">
				<label class="col-sm-9"></label>
				<div class="col-sm-3">
					Search : 
					<select class="form-control" id="cmb-area">
					<?php
						if ($_SESSION['media-status'] == e_code("2") || $_SESSION['media-status'] == e_code("9")) {
							if ($result = $data->runQuery("SELECT `id`, `area` FROM `area` WHERE `hapus` = '0'")) {
								while ($rs = $result->fetch_array()) {
									echo "<option value='".$rs['id']."'>".$rs['area']."</option>";
								}
							}
						} else {
							echo "<option value='".$_SESSION['media-area']."'>".$_SESSION['media-namaarea']."</option>";
						}
					?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-9"></label>
				<div class="col-sm-3"><input type="text" class="form-control" id="cari" name="cari" placeholder="Cari pelanggan" ></div>
			</div>
			<input type="hidden" id="aksi" name="aksi" value="<?php echo e_url('jabatan/jabatan_aux.php'); ?>">
			<div class="form-group">
				<label for="inputNama" class="col-sm-3 control-label">Pelanggan</label>
				<div class="col-sm-9">
					<select name="pelanggan" id="pelanggan" class="chosen-select form-control">
						<option value=""></option>
						
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="inputNama" class="col-sm-3 control-label">Tanggal</label>
				<div class="col-sm-9">
					<input type="text" name="tgl" id="tgl" class="form-control "    placeholder="Tanggal D.O." readonly>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-mod" id="tabel-detail">
				<thead>
					<tr>
						<th>Deskripsi</th>
						<th>Tema</th>
						<th>Ukuran</th>
						<th>Jumlah</th>
						<th>Ket.</th>
						<th></th>
						<th style="display:none;"></th>
						<th style="display:none;"></th>
					</tr>
				</thead>
				<tbody>

				</tbody>
				<tfoot>
					<tr>
						<td colspan="7"> <a class="btn btn-danger btn-orange btn-sm pull-right btn-add-detail" href='#'><i class="fa fa-plus"></i> Tambah </a></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<button type="button" class="btn btn-danger btn-orange btn-simpan">Simpan <i class="fa fa-send"></i></button>
	</form>
</div>
<!-- modal tambah do -->
<div class="modal fade" id="modal-input">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header custom orange">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><i class="fa fa-plus"></i> Tambah Item</h4>
						</div>
						<div class="modal-body">
							<form action="#" id="form-input" class="form-horizontal" method="POST">
								<input type="hidden" id="aksi" name="aksi" value="<?php e_url('do/do_aux.php'); ?>">
								<input type="hidden" id="apa" name="apa" value="help">
								<div class="form-group">
									<label for="inputNama" class="col-sm-3 control-label">Deskripsi</label>
									<div class="col-sm-9">
										<textarea name="deskripsi" id="deskripsi" class="form-control input-min"></textarea>
										
									</div>
								</div>
								
								<div class="form-group">
									<label for="inputNama" class="col-sm-3 control-label">Tema Layar</label>
									<div class="col-sm-9">
										<select name="tema" id="tema" class="form-control">
										<?php

											if($daftar = $data->tema_layar() ){
												while($rs = $daftar->fetch_array() ){
													echo "<option value='".$rs['id']."' data-tema='".$rs['tema']."'>".$rs['tema']."</option>";
												}
											}

										?>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label for="inputNama" class="col-sm-3 control-label">Ukuran</label>
									<div class="col-sm-9">
										<select name="ukuran" id="ukuran" class="form-control">
										<?php

											if( $daftar = $data->ukuran_layar() ){
												while($rs = $daftar->fetch_array() ){
													echo "<option value='".$rs['id']."' data-ukuran='".$rs['pre']." ".$rs['panjang']." x ".$rs['lebar']."'>".$rs['pre']." ".$rs['panjang']." x ".$rs['lebar']."</option>";
												}
											}

										?>
										</select>
										
									</div>
								</div>

								<div class="form-group">
									<label for="inputNama" class="col-sm-3 control-label">Jumlah</label>
									<div class="col-sm-9">
										<input type="text" name="jumlah" id="jumlah" class="form-control input-min" value="" placeholder="jumlah">
										
									</div>
								</div>

								<div class="form-group">
									<label for="inputNama" class="col-sm-3 control-label">Keterangan *<small>bila perlu</small></label>
									<div class="col-sm-9">
										<textarea name="ket" id="ket" class="form-control input-min"></textarea>
										
									</div>
								</div>

							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-danger btn-add">Add <i class="fa fa-send"></i></button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

<script>
$(document).ready(function(){
	
	$("#tgl").datepicker({
		dateFormat : "yy-mm-dd",
		disabled : true
	}).datepicker("setDate", new Date());

	$('.chosen-select').chosen();

	$('.btn-add-detail').on('click', function(ev){
		ev.preventDefault();
		$('#modal-input').modal('show');
	});
	
	$('.btn-add').on('click', function(ev){
		ev.preventDefault();
		
		//var nourut = $('#tabel-detail >tbody >tr').length + 1; 
		var deskripsi = $("#deskripsi").val();
		var tema = $("#tema option:selected").text();
		var ukuran = $("#ukuran option:selected").text();
		var jumlah = $("#jumlah").val();
		var keterangan = $("#ket").val();
		var idtema = $("#tema").val();
		var idukuran = $("#ukuran").val();
		
		if (deskripsi != "" && jumlah != "") {
			$("#tabel-detail tbody").append(
				"<tr>"+
				"<td>"+ deskripsi +"</td>"+
				"<td>"+ tema +"</td>"+
				"<td>"+ ukuran +"</td>"+
				"<td>"+ jumlah +"</td>"+
				"<td>"+ keterangan +"</td>"+
				"<td><a class='btn btn-sm btn-danger hapus-detail' href='#'><i class='fa fa-trash-o'></i></a></td>"+
				"<td style='display:none;'>"+ idtema +"</td>"+
				"<td style='display:none;'>"+ idukuran +"</td>"+
				"</tr>"
			);
			
			$(".hapus-detail").bind("click", deleteDetail);
			$("#deskripsi").val("");
			$("#jumlah").val("");
			$("#ket").val("");
			$('#modal-input').modal('hide');
		} else {
			alert("Harap isi data dengan lengkap !");
		}
	});


	$('#cmb-area').change(function(ev){
		ev.preventDefault();
		cariPelanggan();
	});

	$(document).on("keyup","#cari", function(ev){
		ev.preventDefault();
		cariPelanggan();
	});
	
	function cariPelanggan(){
		if( $("#cari").val().length > 2 ){
			$.ajax({
	        	url : "./",
	            method: "POST",
	            cache: false,
	            data: {"aksi" : "<?php echo e_url('do/cari_pelanggan.php'); ?>", "title" : "D.O.", "cari" : $("#cari").val(), 
						"area" : $("#cmb-area").val()},
	            success: function(event){
	            	$('.loading').remove();	
	            	$('#pelanggan').html(event);
	            	$('#pelanggan').trigger("chosen:updated");
				},
	            error: function(){
	            	$('.loading').remove();
	                alert('Gagal terkoneksi dengan server, coba lagi..!');
				}
	        });	
		}
	};


	function reloading(){
		$('#isi_halaman').append("<div class='pull-right loading'><h1><i class='fa fa-refresh fa-spin'></i></h1></div>");


		$.ajax({
        	url : "./",
            method: "POST",
            cache: false,
            data: {"mod" : "<?php echo e_url('do/input_do.php'); ?>", "title" : "D.O." },
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

	function deleteDetail() {
		var par = $(this).parent().parent(); //tr
		par.remove();
	}

	function storeTblValues(){
		var TableData = new Array();

		$('#tabel-detail > tbody > tr').each(function(row, tr){
			TableData[row]={
				"deskripsi" : $(tr).find('td:eq(0)').text()
				, "tema" :$(tr).find('td:eq(6)').text()
				, "ukuran" : $(tr).find('td:eq(7)').text()
				, "jumlah" : $(tr).find('td:eq(3)').text()
				, "ket" : $(tr).find('td:eq(4)').text()
				, "tom" : $(tr).find('td:eq(5)').text()
			}    
		}); 
		//console.debug(TableData);
		return TableData;
	}

	$('.btn-simpan').click( function(ev){
		ev.preventDefault();

		$('.btn-simpan').addClass('disabled').html('Processing... <i class="fa fa-spinner fa-pulse"></i>');
		
		var TableData;
		TableData = storeTblValues();
		TableData = JSON.stringify(TableData);
		
		var idPelanggan = $("#pelanggan").val();
		var tglDO = $("#tgl").val();
		
		var datanya = {"aksi" : "<?php echo e_url('./do/do_aux.php'); ?>", "title" : "D.O.", "apa" : "simpan", "data-detail" : TableData, "idPelanggan" : idPelanggan, "tglDO" : tglDO };
		
		$.ajax({
            url: "./",
            method: "POST",
            cache: false,
			dataType: "JSON",
            data: datanya,
            success: function(eve){

            	if( eve.status ){
            		alert(eve.msg);
            		reloading();
            	}else{
            		$('.btn-simpan').html('Simpan <i class="fa fa-send"></i>').removeClass('disabled');
            		alert(eve.msg);
            	}
  

            },
            error: function(err){
				console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
            	alert('Gagal terkoneksi dengan server..');
          		$('.btn-simpan').html('Simpan <i class="fa fa-send"></i>').removeClass('disabled');
            }

         });

	});

	

	$('#form-input').submit(function(event){
		event.preventDefault();
		$('.btn-simpan').click();
	});

	$('#modal-input').on('shown.bs.modal', function () {
		$('#ukuran').chosen();
	});



});

</script>