<div class="container">
	<div class="row">
		<div class="col-md-3">
			<a class="btn btn-danger btn-orange" href='?mod=user'><i class="fa fa-chevron-left"></i> back</a>
		</div>
		<div class="col-md-6">
			<h4 class="text-center">Nama User</h4>
		</div>
		<div class="col-md-3 pull-right">
			<a class="btn btn-danger btn-orange pull-right" data-toggle="modal" href='#modal_menu'>Assign menu</a>
		</div>
	</div>
	<hr>
	
<div class="row">
	<div class="col-md-12">
		<h5>Menu Aktif</h5>
		<table class="table table-mod">
			<thead>
				<tr>
					<th width="40%">Nama Menu</th><th>Keterangan Menu</th><th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Menu A</td><td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente saepe et enim fugiat, at ullam, sunt adipisci est nulla corporis nisi quis repellat aliquid velit temporibus laudantium fugit voluptate delectus.</td><td><button class="btn btn-danger btn-sm" onclick="konfirmasiNonaktif();"><i class="fa fa-trash-o"></i></button></td>
				</tr>
				<tr>
					<td>Menu B</td><td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente saepe et enim fugiat, at ullam, sunt adipisci est nulla corporis nisi quis repellat aliquid velit temporibus laudantium fugit voluptate delectus.</td><td><button class="btn btn-danger btn-sm" onclick="konfirmasiNonaktif();"><i class="fa fa-trash-o"></i></button></td>
				</tr>
				<tr>
					<td>Menu C</td><td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente saepe et enim fugiat, at ullam, sunt adipisci est nulla corporis nisi quis repellat aliquid velit temporibus laudantium fugit voluptate delectus.</td><td><button class="btn btn-danger btn-sm" onclick="konfirmasiNonaktif();"><i class="fa fa-trash-o"></i></button></td>
				</tr>
			</tbody>
		</table>
		<h5>Menu Non-Aktif</h5>
		<table class="table table-mod">
			<thead>
				<tr>
					<th width="40%">Nama Menu</th><th>Keterangan Menu</th><th></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Menu D</td><td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente saepe et enim fugiat, at ullam, sunt adipisci est nulla corporis nisi quis repellat aliquid velit temporibus laudantium fugit voluptate delectus.</td><td><button class="btn btn-success btn-sm" onclick="konfirmasiAktif();"><i class="fa fa-arrow-up"></i></button></td>
				</tr>
				<tr>
					<td>Menu E</td><td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente saepe et enim fugiat, at ullam, sunt adipisci est nulla corporis nisi quis repellat aliquid velit temporibus laudantium fugit voluptate delectus.</td><td><button class="btn btn-success btn-sm" onclick="konfirmasiAktif();"><i class="fa fa-arrow-up"></i></button></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
</div>
<!-- modal menu -->
<div class="modal fade" id="modal_menu">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header custom orange">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Assign Menu</h4>
						</div>
						<div class="modal-body">
							<select name="menu" id="inputMenu" class="form-control" required="required">
								<option value="0">--pilih menu</option>
								<option value="1">Menu A</option>
								<option value="2">Menu B</option>
							</select>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-danger btn-orange">Tambahkan menu ini</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->