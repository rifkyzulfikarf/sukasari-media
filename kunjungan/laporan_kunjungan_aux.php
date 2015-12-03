<?php
if( isset($_POST['apa']) && $_POST['apa']<>"" ){



	switch ($_POST['apa']) {
		case 'laporan_kunjungan':
			?>
				<div class="pull-right">
					<button class="btn btn-default btn-sm" onclick="ngePrint();"><i class="fa fa-print"></i> print</button>
				</div>
				<form action="#detail-kunjungan" method="post" id="detail_kunjungan">
					<input type="hidden" name="no_spa" id="no_spa" value="">
					<input type="hidden" name="data" id="data" value="">

				</form>
				<br><br>
				<table class="table table-hover table-striped table-mod" id="tabel-laporan">
					<thead>
						<tr>
							<th>#</th><th>Waktu Kunjungan</th><th>Supervisor</th><th>Customer</th><th>Kegiatan/Job</th><th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td><td>12/01/2015 08:10:10 AM</td><td>Rick Grimmes</td><td>Daryl Dixon</td><td><span class="label label-success">kunjungan</span> <span class="label label-danger">kirim barang</span> <span class="label label-warning">order</span></td><td><a href="#" data-link="<?php echo e_url('kunjungan/detail_kunjungan.php'); ?>" class="btn btn-danger btn-sm detail_kunjungan ">detail</a></td>
						</tr>
						<tr>
							<td>2</td><td>12/01/2015 09:45:10 AM</td><td>Harsel Greene</td><td>Carol Peletier</td><td><span class="label label-success">kunjungan</span></td><td><a href="#" data-link="<?php echo e_url('kunjungan/detail_kunjungan.php'); ?>" class="btn btn-danger btn-sm detail_kunjungan ">detail</a></td>
						</tr>
						<tr>
							<td>3</td><td>12/01/2015 12:10:10 AM</td><td>Glen Rhee</td><td>Maggie Greene</td><td><span class="label label-success">kunjungan</span> <span class="label label-danger">kirim barang</span> <span class="label label-warning">order</span></td><td><a href="#" data-link="<?php echo e_url('kunjungan/detail_kunjungan.php'); ?>" class="btn btn-danger btn-sm detail_kunjungan ">detail</a></td>
						</tr>
						<tr>
							<td>4</td><td>13/01/2015 10:10:10 AM</td><td>Michonne</td><td>Dale Horvath</td><td><span class="label label-success">kunjungan</span> <span class="label label-danger">kirim barang</span></td><td><a href="./?no_spa=<?php echo e_url('kunjungan/detail_kunjungan.php') ;?>"&data=x class="btn btn-danger btn-sm detail_kunjungan ">detail</a></td>
						</tr>
						<tr>
							<td>5</td><td>13/01/2015 09:45:10 AM</td><td>Shane Walsh</td><td>Sasha</td><td><span class="label label-danger">kirim barang</span> <span class="label label-warning">order</span></td><td><a href="#" data-link="<?php echo e_url('kunjungan/detail_kunjungan.php'); ?>" class="btn btn-danger btn-sm detail_kunjungan ">detail</a></td>
						</tr>
						<tr>
							<td>6</td><td>13/01/2015 12:10:10 AM</td><td>Glen Rhee</td><td>Maggie Greene</td><td><span class="label label-success">kunjungan</span> <span class="label label-danger">kirim barang</span> <span class="label label-warning">order</span></td><td><a href="#" data-link="<?php echo e_url('kunjungan/detail_kunjungan.php'); ?>" class="btn btn-danger btn-sm detail_kunjungan ">detail</a></td>
						</tr>
					</tbody>
				</table>
				<p class="text-muted small visible-print">Dicetak oleh User, pada 3 April 2015 pukul. 10:30:21</p>

				<script>

				    $('.detail_kunjungan').on('click', function(ev){
				    	ev.preventDefault();

				    	$('#detail_kunjungan').find('#no_spa').val( $(this).data('link') );
				    	$('#detail_kunjungan').find('#data').val( $(this).data('data') );
				    	$('#detail_kunjungan').submit();

				    });

				</script>
			


			<?php
			break;

		case 'laporan_harian':

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

			break;
		
		default:
			# code...
			break;
	}



}
?>