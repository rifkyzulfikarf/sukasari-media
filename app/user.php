<?php

require './app/class.user.php';
$data = new user();


?>

<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<h4 class="text-center">MANAGE USER</h4>
		</div>
		<div class="col-md-3">
			<a class="btn btn-danger btn-orange pull-right" data-toggle="modal" href='#add_user_modal'>Add User</a>
		</div>
	</div>
	<hr>
	<div class="row">
<?php

if( $daftar = $data->list_user() ){
	while( $rs = $daftar->fetch_assoc() ){

?>

		<div class="col-md-3">
			<div class="well">
				<div class="row">
					<div class="col-md-12 text-center">
						<?php 
							echo $rs['nama']; 
							echo (d_code($rs['status'])=="2" ? "<p><small>Administrator</small> <a href='./?no_spa=".e_url('./app/as-admin.php')."&data=".e_code($rs['id'])."&status=".e_code('1')."'><i class='fa fa-ban'></i> </a></p>" : "<p><a href='./?no_spa=".e_url('./app/as-admin.php')."&data=".e_code($rs['id'])."&status=".e_code('2')."'><i class='fa fa-bolt'></i> <small>Jadikan Administrator</small></a></p>" );
						?>

					<hr>
					<a href="./?no_spa=<?php echo e_url('app/user-edit.php'); ?>&id=<?php echo e_code($rs['id']); ?>&nama=<?php echo $rs['nama']; ?>" class="btn btn-success btn-sm">Edit</a> <a href="./?no_spa=<?php echo e_url("app/set-menu.php") ?>&id=<?php echo e_code($rs['id']); ?>&nama=<?php echo $rs['nama']; ?>" data-hash="user-menu" class="btn btn-danger btn-orange btn-sm link-menu">Menu</a> <button class="btn btn-danger btn-sm non-aktif" data-id="<?php echo e_code($rs['id']); ?>" >Hapus</button>
					</div>
				</div>
				
			</div>
		</div>

<?php

	}
}


?>


	<!--
		<div class="col-md-3">
			<div class="well">
				<div class="row">
					<div class="col-md-12 text-center">
						Nama User
					<hr>
					<a href="" class="btn btn-success btn-sm">Edit</a> <a href="#" data-link="" data-hash="user-menu" class="btn btn-danger btn-orange btn-sm link-menu">Menu</a> <button class="btn btn-danger btn-sm" onclick="konfirmasiNonaktif();">Non-aktif</button>
					</div>
				</div>
				
			</div>
		</div>
		<div class="col-md-3">
			<div class="well">
				<div class="row">
					<div class="col-md-12 text-center">
						Nama User
					<hr>
					<a href="" class="btn btn-success btn-sm">Edit</a> <a href="" class="btn btn-danger btn-orange btn-sm">Menu</a> <button class="btn btn-danger btn-sm" onclick="konfirmasiNonaktif();">Non-aktif</button>
					</div>
				</div>
				
			</div>
		</div>
		<div class="col-md-3">
			<div class="well">
				<div class="row">
					<div class="col-md-12 text-center">
						Nama User
					<hr>
					<a href="" class="btn btn-success btn-sm">Edit</a> <a href="" class="btn btn-danger btn-orange btn-sm">Menu</a> <button class="btn btn-danger btn-sm" onclick="konfirmasiNonaktif();">Non-aktif</button>
					</div>
				</div>
				
			</div>
		</div>
		<div class="col-md-3">
			<div class="well">
				<div class="row">
					<div class="col-md-12 text-center">
						Nama User
					<hr>
					<a href="" class="btn btn-success btn-sm">Edit</a> <a href="" class="btn btn-danger btn-orange btn-sm">Menu</a> <button class="btn btn-danger btn-sm" onclick="konfirmasiNonaktif();">Non-aktif</button>
					</div>
				</div>
				
			</div>
		</div>
		<div class="col-md-3">
			<div class="well">
				<div class="row">
					<div class="col-md-12 text-center">
						Nama User
					<hr>
					<a href="" class="btn btn-success btn-sm">Edit</a> <a href="" class="btn btn-danger btn-orange btn-sm">Menu</a> <button class="btn btn-danger btn-sm" onclick="konfirmasiNonaktif();">Non-aktif</button>
					</div>
				</div>
				
			</div>
		</div>
		<div class="col-md-3">
			<div class="well">
				<div class="row">
					<div class="col-md-12 text-center">
						Nama User
					<hr>
					<a href="" class="btn btn-success btn-sm">Edit</a> <a href="" class="btn btn-danger btn-orange btn-sm">Menu</a> <button class="btn btn-danger btn-sm" onclick="konfirmasiNonaktif();">Non-aktif</button>
					</div>
				</div>
				
			</div>
		</div>
		<div class="col-md-3">
			<div class="well">
				<div class="row">
					<div class="col-md-12 text-center">
						Nama User
					<hr>
					<a href="" class="btn btn-success btn-sm">Edit</a> <a href="" class="btn btn-danger btn-orange btn-sm">Menu</a> <button class="btn btn-danger btn-sm" onclick="konfirmasiNonaktif();">Non-aktif</button>
					</div>
				</div>
				
			</div>
		</div>
		<div class="col-md-3">
			<div class="well">
				<div class="row">
					<div class="col-md-12 text-center">
						Nama User
					<hr>
					<a href="" class="btn btn-success btn-sm">Edit</a> <a href="" class="btn btn-danger btn-orange btn-sm">Menu</a> <button class="btn btn-danger btn-sm" onclick="konfirmasiNonaktif();">Non-aktif</button>
					</div>
				</div>
				
			</div>
		</div>
		-->
	</div>
</div>


<!-- modul add user -->
		<div class="modal fade" id="add_user_modal">

			<form id="form-add-user" action="#" method="POST" >
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header custom orange">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Add user</h4>
						</div>
						<div class="modal-body">

							<input type="hidden" id="aksi" name="aksi" value="<?php echo e_url('./app/user-add.php'); ?>">
								
							<div class="form-group">
								<select name="karyawan" id="karyawan" class="form-control chosen" required>
								<?php
								if( $karyawan = $data->list_karyawan_belum_ada_user() ){
									while( $rs = $karyawan->fetch_assoc() ){
										echo "<option value='".$rs['id']."' >".$rs['nama']." - ".$rs['area']."</option>";
									}
								}

								?>
									
								</select>			
							</div>

							<div class="form-group">
								<input type="text" name="username" id="inputUsername" class="form-control input-min" placeholder="Username" required>	
							</div>

							<div class="form-group">
								<input type="password" name="password" id="inputpassword" class="form-control input-min" placeholder="password" required>	
							</div>
							
							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
							<a href="#" type="button" class="btn btn-danger btn-orange btn-simpan">Simpan <i class="fa fa-send"></i></a>
						</div>

					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->

			</form>
		</div><!-- /.modal -->

<script>
	$(document).ready(function() {

		function reloading(){
			$('#isi_halaman').append("<div class='pull-right loading'><h1><i class='fa fa-refresh fa-spin'></i></h1></div>");


			$.ajax({
	        	url : "./",
	            method: "POST",
	            cache: false,
	            data: {"mod" : "<?php echo e_url('app/user.php'); ?>", "title" : "user" },
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

		$('.non-aktif').on('click', function(ev){
			ev.preventDefault();
			
			$(this).html('Hapus <i class="fa fa-spin fa-spinner"></i>').addClass('disabled');

			$.ajax({
	            url: "./",
	            method: "POST",
	            cache: false,
	            data: { "aksi" : "<?php echo e_url('./app/user-hapus.php'); ?>", "data" : $(this).data('id') },
	            success: function(eve){

	            	alert(eve);
	            	reloading();

	            },
	            error: function(){
	            	alert('Gagal terkoneksi dengan server..');
	          		$('.btn-simpan').html('Simpan <i class="fa fa-send"></i>').removeClass('disabled');
	            }

	         });



		});

		$('.btn-simpan').on('click', function(ev){
	    	ev.preventDefault();
	        var ini = $('#form-add-user').serialize();

	        $('.btn-simpan').addClass('disabled').html('Processing... <i class="fa fa-spinner fa-pulse"></i>');
	        
			$.ajax({
	            url: "./",
	            method: "POST",
	            cache: false,
	            data: ini,
	            success: function(eve){

	            	$('.container').after(eve);

	            },
	            error: function(){
	            	alert('Gagal terkoneksi dengan server..');
	          		$('.btn-simpan').html('Simpan <i class="fa fa-send"></i>').removeClass('disabled');
	            }

	         });

    	});


	});



</script>
