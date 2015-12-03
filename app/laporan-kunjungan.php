<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<h4 class="text-center">Laporan Kunjungan</h4>
		</div>
		<div class="col-md-3">
			<button data-toggle="modal" href='#modal_kriteria' class="btn btn-danger btn-sm btn-orange pull-right">Kriteria</button>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<?php 
			if($_POST[tgl_awal]==''){
			?>
			<div class="text-center text-muted">
				<p style="font-size:120px;"><i class="fa fa-question-circle"></i></p>
				<p>silakan isi kriteria laporan dengan meng-klik tombol kriteria</p>
			</div>
			<?php 
			}
			else{
				?>
				<div class="pull-right">
					<button class="btn btn-default btn-sm" onclick="ngePrint();"><i class="fa fa-print"></i> print</button>
				</div>
				<br><br>
				<table class="table table-hover table-striped table-mod" id="tabel-laporan">
					<thead>
						<tr>
							<th>#</th><th>Waktu Kunjungan</th><th>Supervisor</th><th>Customer</th><th>Kegiatan/Job</th><th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td><td>12/01/2015 08:10:10 AM</td><td>Rick Grimmes</td><td>Daryl Dixon</td><td><span class="label label-success">kunjungan</span> <span class="label label-danger">kirim barang</span> <span class="label label-warning">order</span></td><td><a href="?mod=detail-kunjungan" class="btn btn-danger btn-sm">detail</a></td>
						</tr>
						<tr>
							<td>2</td><td>12/01/2015 09:45:10 AM</td><td>Harsel Greene</td><td>Carol Peletier</td><td><span class="label label-success">kunjungan</span></td><td><a href="?mod=detail-kunjungan" class="btn btn-danger btn-sm">detail</a></td>
						</tr>
						<tr>
							<td>3</td><td>12/01/2015 12:10:10 AM</td><td>Glen Rhee</td><td>Maggie Greene</td><td><span class="label label-success">kunjungan</span> <span class="label label-danger">kirim barang</span> <span class="label label-warning">order</span></td><td><a href="?mod=detail-kunjungan" class="btn btn-danger btn-sm">detail</a></td>
						</tr>
						<tr>
							<td>4</td><td>13/01/2015 10:10:10 AM</td><td>Michonne</td><td>Dale Horvath</td><td><span class="label label-success">kunjungan</span> <span class="label label-danger">kirim barang</span></td><td><a href="?mod=detail-kunjungan" class="btn btn-danger btn-sm">detail</a></td>
						</tr>
						<tr>
							<td>5</td><td>13/01/2015 09:45:10 AM</td><td>Shane Walsh</td><td>Sasha</td><td><span class="label label-danger">kirim barang</span> <span class="label label-warning">order</span></td><td><a href="?mod=detail-kunjungan" class="btn btn-danger btn-sm">detail</a></td>
						</tr>
						<tr>
							<td>6</td><td>13/01/2015 12:10:10 AM</td><td>Glen Rhee</td><td>Maggie Greene</td><td><span class="label label-success">kunjungan</span> <span class="label label-danger">kirim barang</span> <span class="label label-warning">order</span></td><td><a href="?mod=detail-kunjungan" class="btn btn-danger btn-sm">detail</a></td>
						</tr>
					</tbody>
				</table>
				<p class="text-muted small visible-print">Dicetak oleh User, pada 3 April 2015 pukul. 10:30:21</p>
				<?php
			}
			?>
		</div>
	</div>
</div>

<div class="modal fade" id="modal_kriteria">
	<div class="modal-dialog modal-ryan">
		<div class="modal-content">
			<div class="modal-header custom orange">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Kriteria</h4>
			</div>
			<div class="modal-body">
				<form action="#" class="form-horizontal" method="POST">
					<div class="form-group">
						<div class="col-sm-6">
							<input type="text" name="tgl_awal" id="inputTgl_awal" class="form-control datepicker" placeholder="tgl awal">
						</div>
						<div class="col-sm-6">
							<input type="text" name="tgl_akhir" id="inputTgl_akhir" class="form-control datepicker" placeholder="tgl akhir">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<select name="spv" id="spv" class="form-control">
								<option value="0">Pilih Supervisor</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<select name="cust" id="inputCust" class="form-control">
								<option value="0">Pilih customer</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12">
							<select name="job" id="inputJob" class="form-control">
								<option value="">pilih kegiatan/job</option>
							</select>
						</div>
					</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-danger btn-orange">cari Sesuai Kriteria Diatas <i class="fa fa-chevron-circle-right"></i></button>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- skrip untuk table.js -->
<script>
$(document).ready( function () {
    $('#tabel-laporan').DataTable();
    
} );
</script>