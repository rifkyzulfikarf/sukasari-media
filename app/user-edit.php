<div class="container">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<div class="panel-profile">
				<div class="profile-header">
					<i class="fa fa-lock"></i> Ubah Password
				</div>
				<div class="profile-body">
					<div class="form-horizontal">

						<form action="#" method="POST" id="edit-profil" name="edit-profil">
							
							<input type="hidden" name="aksi" id="aksi" value="<?php echo e_url('./app/user-edit-simpan.php'); ?>">
							
							<input type="hidden" id="id" name="id" value="<?php echo (isset($_REQUEST['id']) ? d_code($_REQUEST['id']) : "" ); ?>">
							
							<div class="form-group">
								<label for="inputUsername" class="col-sm-12 text-center"><?php echo (isset($_REQUEST['nama']) ? $_REQUEST['nama'] : "" );  ?></label>
								
							</div>
							<div class="form-group">
								<label for="inputUsername" class="col-sm-4 control-label">Username</label>
								<div class="col-sm-8">
									<input type="text" name="user" id="inputPassword" class="form-control input-min" placeholder="Username Baru">
								</div>
							</div>
						
							<div class="form-group">
								<label for="inputPassword" class="col-sm-4 control-label">Password</label>
								<div class="col-sm-8">
									<input type="password" name="password" id="inputPassword" class="form-control input-min" placeholder="Password baru">
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword" class="col-sm-4 control-label"></label>
								<div class="col-sm-8">
									<input type="password" name="password2" id="inputPassword" class="form-control input-min" placeholder="Ulangi Password baru">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6">
									<a href="?" class="btn btn-block btn-default">Cancel</a>
								</div>
								<div class="col-sm-6">
									<button class="btn btn-block btn-danger btn-orange btn-simpan">Ganti Password</button>
								</div>
							</div>

						</form>

						<br>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$('.btn-simpan').click(function(ev){
		ev.preventDefault();
		var ini = $('#edit-profil').serialize();

		$.ajax({
            url: "./",
            method: "POST",
            cache: false,
            data: ini,
            success: function(event){

               $('#edit-profil').after(event);
               window.location='./?no_spa=<?php echo e_url("/app/user.php"); ?>';

            },
            error: function(){
               alert('Gagal terkoneksi dengan server..');
          
            }

         });

	});


</script>