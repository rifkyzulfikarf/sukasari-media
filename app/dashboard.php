<?php
	include './do/class.do.php';
	$data = new do_do();
	
	$bulan = date("m");
	$tahun = date("Y");
	switch ($bulan) {
		case "01": $namaBulan = "Januari";break;
		case "02": $namaBulan = "Februari";break;
		case "03": $namaBulan = "Maret";break;
		case "04": $namaBulan = "April";break;
		case "05": $namaBulan = "Mei";break;
		case "06": $namaBulan = "Juni";break;
		case "07": $namaBulan = "Juli";break;
		case "08": $namaBulan = "Agustus";break;
		case "09": $namaBulan = "September";break;
		case "10": $namaBulan = "Oktober";break;
		case "11": $namaBulan = "November";break;
		case "12": $namaBulan = "Desember";break;
	}
	
	$banyakHari = cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun);
	
	for ($i=1; $i<=$banyakHari; $i++) {
		$hari[] = "[$i]";
		
		$x = (strlen($i) == 1?"0".$i:$i);
		
		$tgl = $tahun."-".$bulan."-".$x;
		if ($q = $data->runQuery("SELECT COUNT(id) AS jumlah FROM do WHERE tgl_do = '$tgl'")) {
			$rs = $q->fetch_array();
			$jumlahDO[] = $rs['jumlah'];
		}
		
	}
	
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<script type="text/javascript">
$(function () {
    $('#container2').highcharts({
        title: {
            text: 'Data Order',
            x: -20 //center
        },
        subtitle: {
            text: 'Bulan <?php echo $namaBulan." ".$tahun ?>',
            x: -20
        },
        xAxis: {
            categories: [<?php echo join($hari, ',') ?>]
        },
        yAxis: {
            title: {
                text: 'Jumlah'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#FF9800'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'Order',
            color: "#ff8800",
            data: [<?php echo join($jumlahDO, ',') ?>]
        }]
    });
});
</script>

		<div id="container2" class="box" style="min-width: 310px; height: 300px; margin: 0 auto"></div>
		</div>
	</div>
	
	<?php
		$tglSekarang = date("Y-m-d");
		if ($result = $data->runQuery("SELECT SUM(`do_detail`.`jml`) FROM `do_detail` INNER JOIN `do` ON (`do_detail`.`id_do` = `do`.`id`) WHERE `do`.`tgl_do` = '$tglSekarang'")) {
			$rs = $result->fetch_array();
			$itemDOBaru = ($rs[0]==null)?0:$rs[0];
		}
		
		if ($result = $data->runQuery("SELECT SUM(`do_detail`.`jml`) FROM `do_detail` INNER JOIN `do` ON (`do_detail`.`id_do` = `do`.`id`) WHERE `do`.`tgl_do` = '$tglSekarang' AND `do`.`tgl_acc` <> '0000-00-00'")) {
			$rs = $result->fetch_array();
			$itemDOAcc = ($rs[0]==null)?0:$rs[0];
		}
		
		if ($result = $data->runQuery("SELECT SUM(`realisasi_po`.`jumlah`) FROM `realisasi_po` WHERE `realisasi_po`.`tgl` = '$tglSekarang'")) {
			$rs = $result->fetch_array();
			$itemRealisasi = ($rs[0]==null)?0:$rs[0];
		}
	?>
				<div class="row">
					<div class="col-md-4 wow bounceInLeft">
						<div class="box">
							<div class="row">
								<div class="col-md-4">
									<div class="text-center box_kiri merah">
										<center><?php echo $itemDOBaru ?></center>
									</div>
								</div>
								<div class="col-md-8">
									<div class="box_kanan">
										<a href="#">Item DO Baru Hari Ini <i class="fa fa-asterisk text-danger"></i></a>
									</div>	
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 wow bounceInLeft">
						<div class="box">
							<div class="row">
								<div class="col-md-4">
									<div class="text-center box_kiri biru">
										<center><?php echo $itemDOAcc ?></center>
									</div>
								</div>
								<div class="col-md-8">
									<div class="box_kanan">
										<a href="#">Item DO Acc Hari Ini <i class="fa fa-cogs text-info"></i></a>
									</div>	
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 wow bounceInLeft">
						<div class="box">
							<div class="row">
								<div class="col-md-4">
									<div class="text-center box_kiri hijau">
										<center><?php echo $itemRealisasi ?></center>
									</div>
								</div>
								<div class="col-md-8">
									<div class="box_kanan">
										<a href="#">Item Realisasi Hari Ini <i class="fa fa-check-circle text-success"></i></a>
									</div>	
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>