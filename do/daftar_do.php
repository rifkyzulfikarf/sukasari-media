<?php
	include './do/class.do.php';
	$data = new do_do();
?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<center>
				<h4>Daftar D.O.</h4>
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
	
	tabeldo = $('#tabel-do').DataTable({
		ajax:{
			url : "./",
			type : "POST",
			data : function(d) {
				d.aksi = "<?php echo e_url('do/do_aux.php'); ?>";
				d.title = "Daftar D.O";
				d.apa = "daftar-do";
				d.tglAwal = $("#tglAwal").val();
				d.tglAkhir = $("#tglAkhir").val();
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
	
	function isiTabelDetail(idDO) {
		$.ajax({
			url : "./",
			method: "POST",
			dataType: "JSON",
			data: {"aksi" : "<?php echo e_url('do/do_aux.php'); ?>", "title" : "D.O.", "apa" : "daftar-detail-do", "idDO" : idDO },
			success: function(response){
				var trHTML = '';
				$.each(response, function (i, item) {
					trHTML += '<tr><td>' + item.deskripsi + '</td><td>' + item.tema + '</td><td>' + item.ukuran + '</td><td>' + item.jml + '</td><td>' + item.ket + '</td><td>' + item.btn +'</td></tr>';
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
	
	$("#tabel-do tbody").on("click",".btn-delete-do",
		function(ev){
			ev.preventDefault();
			var idDO = $(this).data("id");
			if(confirm('Apakah benar akan dihapus ?')){
				$.ajax({
					url: "./",
					method: "POST",
					cache: false,
					dataType: "JSON",
					data: {"aksi" : "<?php echo e_url('do/do_aux.php'); ?>", "title" : "D.O.", "apa" : "hapus-do", "idDO" : idDO},
					success: function(eve){
						if (eve.status){
							alert(eve.msg);
							tabeldo.ajax.reload();
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
	
	$("#tabel-detail-do").on("click", ".btn-delete-item-detail", function(ev){
		ev.preventDefault();
		var id = $(this).data("id");
		var idDO = $(this).data("iddo");
		if (confirm("Apakah benar akan dihapus ?")) {
			$.ajax({
				url: "./",
				method: "POST",
				cache: false,
				dataType: "JSON",
				data: {"aksi" : "<?php echo e_url('do/do_aux.php'); ?>", "title" : "D.O.", "apa" : "hapus-detail-do", "idDO" : id},
				success: function(eve) {
					if (eve.status) {
						alert(eve.msg);
						$('#tabel-detail-do tbody').empty();
						$('#loadingText').text("Loading...");
						isiTabelDetail(idDO);
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
            data: {"mod" : "<?php echo e_url('do/daftar_do.php'); ?>", "title" : "D.O." },
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
	
	$('#modal-detail').on('shown.bs.modal', function () {
		$(this).find('.modal-dialog').css({
			width:'auto',
			height:'auto', 
			'max-height':'100%'});
	});
	
	
});

</script>