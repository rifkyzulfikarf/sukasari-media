<?php
	include './po/class.po.php';
	$data = new po_po();
?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<center>
				<h4>Input P.O.</h4>
			</center>
		</div>
	</div>
	<hr>
	<form action="#" method="POST" id="form-do" name="form-do" >
		<div class="row">
			<div class="col-xs-12">
				<div class="form-group">
					<label for="inputSupplier" class="col-sm-3 control-label">Supplier</label>
					<div class="col-sm-9">
						<select name="cmbsupplier" id="cmbsupplier" class="chosen-select form-control"></select>
					</div>
				</div>
				<div class="form-group">
					<label for="inputTanggalPO" class="col-sm-3 control-label">Tanggal P.O.</label>
					<div class="col-sm-9">
						<input type="text" name="tglPO" id="tglPO" class="form-control " placeholder="Tanggal P.O.">
					</div>
				</div>
				<div class="form-group">
					<label for="inputTanggalKirim" class="col-sm-3 control-label">Tanggal Kirim</label>
					<div class="col-sm-9">
						<input type="text" name="tglKirim" id="tglKirim" class="form-control " placeholder="Tanggal Kirim">
					</div>
				</div>
				<div class="form-group">
					<label for="inputTOP" class="col-sm-3 control-label">Term of Payment</label>
					<div class="col-sm-9">
						<textarea id="txtTOP" name="txtTOP"></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-mod" id="tabel-detail">
					<thead>
						<tr>
							<th>Tema</th>
							<th>Ukuran</th>
							<th>Jenis Layar</th>
							<th>Jumlah</th>
							<th>Harga/m2</th>
							<th>Subtotal</th>
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
			<div class="form-group">
				<label for="totalHarga" class="col-sm-3 control-label">Total Harga</label>
				<div class="col-sm-3">
					<input type="text" name="txtTotalHarga" id="txtTotalHarga" class="form-control input-min" value="" readonly>
				</div>
			</div>
		</div>
		<button type="button" class="btn btn-danger btn-orange btn-simpan">Simpan <i class="fa fa-send"></i></button>
	</form>
</div>

<div class="modal fade" id="modal-input">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header custom orange">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-plus"></i> Tambah Item</h4>
			</div>
			<div class="modal-body">
				<form action="#" id="form-input" class="form-horizontal" method="POST">
					<div class="form-group">
						<label for="periodePO1" class="col-sm-3 control-label">Periode Tanggal</label>
						<div class="col-sm-9">
							<input type="text" name="periodeDO1" id="periodeDO1" class="form-control " placeholder="Tanggal D.O.">
						</div>
					</div>
					<div class="form-group">
						<label for="periodePO2" class="col-sm-3 control-label">Sampai Tanggal</label>
						<div class="col-sm-9">
							<input type="text" name="periodeDO2" id="periodeDO2" class="form-control " placeholder="Tanggal D.O.">
						</div>
					</div>
					<button type="button" class="btn btn-orange" id="btn-cari-po">Cari <i class="fa fa-search"></i></button>
					<div class="form-group">
						<label for="PO" class="col-sm-3 control-label">Pilih DO</label>
						<div class="col-sm-9">
							<select name="cmbDO" id="cmbDO" class="form-control"></select>
						</div>
					</div>
					<div class="form-group">
						<label for="PO" class="col-sm-3 control-label">Pilih Item</label>
						<div class="col-sm-9">
							<select name="cmbItem" id="cmbItem" class="form-control"></select>
						</div>
					</div>
					<div class="form-group">
						<label for="PO" class="col-sm-3 control-label">Pilih Jenis Kertas</label>
						<div class="col-sm-9">
							<select name="cmbJenisKertas" id="cmbJenisKertas" class="form-control"></select>
						</div>
					</div>
					<div><center><h3><i class='loading' id="loading" class='fa fa-refresh fa-spin'></i></h3></center></div>
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
	
	$("#tglPO").datepicker({
		dateFormat : "yy-mm-dd",
		disabled : true
	}).datepicker("setDate", new Date());
	
	$("#tglKirim").datepicker({
		dateFormat : "yy-mm-dd"
	});
	
	$("#periodeDO1").datepicker({
		dateFormat : "yy-mm-dd"
	});
	
	$("#periodeDO2").datepicker({
		dateFormat : "yy-mm-dd"
	});
	
	$('.chosen-select').chosen();
	
	$('#loading').hide();
	
	isiComboSupplier();
	
	function reloading(){
		$('#isi_halaman').append("<div class='pull-right loading'><h1><i class='fa fa-refresh fa-spin'></i></h1></div>");
		$.ajax({
        	url : "./",
            method: "POST",
            cache: false,
            data: {"mod" : "<?php echo e_url('po/input_po.php'); ?>", "title" : "D.O." },
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
	
	function isiComboSupplier() {
		$.ajax({
			url : "./",
			method: "POST",
			cache: false,
			data: {"aksi" : "<?php echo e_url('po/po_aux.php'); ?>", "title" : "P.O.", "apa" : "isi-daftar-supplier" },
			success: function(ev){
				console.log(ev);
				$("#cmbsupplier").html(ev);
				$("#cmbsupplier").trigger("chosen:updated");
			},
			error: function(){
				alert('Gagal terkoneksi dengan server, coba lagi..!');
			}
		});	
	};
	
	function isiComboDO() {
		var tgl1 = $("#periodeDO1").val();
		var tgl2 = $("#periodeDO2").val();
		$.ajax({
			url : "./",
			method: "POST",
			cache: false,
			data: {"aksi" : "<?php echo e_url('po/po_aux.php'); ?>", "title" : "P.O.", "apa" : "isi-daftar-do", "tglAwal" : tgl1, "tglAkhir" : tgl2 },
			success: function(ev){
				$("#cmbDO").html(ev);
				isiItemDO();
			},
			error: function(){
				alert('Gagal terkoneksi dengan server, coba lagi..!');
			}
		});	
	};
	
	function isiItemDO() {
		var idDO = $("#cmbDO").val();
		$.ajax({
			url : "./",
			method: "POST",
			cache: false,
			data: {"aksi" : "<?php echo e_url('po/po_aux.php'); ?>", "title" : "P.O.", "apa" : "isi-daftar-item-do", "idDO" : idDO},
			success: function(ev){
				$("#cmbItem").html(ev);
			},
			error: function(){
				alert('Gagal terkoneksi dengan server, coba lagi..!');
			}
		});	
	};
	
	function isiComboLayar() {
		$.ajax({
			url : "./",
			method: "POST",
			cache: false,
			data: {"aksi" : "<?php echo e_url('po/po_aux.php'); ?>", "title" : "P.O.", "apa" : "isi-daftar-layar"},
			success: function(ev){
				$("#cmbJenisKertas").html(ev);
			},
			error: function(){
				alert('Gagal terkoneksi dengan server, coba lagi..!');
				$('#loading').hide();
			}
		});	
	};
	
	$('.btn-simpan').click( function(ev){
		ev.preventDefault();

	});
	
	$('.btn-add-detail').on('click', function(ev){
		ev.preventDefault();
		$('#modal-input').modal('show');
	});
	
	$('.btn-add').on('click', function(ev){
		ev.preventDefault();
		var tema = $("#cmbItem option:selected").data('tema');
		var idDetail = $("#cmbItem option:selected").val();
		var pre = $("#cmbItem option:selected").data('pre');
		var panjang = $("#cmbItem option:selected").data('panjang');
		var lebar = $("#cmbItem option:selected").data('lebar');
		var jumlah = $("#cmbItem option:selected").data('jml');
		var idLayar = $("#cmbJenisKertas option:selected").val();
		var jenisLayar = $("#cmbJenisKertas option:selected").text();
		var harga = $("#cmbJenisKertas option:selected").data('harga');
		var subtotal = (panjang * lebar * jumlah * harga).toFixed(0);
		
		$("#tabel-detail tbody").append(
			"<tr>"+
			"<td>"+ tema +"</td>"+
			"<td>"+ pre + " " + panjang + " x " + lebar +"</td>"+
			"<td>"+ jenisLayar +"</td>"+
			"<td>"+ jumlah +"</td>"+
			"<td>"+ harga +"</td>"+
			"<td>"+ subtotal +"</td>"+
			"<td><a class='btn btn-sm btn-danger hapus-detail' href='#'><i class='fa fa-trash-o'></i></a></td>"+
			"<td style='display:none;'>"+ idDetail +"</td>"+
			"<td style='display:none;'>"+ idLayar +"</td>"+
			"</tr>"
		);
		
		$(".hapus-detail").bind("click", deleteDetail);
		$('#modal-input').modal('hide');
		hitungTotalBiaya();
	});
	
	$('#btn-cari-po').on('click', function(ev){
		ev.preventDefault();
		$("#cmbDO").empty();
		$("#cmbItem").empty();
		$("#cmbJenisKertas").empty();
		$('#loading').show();
		isiComboDO();
		isiComboLayar();
		$('#loading').hide();
	});
	
	$('#cmbDO').on('change', function(ev){
		$('#loading').show();
		$('#cmbItem').empty();
		isiItemDO();
		$('#loading').hide();
	});

	$('.btn-simpan').click( function(ev){
		ev.preventDefault();

		$('.btn-simpan').addClass('disabled').html('Processing... <i class="fa fa-spinner fa-pulse"></i>');
		
		var TableData;
		TableData = storeTblValues();
		TableData = JSON.stringify(TableData);
		
		var idSupplier = $("#cmbsupplier").val();
		var tglPO = $("#tglPO").val();
		var tglKirim = $("#tglKirim").val();
		var top = $('#txtTOP').val();
		var totalBiaya = $('#txtTotalHarga').val();
		
		var datanya = {"aksi" : "<?php echo e_url('./po/po_aux.php'); ?>", "title" : "P.O.", "apa" : "simpan", "data-detail" : TableData, "idSupplier" : idSupplier, "tglPO" : tglPO, "tglKirim" : tglKirim, "top" : top, "totalBiaya" : totalBiaya};
		
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
	
	function storeTblValues(){
		var TableData = new Array();

		$('#tabel-detail > tbody > tr').each(function(row, tr){
			TableData[row]={
				"idItem" : $(tr).find('td:eq(7)').text()
				, "idJenisLayar" :$(tr).find('td:eq(8)').text()
				, "harga" : $(tr).find('td:eq(4)').text()
				, "subtotal" : $(tr).find('td:eq(5)').text()
			}    
		}); 
		console.debug(TableData);
		return TableData;
	}
	
	function deleteDetail() {
		var par = $(this).parent().parent(); //tr
		par.remove();
		hitungTotalBiaya();
	};
	
	function hitungTotalBiaya() {
		var totalBiaya = 0;
		$('#tabel-detail > tbody > tr').each(function(row, tr){
			totalBiaya = totalBiaya + Number($(tr).find('td:eq(5)').text());
		});
		$('#txtTotalHarga').val(totalBiaya);
	}
});

</script>