<?php
	include './supplier/class.supplier.php';
	$supplier = new supplier();
?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<center>
				<h4>Cetak Penerimaan Barang</h4>
			</center>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<label for="cariTanggal" class="col-sm-2 control-label">Tanggal Penerimaan</label>
			<div class="col-sm-10">
				<div class="col-sm-3"><input type="text" name="tglAwal" id="tglAwal" class="form-control " placeholder="Tanggal Awal"></div>
				<div class="col-sm-3"><input type="text" name="tglAkhir" id="tglAkhir" class="form-control " placeholder="Tanggal Akhir"></div>
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<label for="cariArea" class="col-sm-2 control-label">Supplier</label>
			<div class="col-sm-10">
				<div class="col-sm-3">
					<select name="supplier" id="supplier" class="chosen-select form-control">
						<option value="%">Semua</option>
						<?php
							if($daftar = $supplier->daftar_supplier() ){
								while($rs = $daftar->fetch_array() ){
									echo "<option value='".$rs['id']."'>".$rs['nama']."</option>";
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
			<table class="table table-bordered table-striped table-mod" id="tabel-penerimaan">
				<thead>
					<tr>
						<th>ID</th>
						<th>Tgl</th>
						<th>Supplier</th>
						<th>Tema</th>
						<th>Ukuran</th>
						<th>Jumlah</th>
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
	
	tabelpenerimaan = $('#tabel-penerimaan').DataTable({
		ajax:{
			url : "./",
			type : "POST",
			data : function(d) {
				d.aksi = "<?php echo e_url('laporan/cetak_aux.php'); ?>";
				d.title = "Daftar P.O";
				d.apa = "cetak-penerimaan-daftar-penerimaan";
				d.tglAwal = $("#tglAwal").val();
				d.tglAkhir = $("#tglAkhir").val();
				d.supplier = $("#supplier").val();
			}
		}
	});
	
	$('#btn-refresh-table').click(function(ev){
		ev.preventDefault();
		tabelpenerimaan.ajax.reload();
	});
	
	
	function reloading(){
		$('#isi_halaman').append("<div class='pull-right loading'><h1><i class='fa fa-refresh fa-spin'></i></h1></div>");
		$.ajax({
        	url : "./",
            method: "POST",
            cache: false,
            data: {"mod" : "<?php echo e_url('laporan/cetak_penerimaan_barang.php'); ?>", "title" : "Cetak Penerimaan Barang" },
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
	
	
	$('#btn-print-table').click(function(ev){
		ev.preventDefault();
		
		var tglAwal = $("#tglAwal").val();
		var tglAkhir = $("#tglAkhir").val();
		var supplier = $("#supplier").val();
		var namasupplier = $("#supplier option:selected").text();
		
		//var url = "laporan/printer-page-all-penerimaan-barang.php?tglAwal="+tglAwal+"&tglAkhir="+tglAkhir+"&supplier="+supplier+"&namasupplier="+namasupplier;
		var url = "laporan/excel-penerimaan-barang.php?tglAwal="+tglAwal+"&tglAkhir="+tglAkhir+"&supplier="+supplier+"&namasupplier="+namasupplier;
		
		window.open(url);
		
	});
	
});

</script>