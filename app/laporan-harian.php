<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<h4 class="text-center">Laporan Harian Kunjungan Supervisor</h4>
		</div>
		<div class="col-md-3">
			<button data-toggle="modal" href='#modal_kriteria' class="btn btn-danger btn-sm btn-orange pull-right">Kriteria</button>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-sm-12">
			<?php 
			if($_POST[tgl]=='')
			{
				?>
				<div class="text-center text-muted">
				<p style="font-size:120px;"><i class="fa fa-question-circle"></i></p>
				<p>silakan isi kriteria laporan dengan meng-klik tombol kriteria</p>
				</div>
				<?php
			}
			else
			{
				?>
				<div class="pull-right">
					<button class="btn btn-default btn-sm" onclick="ngePrint();"><i class="fa fa-print"></i> print</button>
				</div>
				<table class="table-harian">
					<tr>
						<td><b>Hari</b></td><td>: Kamis</td>
					</tr>
					<tr>
						<td><b>Tanggal</b></td><td>: 12 Maret 2015</td>
					</tr>
					<tr>
						<td><b>Nama SPV</b></td><td>: Rick Grimes</td>
					</tr>
					<tr>
						<td><b>Area</b></td><td>: Semarang</td>
					</tr>
				</table>
				<br>
				<table class="table table-hover table-striped table-mod">
					<thead>
						<tr>
							<th>No.Register</th><th>Pelanggan</th><th>Alamat</th><th>Pasar</th><th>Waktu</th><th class="text-center">Tindakan</th><th>Nama Lokasi GPS</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>02.00507</td><td>Carrol Peletier, bu</td><td class="text-center">Pasar Babadan</td><td class="text-center">Ungaran</td><td class="text-center">08:10</td><td class="text-center">Order</td><td class="text-center">Ungaran</td>
						</tr>
						<tr>
							<td>02.00508</td><td>Daryl Dixon, pak</td><td class="text-center">Pasar Babadan</td><td class="text-center">Ungaran</td><td class="text-center">08:30</td><td class="text-center">Order, kirim barang</td><td class="text-center">Ungaran</td>
						</tr>
						<tr>
							<td>02.00509</td><td>Glen Rhee, pak</td><td class="text-center">Pasar Babadan</td><td class="text-center">Ungaran</td><td class="text-center">09:30</td><td class="text-center">Order, kirim barang</td><td class="text-center">Ungaran</td>
						</tr>
						<tr>
							<td>02.00510</td><td>Maggie Grenee, bu</td><td class="text-center">Pasar Babadan</td><td class="text-center">Ungaran</td><td class="text-center">09:55</td><td class="text-center">Order, kirim barang</td><td class="text-center">Ungaran</td>
						</tr>
						<tr>
							<td>02.00516</td><td>Sasha, bu</td><td class="text-center">Pasar Banyumanik</td><td class="text-center">Banyumanik</td><td class="text-center">13:30</td><td class="text-center">Order, kirim barang</td><td class="text-center">Banyumanik</td>
						</tr>
						<tr>
							<td>02.00519</td><td>Rosita Espinoza, bu</td><td class="text-center">Pasar Banyumanik</td><td class="text-center">Banyumanik</td><td class="text-center">13:40</td><td class="text-center">kirim barang</td><td class="text-center">Banyumanik</td>
						</tr>
						<tr>
							<td>02.00521</td><td>Michonne, bu</td><td class="text-center">Pasar Banyumanik</td><td class="text-center">Banyumanik</td><td class="text-center">13:50</td><td class="text-center">kirim barang</td><td class="text-center">Banyumanik</td>
						</tr>
						<tr>
							<td>02.00522</td><td>Tarra Chambler, bu</td><td class="text-center">Pasar Banyumanik</td><td class="text-center">Banyumanik</td><td class="text-center">14:00</td><td class="text-center">kirim barang</td><td class="text-center">Banyumanik</td>
						</tr>
						<tr>
							<td>02.00523</td><td>Beth Grenee, bu</td><td class="text-center">Pasar Banyumanik</td><td class="text-center">Banyumanik</td><td class="text-center">14:30</td><td class="text-center">kirim barang, order, kunjungan</td><td class="text-center">Banyumanik</td>
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

<!-- modal kriteria -->
<div class="modal fade" id="modal_kriteria">
	<div class="modal-dialog modal-ryan">
		<div class="modal-content">
			<div class="modal-header custom orange">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Kriteria Laporan</h4>
			</div>
			<div class="modal-body">
				<form action="#" method="POST">
					<input type="text" name="tgl" id="inputTgl" class="form-control datepicker" placeholder="Tanggal">
					<br>
					<select name="supervisor" id="inputSupervisor" class="form-control">
						<option value="0">-- Supervisor --</option>
						<option value="1">Rick Grimes</option>
						<option value="1">Hersel Grenee</option>
						<option value="2">Glen Rhee</option>

					</select>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-danger btn-orange">cari sesuai kriteria diatas <i class="fa fa-chevron-circle-right"></i></button>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- tutup modal kriteria -->