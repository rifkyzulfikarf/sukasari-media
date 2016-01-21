<div class="container">
	<div class="row">
		<div class="col-md-12">
			<center>
				<h4>Data Jumlah Pesanan Per Pelanggan</h4>
			</center>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label class="col-sm-9"></label>
				<div class="col-sm-3"><input type="text" class="form-control" id="cari" name="cari" placeholder="Cari pelanggan" ></div>
			</div><br>
			<input type="hidden" id="aksi" name="aksi" value="<?php echo e_url('jabatan/jabatan_aux.php'); ?>">
			<div class="form-group">
				<label for="inputNama" class="col-sm-2 control-label">Pelanggan</label>
				<div class="col-sm-10">
					<select name="pelanggan" id="pelanggan" class="chosen-select form-control">
						<option value=""></option>
						
					</select>
				</div>
			</div><br>
			<label for="cariTanggal" class="col-sm-2 control-label">Periode Pesanan</label>
			<div class="col-sm-10">
				<div class="col-sm-3"><input type="text" name="tglAwal" id="tglAwal" class="form-control " placeholder="Tanggal Awal"></div>
				<div class="col-sm-3"><input type="text" name="tglAkhir" id="tglAkhir" class="form-control " placeholder="Tanggal Akhir"></div>
				<div class="col-sm-3"><button type="button" class="btn btn-normal btn-orange" id="btn-refresh-table"><i class="fa fa-refresh"></i></button></div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped table-mod" id="tabel-pesanan">
				<thead>
					<tr>
						<th>Nama Pelanggan</th>
						<th>Alamat</th>
						<th>Area</th>
						<th>Jumlah</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
				<tfoot></tfoot>
			</table>
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
					<table class="table table-bordered table-striped table-mod" id="tabel-detail-pesanan">
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
	
	$('#btn-refresh-table').click(function(ev){
		ev.preventDefault();
		tabelpesanan.ajax.reload();
	});
	
	tabelpesanan = $('#tabel-pesanan').DataTable({
		ajax:{
			url : "./",
			type : "POST",
			data : function(d) {
				d.aksi = "<?php echo e_url('laporan/cetak_aux.php'); ?>";
				d.title = "Daftar P.O";
				d.apa = "data-pesanan-daftar";
				d.tglAwal = $("#tglAwal").val();
				d.tglAkhir = $("#tglAkhir").val();
				d.id = $("#pelanggan").val();
			}
		}
	});
	
	function reloading(){
		$('#isi_halaman').append("<div class='pull-right loading'><h1><i class='fa fa-refresh fa-spin'></i></h1></div>");
		$.ajax({
        	url : "./",
            method: "POST",
            cache: false,
            data: {"mod" : "<?php echo e_url('laporan/data_pemesanan_per_pelanggan.php'); ?>", "title" : "Data Pesanan Pelanggan" },
            success: function(event){
            	$('.loading').remove();	
            	$('#isi_halaman').html(event);
			},
            error: function(){
            	$('.loading').remove();
                alert('Gagal terkoneksi dengan server, coba lagi..!');
			}
        });
	};
	
	$("#tabel-pesanan tbody").on("click", "#btn-show-detail", function(ev){
		ev.preventDefault();
		var id = $(this).data("id");
		var awal = $(this).data("awal");
		var akhir = $(this).data("akhir");
		$('#modal-detail').modal('show');
		$('#tabel-detail-pesanan tbody').empty();
		$('#loadingText').text("Loading...");
		isiTabelDetail(id, awal, akhir);
	});
	
	function isiTabelDetail(id, awal, akhir) {
		$.ajax({
			url : "./",
			method: "POST",
			dataType: "JSON",
			data: {"aksi" : "<?php echo e_url('laporan/cetak_aux.php'); ?>", "title" : "Laporan", 
			"apa" : "detail-pesanan-daftar", "id" : id, "awal" : awal, "akhir" : akhir },
			success: function(response){
				var trHTML = '';
				$.each(response, function (i, item) {
					trHTML += '<tr><td>' + item.deskripsi + '</td><td>' + item.tema + '</td><td>' + item.ukuran + '</td><td>' + item.jml + '</td><td>' + item.ket + '</td></tr>';
				});
				$('#tabel-detail-pesanan tbody').append(trHTML);
				$('#loadingText').text("");
			},
			error: function(err){
				console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
				alert('Gagal terkoneksi dengan server, coba lagi..!');
			}
				
		});	
	};
	
	$('#modal-detail').on('shown.bs.modal', function () {
		$(this).find('.modal-dialog').css({
			width:'auto',
			height:'auto', 
			'max-height':'100%'});
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
	            data: {"aksi" : "<?php echo e_url('laporan/cari_pelanggan.php'); ?>", "title" : "D.O.", "cari" : $("#cari").val()},
	            success: function(event){
	            	$('#pelanggan').html(event);
	            	$('#pelanggan').trigger("chosen:updated");
				},
	            error: function(){
	                alert('Gagal terkoneksi dengan server, coba lagi..!');
				}
	        });	
		}
	};
	
});

</script>