<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<center>
				<h4>Master Data Supplier</h4>
			</center>
		</div>
		<div class="col-md-3">
			<a class="btn btn-danger btn-orange btn-sm pull-right" data-toggle="modal" href='#modal_karyawan_baru'><i class="fa fa-plus"></i> Daftarkan Supplier</a>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-mod" id="tabel-supplier">
				<thead>
					<tr>
						<th>#</th><th>Nama Supplier</th><th>Alamat</th><th>Telp</th><th>Fax</th><th>Email</th><th>CP</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1</td><td>Citra Digital Printing Solution</td><td>Jalan meranti raya no 273 B banyumanik semarang</td><td>0247460648</td><td></td><td>citraideal.printing@gmail.com</td><td>hary susanto</td>
					</tr>
					<tr>
						<td>2</td><td>Digimax</td><td>Komp. Pertokoan sriwijaya no. 72 A-B semarang 50242 (samping esia)</td><td>0248416955 / 8416672</td><td>0248417011</td><td>citraideal.printing@gmail.com</td><td>Anita Darma</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

<!-- modal tambah supplier -->
<div class="modal fade" id="modal_karyawan_baru">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header custom orange">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><i class="fa fa-plus"></i> Daftarkan Supplier</h4>
						</div>
						<div class="modal-body">
							<form action="#" class="form-horizontal" method="POST">
								<div class="form-group">
									<label for="inputNama" class="col-sm-3 control-label">Nama Supplier</label>
									<div class="col-sm-9">
										<input type="text" name="nama" id="inputNama" class="form-control input-min"    placeholder="nama supplier">
									</div>
								</div>
								<div class="form-group">
									<label for="inputAlamat" class="col-sm-3 control-label">Alamat</label>
									<div class="col-sm-9">
										<textarea name="alamat" id="alamat" cols="30" rows="2" class="form-control input-min" placeholder="alamat supplier"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="inputTelp" class="col-sm-3 control-label">Telp:</label>
									<div class="col-sm-9">
										<input type="text" name="telp" id="inputTelp" class="form-control input-min" placeholder="Telp">
									</div>
								</div>
								<div class="form-group">
									<label for="inputTelp" class="col-sm-3 control-label">Fax</label>
									<div class="col-sm-9">
										<input type="text" name="fax" id="inputfax" class="form-control input-min" placeholder="fax">
									</div>
								</div>
								<div class="form-group">
									<label for="inputTelp" class="col-sm-3 control-label">Email</label>
									<div class="col-sm-9">
										<input type="text" name="email" id="inputemail" class="form-control input-min" placeholder="email">
									</div>
								</div>
								<div class="form-group">
									<label for="inputTelp" class="col-sm-3 control-label">Contact Person</label>
									<div class="col-sm-9">
										<input type="text" name="contactperson" id="inputcontactperson" class="form-control input-min" placeholder="contact person">
									</div>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-danger">Simpan <i class="fa fa-send"></i></button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

<script>
	$(document).ready( function () {
    $('#tabel-supplier').DataTable();
} );
</script>