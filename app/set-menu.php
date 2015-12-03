<?php
if( isset($_SESSION['media-data']) && $_SESSION['media-data']<>"" && isset($_REQUEST['id']) && $_REQUEST['id']<>"" && isset($_REQUEST['nama']) && $_REQUEST['nama']<>""  ){


	require './app/class.user.php';
	$data = new user();


?>

<div class="container">
	<div class="row">
		<div class="col-md-3">
			<a class="btn btn-danger btn-orange link-menu" href='#' data-link="<?php echo e_url('./app/user.php'); ?>" data-hash='".$rs2['title']."' >   <i class="fa fa-chevron-left"></i> back</a>
			
		</div>
		<div class="col-md-6">
			<h4 class="text-center"><?php echo $_REQUEST['nama'] ; ?></h4>
		</div>
		<div class="col-md-3 pull-right">
			<a class="btn btn-danger btn-orange pull-right btn-simpan"  href='#'>Simpan <i class="fa fa-menu"></i> </a>
		</div>
	</div>
	<hr>
	
<div class="row">
	<div class="col-md-12">
		<h5>Menu Aktif</h5>
		<form action="#" method="POST" id="form-menu" name="form-menu" >
			<input type="hidden" id="aksi" name="aksi" value="<?php echo e_url('./app/set-menu-simpan.php'); ?>">
			
			<input type="hidden" id="id" name="id" value="<?php echo $_REQUEST['id']; ?>">

			<table class="table table-mod">
				<thead>
					<tr>
						<th>Nama Menu</th><th>lvl</th><th></th>
					</tr>
				</thead>
				<tbody>
					<?php
						if ($res1 = $data->runQuery("SELECT id, icon, nama FROM akses_menu WHERE induk = '0'")) {
							while ($rs1 = $res1->fetch_array()) {
								if ($resCek1 = $data->runQuery("SELECT COUNT(id) FROM akses WHERE id_user = '".d_code($_REQUEST['id'])."' AND id_menu = '".$rs1['id']."'")) {
									$rsCek1 = $resCek1->fetch_array();
									$checked1 = ($rsCek1[0] == 0) ? "":"checked";
								}
					?>
								<tr>
									<td> <i class="<?php echo $rs1['icon']; ?>"></i> <?php echo $rs1['nama']; ?></td><td>1</td><td><input type="checkbox" id="menu" name="menu[]" value="<?php  echo $rs1['id']; ?>" <?php echo $checked1 ?>></td>
								</tr>
					<?php
								if ($res2 = $data->runQuery("SELECT id, icon, nama FROM akses_menu WHERE induk = '".$rs1['id']."'")) {
									while ($rs2 = $res2->fetch_array()) {
										if ($resCek2 = $data->runQuery("SELECT COUNT(id) FROM akses WHERE id_user = '".d_code($_REQUEST['id'])."' AND id_menu = '".$rs2['id']."'")) {
											$rsCek2 = $resCek2->fetch_array();
											$checked2 = ($rsCek2[0] == 0) ? "":"checked";
										}
					?>
										<tr>
											<td>-- <i class="<?php echo $rs1['icon']; ?>"></i> <?php echo $rs2['nama']; ?></td><td> -- 2</td><td><input type="checkbox" id="menu" name="menu[]" value="<?php  echo $rs2['id']; ?>" <?php echo $checked2 ?>></td>
										</tr>	
					<?php
									}
								}
							}
						}
					?>
				</tbody>
			</table>

		</form>


	</div>
</div>
</div>

<script>
	
$(document).ready(function(){

	function reloading(){
		$('#isi_halaman').append("<div class='pull-right loading'><h1><i class='fa fa-refresh fa-spin'></i></h1></div>");


		$.ajax({
        	url : "./",
            method: "POST",
            cache: false,
            data: {"mod" : "<?php echo e_url('app/set-menu.php'); ?>", "title" : "user" , "id" : "<?php echo $_REQUEST['id']; ?>", "nama" : "<?php echo $_REQUEST['nama']; ?>" },
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


	$('.btn-simpan').on('click', function(ev){
	    ev.preventDefault();
	    var ini = $('#form-menu').serialize();

	        $('.btn-simpan').addClass('disabled').html('Processing... <i class="fa fa-spinner fa-pulse"></i>');
	        
			$.ajax({
	            url: "./",
	            method: "POST",
	            cache: false,
	            data: ini,
	            success: function(eve){
	            	//$('.container').after(eve);
	            	alert(eve);

	            	reloading();

	            },
	            error: function(){
	            	alert('Gagal terkoneksi dengan server..');
	          		$('.btn-simpan').html('Simpan <i class="fa fa-menu"></i>').removeClass('disabled');
	            }

	         });

    	});


});


</script>


<?php
}

?>

