<?php
	include './po/class.po.php';
	$data = new po_po();
?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<center>
				<h4>Realisasi P.O.</h4>
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
								<th>Jumlah Pesanan</th>
								<th>Jumlah Dikirim</th>
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


<div class="modal fade" id="modal-realisasi">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header custom orange">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-list"></i> Realisasi Detail PO</h4>
			</div>
			<div class="modal-body">
				<form action="#" id="form-input" class="form-horizontal" method="POST">
					<input type="hidden" name="idPO" id="idPO" class="form-control">
					<input type="hidden" name="idDetailPO" id="idDetailPO" class="form-control">
					<div class="form-group">
						<label for="tglRealisasi" class="col-sm-3 control-label">Tanggal Realisasi</label>
						<div class="col-sm-9">
							<input type="text" name="tglRealisasi" id="tglRealisasi" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="jumlah" class="col-sm-3 control-label">Jumlah Realisasi</label>
						<div class="col-sm-9">
							<input type="text" name="jumlah" id="jumlah" class="form-control">
						</div>
					</div>
					
					<div><center><h3><i class='loading' id="loading" class='fa fa-refresh fa-spin'></i></h3></center></div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger btn-simpan" id="btn-simpan">Save <i class="fa fa-send"></i></button>
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
	
	$("#tglRealisasi").datepicker({
		dateFormat : "yy-mm-dd",
		disabled : true
	});
	
	$("#tglRealisasi").datepicker('setDate', new Date());
	
	tabelpo = $('#tabel-po').DataTable({
		ajax:{
			url : "./",
			type : "POST",
			data : function(d) {
				d.aksi = "<?php echo e_url('po/po_aux.php'); ?>";
				d.title = "Daftar P.O";
				d.apa = "realisasi-daftar-po";
				d.tglAwal = $("#tglAwal").val();
				d.tglAkhir = $("#tglAkhir").val();
			}
		}
	});
	
	$('#btn-refresh-table').click(function(ev){
		ev.preventDefault();
		tabelpo.ajax.reload();
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
	
	$("#tabel-detail-po tbody").on("click",".btn-realisasi-item-detail",
		function(ev){
			ev.preventDefault();
			$('#modal-detail').modal('hide');
			$('#modal-realisasi').modal('show');
			$('#idPO').val($(this).data("idpo"));
			$('#idDetailPO').val($(this).data("id"));
		}
	);
	
	$('.btn-simpan').click( function(ev){
		ev.preventDefault();

		$('.btn-simpan').addClass('disabled').html('Processing... <i class="fa fa-spinner fa-pulse"></i>');
		
		var tgl = $('#tglRealisasi').val();
		var idDetailPO = $('#idDetailPO').val();
		var idPO = $('#idPO').val();
		var jumlah = $('#jumlah').val();
		var datanya = {"aksi" : "<?php echo e_url('./po/po_aux.php'); ?>", "title" : "P.O.", "apa" : "simpan-realisasi", "tgl" : tgl, "idDetailPO" : idDetailPO, "jumlah" : jumlah};
		
		$.ajax({
            url: "./",
            method: "POST",
            cache: false,
			dataType: "JSON",
            data: datanya,
            success: function(eve){

            	if( eve.status ){
            		alert(eve.msg);
					$('.btn-simpan').html('Simpan <i class="fa fa-send"></i>').removeClass('disabled');
					$('#jumlah').val("");
					$('#modal-realisasi').modal('hide');
					$('#modal-detail').modal('show');
					$('#tabel-detail-po tbody').empty();
					$('#loadingText').text("Loading...");
					isiTabelDetail(idPO);
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
	
	function reloading(){
		$('#isi_halaman').append("<div class='pull-right loading'><h1><i class='fa fa-refresh fa-spin'></i></h1></div>");
		$.ajax({
        	url : "./",
            method: "POST",
            cache: false,
            data: {"mod" : "<?php echo e_url('po/realisasi_po.php'); ?>", "title" : "P.O." },
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
			data: {"aksi" : "<?php echo e_url('po/po_aux.php'); ?>", "title" : "P.O.", "apa" : "realisasi-daftar-detail-po", "idPO" : idPO },
			success: function(response){
				var trHTML = '';
				$.each(response, function (i, item) {
					trHTML += '<tr><td>'+  item.gsm + '</td><td>' + item.deskripsi + '</td><td>' + item.tema + '</td><td>' + item.ukuran + '</td><td>' + item.jml + '</td><td>'+ item.jmlKirim +'</td><td>' + item.btn +'</td></tr>';
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
	
	$('#modal-detail').on('shown.bs.modal', function () {
		$(this).find('.modal-dialog').css({
			width:'auto',
			height:'auto', 
			'max-height':'100%'});
	});
	
});

</script>