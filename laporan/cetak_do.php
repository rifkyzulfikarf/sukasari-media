<?php
	include './area/class.area.php';
	$area = new area();
?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<center>
				<h4>Cetak D.O.</h4>
			</center>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<label for="cariTanggal" class="col-sm-2 control-label">Periode DO</label>
			<div class="col-sm-10">
				<div class="col-sm-3"><input type="text" name="tglAwal" id="tglAwal" class="form-control " placeholder="Tanggal Awal"></div>
				<div class="col-sm-3"><input type="text" name="tglAkhir" id="tglAkhir" class="form-control " placeholder="Tanggal Akhir"></div>
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<label for="cariArea" class="col-sm-2 control-label">Area</label>
			<div class="col-sm-10">
				<div class="col-sm-3">
					<select name="area" id="area" class="chosen-select form-control">
						<option value="%">Semua</option>
						<?php
							if($daftar = $area->daftar_area() ){
								while($rs = $daftar->fetch_array() ){
									echo "<option value='".$rs['id']."'>".$rs['area']."</option>";
								}
							}
						?>
					</select>
				</div>
				<div class="col-sm-3"><button type="button" class="btn btn-normal btn-orange" id="btn-refresh-table"><i class="fa fa-refresh"></i></button></div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped table-mod" id="tabel-do">
				<thead>
					<tr>
						<th>No DO</th>
						<th>Tgl DO</th>
						<th>Pelanggan</th>
						<th>Area</th>
						<th>Status</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
				<tfoot></tfoot>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<button type="button" class="btn btn-normal btn-orange" id="btn-print-table"><i class="fa fa-print"> Cetak</i></button>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-detail">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header custom orange">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-list"></i> Detail DO</h4>
			</div>
			<div class="modal-body">
				<div class="col-sm-12">
					<center><label></label></center>
					<center><label id="loadingText"></label></center>
					<table class="table table-bordered table-striped table-mod" id="tabel-detail-do">
						<thead>
							<tr>
								<th>Deskripsi</th>
								<th>Tema</th>
								<th>Ukuran</th>
								<th>Jumlah</th>
								<th>Keterangan</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
						<tfoot></tfoot>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal-style-cetak">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header custom orange">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-list"></i> Style Layout</h4>
			</div>
			<div class="modal-body">
				<div class="col-sm-12">
					<input type="hidden" id="id-cetak">
					<center><label></label></center>
					<label>Pilih layout :</label><br>
					<button type="button" class="btn btn-orange" id="btn-cetak-minimalis">Minimalis</button>
					<button type="button" class="btn btn-orange" id="btn-cetak-full">Full</button>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
$(document).ready(function(){
	
	$("#tglAwal").datepicker({
		dateFormat : "yy-mm-dd"
	});
	
	$("#tglAwal").datepicker('setDate', new Date());
	
	$("#tglAkhir").datepicker({
		dateFormat : "yy-mm-dd"
	});
	
	$("#tglAkhir").datepicker('setDate', new Date());
	
	$('.chosen-select').chosen();
	
	tabeldo = $('#tabel-do').DataTable({
		ajax:{
			url : "./",
			type : "POST",
			data : function(d) {
				d.aksi = "<?php echo e_url('laporan/cetak_aux.php'); ?>";
				d.title = "Daftar D.O";
				d.apa = "cetak-do-daftar-do";
				d.tglAwal = $("#tglAwal").val();
				d.tglAkhir = $("#tglAkhir").val();
				d.area = $("#area").val();
			}
		}
	});
	
	$("#tabel-do tbody").on("click",".btn-show-detail",
		function(ev){
			ev.preventDefault();
			var idDO = $(this).data("id");
			$('#modal-detail').modal('show');
			$('#tabel-detail-do tbody').empty();
			$('#loadingText').text("Loading...");
			isiTabelDetail(idDO);
		}
	);
	
	$("#tabel-do tbody").on("click",".btn-cetak-do",
		function(ev){
			ev.preventDefault();
			$('#id-cetak').val($(this).data("id"));
			$('#modal-style-cetak').modal('show');
		}
	);
	
	$('#btn-cetak-minimalis').click(function(ev){
		ev.preventDefault();
		var idDO = $('#id-cetak').val();
		var url = "laporan/excel-each-do.php?id="+idDO+"&layout=minim";
		window.open(url);
	});
	
	$('#btn-cetak-full').click(function(ev){
		ev.preventDefault();
		var idDO = $('#id-cetak').val();
		var url = "laporan/excel-each-do.php?id="+idDO+"&layout=full";
		window.open(url);
	});
	
	function isiTabelDetail(idDO) {
		$.ajax({
			url : "./",
			method: "POST",
			dataType: "JSON",
			data: {"aksi" : "<?php echo e_url('laporan/cetak_aux.php'); ?>", "title" : "D.O.", "apa" : "cetak-do-daftar-detail-do", "idDO" : idDO },
			success: function(response){
				var trHTML = '';
				$.each(response, function (i, item) {
					trHTML += '<tr><td>' + item.deskripsi + '</td><td>' + item.tema + '</td><td>' + item.ukuran + '</td><td>' + item.jml + '</td><td>' + item.ket + '</td></tr>';
				});
				$('#tabel-detail-do tbody').append(trHTML);
				$('#loadingText').text("");
			},
			error: function(err){
				console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
				alert('Gagal terkoneksi dengan server, coba lagi..!');
			}
				
		});	
	};
	
	function reloading(){
		$('#isi_halaman').append("<div class='pull-right loading'><h1><i class='fa fa-refresh fa-spin'></i></h1></div>");
		$.ajax({
        	url : "./",
            method: "POST",
            cache: false,
            data: {"mod" : "<?php echo e_url('laporan/cetak_do.php'); ?>", "title" : "Cetak D.O." },
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
	
	$('#btn-refresh-table').click(function(ev){
		ev.preventDefault();
		tabeldo.ajax.reload();
	});
	
	$('#btn-print-table').click(function(ev){
		ev.preventDefault();
		
		var tglAwal = $("#tglAwal").val();
		var tglAkhir = $("#tglAkhir").val();
		var area = $("#area").val();
		var namaarea = $("#area option:selected").text();
		
		//var url = "laporan/printer-page-all-do.php?tglAwal="+tglAwal+"&tglAkhir="+tglAkhir+"&area="+area+"&namaarea="+namaarea;
		var url = "laporan/excel-all-do.php?tglAwal="+tglAwal+"&tglAkhir="+tglAkhir+"&area="+area+"&namaarea="+namaarea;
		
		window.open(url);
		
	});
	
	$('#modal-detail').on('shown.bs.modal', function () {
		$(this).find('.modal-dialog').css({
			width:'auto',
			height:'auto', 
			'max-height':'100%'});
	});
	
	
});

</script>