<div class="container">
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<div class="panel-profile">
				<div class="profile-header">
					<i class="fa fa-edit"></i> Edit karyawan
				</div>
				<div class="profile-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="inputUsername" class="col-sm-4 control-label">Nama</label>
							<div class="col-sm-8">
								<div class="form-control input-min">Nama Karyawan</div>
							</div>
						</div>
					
						<div class="form-group">
							<label for="inputPassword" class="col-sm-4 control-label">Jabatan</label>
							<div class="col-sm-8">
								<select name="jabatan" id="inputJabatan" class="form-control" required="required">
									<option value="0">-- pilih jabatan --</option>
									<option value="1">Area Sales Manager</option>
									<option value="2">Promosi</option>
									<option value="3">Administrasi</option>
									<option value="4">Supervisor</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="inputPassword" class="col-sm-4 control-label">Area</label>
							<div class="col-sm-8">
								<select name="penempatan" id="inputPenempatan" class="form-control" required="required">
									<option value="0">-- area penempatan --</option>
									<option value="1">Semarang</option>
									<option value="2">Jakarta</option>
									<option value="3">Banyumas</option>
									<option value="4">Madiun</option>
									<option value="5">Magelang</option>
									<option value="6">Pati</option>
									<option value="7">Solo</option>
									<option value="8">Surabaya</option>
									<option value="9">Purwokerto</option>
									<option value="10">Balikpapan</option>
									<option value="11">Pangkalan Bun</option>
									<option value="12">Yogyakarta</option>
									<option value="13">Salatiga</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-6">
								<a href="?mod=karyawan" class="btn btn-block btn-default">Cancel</a>
							</div>
							<div class="col-sm-6">
								<button class="btn btn-block btn-danger btn-orange">Edit Data</button>
							</div>
						</div>
						
						<br>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>