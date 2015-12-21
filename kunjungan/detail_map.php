<?php

if( isset($_SESSION['media-data']) && isset($_REQUEST['data']) && $_REQUEST['data']<>"" ){

	include 'class.kunjungan.php';
	
	$data = new kunjungan();

	if( $rs = $data->cari_visit($_REQUEST['data']) ){

?>

	<div class="container">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="panel-detail-kunjungan">
					<form action="#" method="post" id="frm-back">
						<input type="hidden" name="no_spa" id="no_spa" value="">
						<input type="hidden" name="tgl_awal" id="tgl_awal" value="">
						<input type="hidden" name="tgl_akhir" id="tgl_akhir" value="">
						<input type="hidden" name="spv" id="spv" value="">
						<input type="hidden" name="cust" id="cust" value="">
						<input type="hidden" name="job" id="job" value="">
						<input type="hidden" name="tipe" id="tipe" value="">
					</form>
					<div class="head-detail-kunjungan">
						<div class="row">
							<div class="col-md-4 pull-left">
							<?php
							if ($_REQUEST['ftipe'] == "rekap") {
							?>
								<h4><a href="#" id="btn-back" data-link="<?php echo e_url('kunjungan/laporan_kunjungan.php'); ?>" data-hash="laporan-kunjungan" data-awal="<?php echo $_REQUEST['fawal'] ?>" data-akhir="<?php echo $_REQUEST['fakhir'] ?>" data-spv="<?php echo $_REQUEST['fspv'] ?>" data-cust="<?php echo $_REQUEST['fcust'] ?>" data-job="<?php echo $_REQUEST['fjob'] ?>"><i class="fa fa-chevron-left"></i></a></h4>
							<?php
							} else {
							?>
								<h4><a href="#" id="btn-back" data-link="<?php echo e_url('kunjungan/laporan_harian.php'); ?>" data-hash="laporan-harian" data-awal="<?php echo $_REQUEST['fawal'] ?>" data-akhir="" data-spv="<?php echo $_REQUEST['fspv'] ?>" data-cust="" data-job=""><i class="fa fa-chevron-left"></i></a></h4>
							<?php
							}
							?>
								<a class="text-danger" onclick="ngePrint();"><i class="fa fa-print"></i> print</a>
							</div>
							<div class="col-md-4 text-center">
								<h4>Detail Kunjungan</h4>
							</div>
						</div>
						
					</div>
					<div class="peta-kunjungan">
						<div id="map-canvas"></div>
					</div>
					<div class="body-detail-kunjungan">
						<div class="text-center">
							<h5>Waktu Kunjungan : <?php echo date("d/m/Y",strtotime($rs['hari']) ); ?>, pukul. <?php echo $rs['jam']; ?> </h5>
							<h5 class='alamat'>  </h5>
							<p class="text-muted">Supervisor : <?php echo $rs['spv'];  ?> | Customer : <?php echo $rs['nama']; ?></p>

						<?php  

							if( $job = $data->detail_job($rs['id']) ){
								while ( $d = $job->fetch_assoc() ) {
									echo "<span class='label label-default'>".$d['nama']."</span>";
								}
							}

						?>
						<!--
							<span class="label label-default">kunjungan</span> <span class="label label-danger">kirim barang</span> <span class="label label-warning">order</span>

						-->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br><br><br>
	
	<!-- Skrip tampil google maps -->
	<script src="https://maps.googleapis.com/maps/api/js"></script>
	    <script>

	        function initialize() {
	  var myLatlng = new google.maps.LatLng( <?php echo $rs['latitude']." ,".$rs['longitude']; ?> );
	  var mapOptions = {
	    zoom: 16,
	    center: myLatlng
	  }
	  var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

	  var marker = new google.maps.Marker({
	      position: myLatlng,
	      map: map,
	      title: '<?php echo $rs['nama']; ?>'
	  });
	}
	      
	      google.maps.event.addDomListener(window, 'load', initialize);


/*-- Reverses GeoCode--*/

	      var geocoder;

			geocoder = new google.maps.Geocoder();
			var latlng = new google.maps.LatLng(<?php echo $rs['latitude']." ,".$rs['longitude']; ?>);
			//alert("Else loop" + latlng);
			geocoder.geocode({
			    'latLng': latlng
			}, function(results, status) {
			    //alert("Else loop1");
			    if (status == google.maps.GeocoderStatus.OK) {
			        if (results[0]) {
			            var add = results[0].formatted_address;
			            $('.alamat').html("Alamat kunjungan* : " +add);
			            //alert("Full address is: " + add);
			        } else {
			            alert("address not found");

			        }
			    } else {
			        //document.getElementById("location").innerHTML="Geocoder failed due to: " + status;
			        //alert("Geocoder failed due to: " + status);
			    }
			});
			
			$('#btn-back').on('click', function(event){
				event.preventDefault();
				$('#frm-back').find('#no_spa').val( $(this).data('link') );
				$('#frm-back').find('#tgl_awal').val( $(this).data('awal') );
				$('#frm-back').find('#tgl_akhir').val( $(this).data('akhir') );
				$('#frm-back').find('#spv').val( $(this).data('spv') );
				$('#frm-back').find('#cust').val( $(this).data('cust') );
				$('#frm-back').find('#job').val( $(this).data('job') );

				$('#frm-back').submit();
			});
	    </script>

<?php
	}else{
		echo "<h1> Data tidak ditemukan, silahkan tekan F5. </h1>";
	}

}

?>