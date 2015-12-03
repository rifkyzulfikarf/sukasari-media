<div class="container">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div class="panel-detail-kunjungan">
				<div class="head-detail-kunjungan">
					<div class="row">
						<div class="col-md-4 pull-left">
							<a class="text-danger" onclick="ngePrint();"><i class="fa fa-print"></i> print</a>
						</div>
						<div class="col-md-4 text-center">
							<h4>Detail Kunjungan</h4>
						</div>
						<div class="col-md-4 pull-right">
							<h4><a href="#" class="link-menu" data-link="<?php echo e_url('kunjungan/laporan_kunjungan.php'); ?>" data-hash="laporan-kunjungan"><i class="fa fa-search pull-right text-danger"></i></a></h4>
						</div>
					</div>
					
				</div>
				<div class="peta-kunjungan">
					<div id="map-canvas"></div>
				</div>
				<div class="body-detail-kunjungan">
					<div class="text-center">
						<h5>Waktu Kunjungan : 10/01/2015, pukul. 10:10:10 AM</h5>
						<p class="text-muted">Supervisor : Rick Grimmes | Customer : Daryl Dixon</p>
						<span class="label label-success">kunjungan</span> <span class="label label-danger">kirim barang</span> <span class="label label-warning">order</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<br><br><br>
<!-- modal cari kriteria -->
<div class="modal fade" id="modal_kriteria">
	<div class="modal-dialog modal-ryan">
		<div class="modal-content">
			<div class="modal-header custom orange">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Kriteria</h4>
			</div>
			<div class="modal-body">
				<form action="?mod=laporan-kunjungan" class="form-horizontal" method="POST">
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

<!-- Skrip tampil google maps -->
<script src="https://maps.googleapis.com/maps/api/js"></script>
    <script>

        function initialize() {
  var myLatlng = new google.maps.LatLng(44.5403, -78.5463);
  var mapOptions = {
    zoom: 16,
    center: myLatlng
  }
  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: 'Hello World!'
  });
}
      
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>