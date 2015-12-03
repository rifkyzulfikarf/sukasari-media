<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<center>
				<h4>Master Data Karyawan </h4>
			</center>
		</div>
		<div class="col-md-3">
			<a class="btn btn-danger btn-orange btn-sm pull-right" data-toggle="modal" href='#modal_karyawan_baru'><i class="fa fa-plus"></i> Daftarkan Karyawan</a>
			<div class="modal fade" id="modal_karyawan_baru">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header custom orange">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><i class="fa fa-plus"></i> Daftarkan Karyawan</h4>
						</div>
						<div class="modal-body">
							<form action="#" class="form-horizontal" method="POST">
								<input type="text" name="nama" id="inputNama" class="form-control" placeholder="nama karyawan">
								<br>
								<select name="jabatan" id="inputJabatan" class="form-control" required="required">
									<option value="0">-- pilih jabatan --</option>
									<option value="1">Area Sales Manager</option>
									<option value="2">Promosi</option>
									<option value="3">Administrasi</option>
									<option value="4">Supervisor</option>
								</select>
								<br>
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
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-danger">Simpan <i class="fa fa-send"></i></button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped table-mod" id="tabel-karyawan">
				<thead>
					<tr>
						<th>#</th><th>NAMA</th><th>JABATAN</th><th>PENEMPATAN</th><th></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1</td><td>Rud Van Nistelrooy</td><td>Supervisor</td><td>Semarang</td><td><a href="?mod=edit-karyawan" class="btn btn-danger btn-orange btn-sm">edit</a> <a href="#" onclick="konfirmasiNonaktif();" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a></td>
					</tr>
					<tr>
						<td>2</td><td>Paul Scholes</td><td>Supervisor</td><td>Semarang</td><td><a href="?mod=edit-karyawan" class="btn btn-danger btn-orange btn-sm">edit</a> <a href="#" onclick="konfirmasiNonaktif();" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a></td>
					</tr>
					<tr>
						<td>3</td><td>Ryan Giggs</td><td>Supervisor</td><td>Semarang</td><td><a href="?mod=edit-karyawan" class="btn btn-danger btn-orange btn-sm">edit</a> <a href="#" onclick="konfirmasiNonaktif();" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a></td>
					</tr>
					<tr>
						<td>4</td><td>Edwin Van De Sar</td><td>Supervisor</td><td>Semarang</td><td><a href="?mod=edit-karyawan" class="btn btn-danger btn-orange btn-sm">edit</a> <a href="#" onclick="konfirmasiNonaktif();" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></a></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
	$(document).ready( function () {
    $('#tabel-karyawan').DataTable();
} );
</script>