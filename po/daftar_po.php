<?php
	include './po/class.po.php';
	$data = new po_po();
?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<center>
				<h4>Daftar P.O.</h4>
			</center>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<label for="cariTanggal" class="col-sm-2 control-label">Periode PO</label>
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
			<table class="table table-bordered table-striped table-mod" id="tabel-po">
				<thead>
					<tr>
						<th>No PO</th>
						<th>Tgl PO</th>
						<th>Tgl Kirim</th>
						<th>Supplier</th>
						<th>Total Biaya</th>
						<th>Tgl Kirim Ke Supplier</th>
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
</div>

<div class="modal fade" id="modal-detail">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header custom orange">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-list"></i> Detail PO</h4>
			</div>
			<div class="modal-body">
				<div class="col-sm-12">
					<center><label></label></center>
					<center><label id="loadingText"></label></center>
					<table class="table table-bordered table-striped table-mod" id="tabel-detail-po">
						<thead>
							<tr>
								<th>GSM</th>
								<th>Deskripsi</th>
								<th>Tema</th>
								<th>Ukuran</th>
								<th>Jumlah</th>
								<th>Meter<sup>2</sup></th>
								<th>Unit Price</th>
								<th>Subtotal</th>
								<th>Tgl Kirim Ke Sales</th>
								<th>Tgl Kirim Ke Tujuan</th>
								<th></th>
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

<div class="modal fade" id="modal-ubah-tgl-kirim">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header custom orange">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-plus"></i> Ubah Tanggal Kirim Ke Supplier</h4>
			</div>
			<div class="modal-body">
				<form action="#" id="form-input" class="form-horizontal" method="POST">
					<input type="hidden" name="id-po-ubah-tgl" id="id-po-ubah-tgl" class="form-control input-min">
					<div class="form-group">
						<label for="inputNama" class="col-sm-3 control-label">Tanggal Kirim Ke Supplier</label>
						<div class="col-sm-9">
							<input type="text" name="dp-tgl-kirim" id="dp-tgl-kirim" class="form-control input-min" placeholder="Tanggal Kirim">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger" id="btn-simpan-ubah-tanggal">Simpan <i class="fa fa-send"></i></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal-tgl-kirim">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header custom orange">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-list"></i> Tanggal Kirim Ke Tujuan</h4>
			</div>
			<div class="modal-body">
				<form action="#" id="form-input" class="form-horizontal" method="POST">
					<div class="form-group">
						<label for="idDetailPO" class="col-sm-3 control-label"></label>
						<div class="col-sm-9">
							<input type="hidden" name="kirim-idPO" id="kirim-idPO" class="form-control">
							<input type="hidden" name="kirim-idDetailPO" id="kirim-idDetailPO" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="tglRealisasi" class="col-sm-3 control-label">Tanggal Kirim ke Tujuan</label>
						<div class="col-sm-9">
							<input type="text" name="kirim-Tanggal" id="kirim-Tanggal" class="form-control">
						</div>
					</div>
					<div><center><h3><i class='loading' id="loading" class='fa fa-refresh fa-spin'></i></h3></center></div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger" id="btn-simpan-kirim">Simpan <i class="fa fa-send"></i></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal-tgl-kirim-sales">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header custom orange">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-list"></i> Tanggal Kirim Ke Pembuat DO</h4>
			</div>
			<div class="modal-body">
				<form action="#" id="form-input" class="form-horizontal" method="POST">
					<div class="form-group">
						<label for="idDetailPO" class="col-sm-3 control-label"></label>
						<div class="col-sm-9">
							<input type="hidden" name="sales-idPO" id="sales-idPO" class="form-control">
							<input type="hidden" name="sales-idDetailPO" id="sales-idDetailPO" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="tglRealisasi" class="col-sm-3 control-label">Tanggal Kirim ke Pembuat DO</label>
						<div class="col-sm-9">
							<input type="text" name="sales-Tanggal" id="sales-Tanggal" class="form-control">
						</div>
					</div>
					<div><center><h3><i class='loading' id="loading" class='fa fa-refresh fa-spin'></i></h3></center></div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger" id="btn-simpan-kirim-sales">Simpan <i class="fa fa-send"></i></button>
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
	
	$("#dp-tgl-kirim").datepicker({
		dateFormat : "yy-mm-dd",
		disabled : true
	});
	
	$("#dp-tgl-kirim").datepicker('setDate', new Date());
	
	$("#kirim-Tanggal").datepicker({
		dateFormat : "yy-mm-dd",
		disabled : true
	});
	
	$("#kirim-Tanggal").datepicker('setDate', new Date());
	
	$("#sales-Tanggal").datepicker({
		dateFormat : "yy-mm-dd",
		disabled : true
	});
	
	$("#sales-Tanggal").datepicker('setDate', new Date());
	
	tabelpo = $('#tabel-po').DataTable({
		ajax:{
			url : "./",
			type : "POST",
			data : function(d) {
				d.aksi = "<?php echo e_url('po/po_aux.php'); ?>";
				d.title = "Daftar P.O";
				d.apa = "daftar-po";
				d.tglAwal = $("#tglAwal").val();
				d.tglAkhir = $("#tglAkhir").val();
			}
		}
	});
	
	$('#btn-refresh-table').click(function(ev){
		ev.preventDefault();
		tabelpo.ajax.reload();
	});
	
	$("#tabel-po tbody").on("click",".btn-ubah-tgl-kirim",
		function(ev){
			ev.preventDefault();
			var idPO = $(this).data("id");
			$('#modal-ubah-tgl-kirim').modal('show');
			$('#id-po-ubah-tgl').val(idPO);
		}
	);
	
	$("#tabel-po tbody").on("click",".btn-show-detail",
		function(ev){
			ev.preventDefault();
			var idPO = $(this).data("id");
			$('#modal-detail').modal('show');
			$('#tabel-detail-po tbody').empty();
			$('#loadingText').text("Loading...");
			isiTabelDetail(idPO);
		}
	);
	
	$('#btn-simpan-ubah-tanggal').click(function(ev){
		ev.preventDefault();
		var idPO = $('#id-po-ubah-tgl').val();
		var tgl = $('#dp-tgl-kirim').val();
		if(confirm('Ubah tanggal kirim ke supplier ?')){
			$.ajax({
				url: "./",
				method: "POST",
				cache: false,
				dataType: "JSON",
				data: {"aksi" : "<?php echo e_url('po/po_aux.php'); ?>", "title" : "P.O.", "apa" : "ubah-tgl-kirim-ke-supplier", "idPO" : idPO, "tgl" : tgl},
				success: function(eve){
					if (eve.status){
						alert(eve.msg);
						$('.btn-close-modal').click();
						tabelpo.ajax.reload();
					} else {
						alert(eve.msg);
					}
				},
				error: function(err){
					console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
					alert('Gagal terkoneksi dengan server..');
				}

			});
		}
	});
	
	$("#tabel-po tbody").on("click",".btn-delete-po",
		function(ev){
			ev.preventDefault();
			var idPO = $(this).data("id");
			if(confirm('Apakah benar akan dihapus ?')){
				$.ajax({
					url: "./",
					method: "POST",
					cache: false,
					dataType: "JSON",
					data: {"aksi" : "<?php echo e_url('po/po_aux.php'); ?>", "title" : "P.O.", "apa" : "hapus-po", "idPO" : idPO},
					success: function(eve){
						if (eve.status){
							alert(eve.msg);
							tabelpo.ajax.reload();
						} else {
							alert(eve.msg);
						}
					},
					error: function(err){
						console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
						alert('Gagal terkoneksi dengan server..');
					}

				});
			}
		}
	);
	
	$("#tabel-detail-po").on("click", ".btn-delete-item-detail", function(ev){
		ev.preventDefault();
		var id = $(this).data("id");
		var idPO = $(this).data("idpo");
		if (confirm("Apakah benar akan dihapus ?")) {
			$.ajax({
				url: "./",
				method: "POST",
				cache: false,
				dataType: "JSON",
				data: {"aksi" : "<?php echo e_url('po/po_aux.php'); ?>", "title" : "P.O.", "apa" : "hapus-detail-po", "id" : id},
				success: function(eve) {
					if (eve.status) {
						alert(eve.msg);
						$('#tabel-detail-po tbody').empty();
						$('#loadingText').text("Loading...");
						isiTabelDetail(idPO);
					} else {
						alert(eve.msg);
					}
				},
				error: function(err) {
					console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
					alert("Gagal terkoneksi dengan server..");
				}
			});
		}
	});
	
	function reloading(){
		$('#isi_halaman').append("<div class='pull-right loading'><h1><i class='fa fa-refresh fa-spin'></i></h1></div>");
		$.ajax({
        	url : "./",
            method: "POST",
            cache: false,
            data: {"mod" : "<?php echo e_url('po/daftar_po.php'); ?>", "title" : "D.O." },
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
	
	function isiTabelDetail(idPO) {
		$.ajax({
			url : "./",
			method: "POST",
			dataType: "JSON",
			data: {"aksi" : "<?php echo e_url('po/po_aux.php'); ?>", "title" : "P.O.", "apa" : "daftar-detail-po", "idPO" : idPO },
			success: function(response){
				var trHTML = '';
				$.each(response, function (i, item) {
					trHTML += '<tr><td>'+  item.gsm + '</td><td>' + item.deskripsi + '</td><td>' + item.tema + '</td><td>' + item.ukuran + '</td><td>' + item.jml + '</td><td>' + item.luas + '</td><td>' + item.unit + '</td><td>' + item.subtotal + '</td><td>' + item.tglsales + '</td><td>' + item.tglkirim + '</td><td>' + item.btn +'</td></tr>';
				});
				$('#tabel-detail-po tbody').append(trHTML);
				$('#loadingText').text("");
			},
			error: function(err){
				console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
				alert('Gagal terkoneksi dengan server, coba lagi..!');
			}
				
		});	
	};
	
	$("#tabel-detail-po tbody").on("click",".btn-ubah-tgl-kirim",
		function(ev){
			ev.preventDefault();
			$('#modal-detail').modal('hide');
			$('#modal-tgl-kirim').modal('show');
			$('#kirim-idDetailPO').val($(this).data("id"));
			$('#kirim-idPO').val($(this).data("idpo"));
		}
	);
	
	$("#tabel-detail-po tbody").on("click",".btn-ubah-tgl-kirim-sales",
		function(ev){
			ev.preventDefault();
			$('#modal-detail').modal('hide');
			$('#modal-tgl-kirim-sales').modal('show');
			$('#sales-idDetailPO').val($(this).data("id"));
			$('#sales-idPO').val($(this).data("idpo"));
		}
	);
	
	$('#btn-simpan-kirim').click(function(ev){
		ev.preventDefault();
		var idDetail = $('#kirim-idDetailPO').val();
		var tgl = $('#kirim-Tanggal').val();
		if(confirm('Ubah tanggal kirim ke tujuan ?')){
			$.ajax({
				url: "./",
				method: "POST",
				cache: false,
				dataType: "JSON",
				data: {"aksi" : "<?php echo e_url('po/po_aux.php'); ?>", "title" : "P.O.", "apa" : "ubah-tgl-kirim-ke-tujuan", "idDetail" : idDetail, "tgl" : tgl},
				success: function(eve){
					if (eve.status){
						alert(eve.msg);
						$('.btn-close-modal').click();
						var idPO = $('#kirim-idPO').val();
						$('#modal-detail').modal('show');
						$('#tabel-detail-po tbody').empty();
						$('#loadingText').text("Loading...");
						isiTabelDetail(idPO);
					} else {
						alert(eve.msg);
					}
				},
				error: function(err){
					console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
					alert('Gagal terkoneksi dengan server..');
				}

			});
		}
	});
	
	$('#btn-simpan-kirim-sales').click(function(ev){
		ev.preventDefault();
		var idDetail = $('#sales-idDetailPO').val();
		var tgl = $('#sales-Tanggal').val();
		if(confirm('Ubah tanggal kirim ke pembuat do ?')){
			$.ajax({
				url: "./",
				method: "POST",
				cache: false,
				dataType: "JSON",
				data: {"aksi" : "<?php echo e_url('po/po_aux.php'); ?>", "title" : "P.O.", "apa" : "ubah-tgl-kirim-ke-sales", "idDetail" : idDetail, "tgl" : tgl},
				success: function(eve){
					if (eve.status){
						alert(eve.msg);
						$('.btn-close-modal').click();
						var idPO = $('#sales-idPO').val();
						$('#modal-detail').modal('show');
						$('#tabel-detail-po tbody').empty();
						$('#loadingText').text("Loading...");
						isiTabelDetail(idPO);
					} else {
						alert(eve.msg);
					}
				},
				error: function(err){
					console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
					alert('Gagal terkoneksi dengan server..');
				}

			});
		}
	});
	
	$('#modal-detail').on('shown.bs.modal', function () {
		$(this).find('.modal-dialog').css({
			width:'auto',
			height:'auto', 
			'max-height':'100%'});
	});
	
	$('#modal-detail').on('hidden.bs.modal', function () {
		tabelpo.ajax.reload();
	});
	
});

</script>