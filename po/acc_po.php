<?php
	include './po/class.po.php';
	$data = new po_po();
?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<center>
				<h4>ACC P.O.</h4>
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
						<th>Status</th>
						<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
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
								<th>Pelanggan</th>
								<th>GSM</th>
								<th>Deskripsi</th>
								<th>Tema</th>
								<th>Ukuran</th>
								<th>Jumlah</th>
								<th>Meter<sup>2</sup></th>
								<th>Unit Price</th>
								<th>Subtotal</th>
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
	
	tabelpo = $('#tabel-po').DataTable({
		ajax:{
			url : "./",
			type : "POST",
			data : function(d) {
				d.aksi = "<?php echo e_url('po/po_aux.php'); ?>";
				d.title = "Daftar P.O";
				d.apa = "acc-daftar-po";
				d.tglAwal = $("#tglAwal").val();
				d.tglAkhir = $("#tglAkhir").val();
			}
		}
	});
	
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
	
	$("#tabel-po tbody").on("click",".btn-acc-po", function(ev){
		ev.preventDefault();
		var idPO = $(this).data("id");
		if (confirm("Apakah benar akan di acc ?")) {
			$.ajax({
				url: "./",
				method: "POST",
				cache: false,
				dataType: "JSON",
				data: {"aksi" : "<?php echo e_url('po/po_aux.php'); ?>", "title" : "P.O.", "apa" : "simpan-acc-po", "idPO" : idPO},
				success: function(eve) {
					if (eve.status) {
						alert(eve.msg);
						tabelpo.ajax.reload();
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
	
	$("#tabel-po tbody").on("click",".btn-tolak-po", function(ev){
		ev.preventDefault();
		var idPO = $(this).data("id");
		if (confirm("Apakah benar akan di tolak ?")) {
			$.ajax({
				url: "./",
				method: "POST",
				cache: false,
				dataType: "JSON",
				data: {"aksi" : "<?php echo e_url('po/po_aux.php'); ?>", "title" : "P.O.", "apa" : "simpan-tolak-po", "idPO" : idPO},
				success: function(eve) {
					if (eve.status) {
						alert(eve.msg);
						tabelpo.ajax.reload();
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
            data: {"mod" : "<?php echo e_url('po/acc_po.php'); ?>", "title" : "P.O." },
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
			data: {"aksi" : "<?php echo e_url('po/po_aux.php'); ?>", "title" : "P.O.", "apa" : "acc-daftar-detail-po", "idPO" : idPO },
			success: function(response){
				var trHTML = '';
				$.each(response, function (i, item) {
					trHTML += '<tr><td>'+ item.pelanggan + '</td><td>' +  item.gsm + '</td><td>' + item.deskripsi + '</td><td>' + item.tema + '</td><td>' + item.ukuran + '</td><td>' + item.jml + '</td><td>' + item.luas + '</td><td>' + item.unit + '</td><td>' + item.subtotal + '</td></tr>';
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
	
	$('#btn-refresh-table').click(function(ev){
		ev.preventDefault();
		tabelpo.ajax.reload();
	});
	
	$('#modal-detail').on('shown.bs.modal', function () {
		$(this).find('.modal-dialog').css({
			width:'auto',
			height:'auto', 
			'max-height':'100%'});
	});

});

</script>