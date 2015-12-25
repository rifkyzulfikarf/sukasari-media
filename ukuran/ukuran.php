<?php

include './ukuran/class.ukuran.php';
$data = new ukuran();

?>

<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
		<center>
				<h4>Master Data Ukuran </h4>
			</center>
		</div>
		<div class="col-md-3">
			<a class="btn btn-danger btn-orange btn-sm pull-right baru" ><i class="fa fa-plus"></i> Input Ukuran Baru</a>
			<div class="modal fade" id="modal_ukuran" data-backdrop="static">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header custom orange">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><i class="fa fa-plus"></i> Input Ukuran Baru</h4>
						</div>
						<div class="modal-body">
							<form action="#" id="form-input" class="form-horizontal" method="POST">
								<input type="hidden" name="apa" id="apa" value="">
								<input type="hidden" name="aksi" id="aksi" value="<?php echo e_url('ukuran/ukuran_aux.php'); ?>">
								<input type="hidden" name="id" id="id" value="">
								<input type="text" name="panjang" id="panjang" class="form-control" placeholder="Panjang">
								<input type="text" name="lebar" id="lebar" class="form-control" placeholder="Lebar">
								<input type="text" name="pre" id="pre" class="form-control" placeholder="prefix" value="P MMT">
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default btn-close-modal" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-danger btn-simpan">Simpan <i class="fa fa-send"></i></button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-striped table-mod" id="tabel-ukuran">
				<thead>
					<tr>
						<th>PANJANG</th><th>LEBAR</th><th>PREFIX</th><th></th>
					</tr>
				</thead>
				<tbody>

				<?php
					if( $daftar = $data->daftar_ukuran() ){
						while( $rs = $daftar->fetch_assoc() ){

							echo "<tr>
							<td>".$rs['panjang']."</td>
							<td>".$rs['lebar']."</td>
							<td>".$rs['pre']."</td>
							<td> <a href='#' class='btn btn-sm btn-danger btn-orange edit-ukuran' data-id='".$rs['id']."' data-panjang='".$rs['panjang']."' data-lebar='".$rs['lebar']."'>edit</a> 
							</td></tr>";

						}
					}

				?>

				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
$(document).ready( function () {

	function reloading(){
		$('#isi_halaman').append("<div class='pull-right loading'><h1><i class='fa fa-refresh fa-spin'></i></h1></div>");
		
		$.ajax({
        	url : "./",
            method: "POST",
            cache: false,
            data: {"mod" : "<?php echo e_url('ukuran/ukuran.php'); ?>", "title" : "Master Data Ukuran" },
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

    $('#tabel-ukuran').DataTable();

    $(document).on('click', '.baru', function(event) {
    	event.preventDefault();
    	$('#apa').val('input-ukuran');
    	$('#panjang').val('');
    	$('#lebar').val('');
    	$('#modal_ukuran').modal('show');
    });

    $(document).on('click', '.edit-ukuran', function(event){
    	event.preventDefault();
    	$('#apa').val('edit-ukuran');
    	$('#id').val( $(this).data('id') );
    	$('#panjang').val( $(this).data('panjang') );
    	$('#lebar').val( $(this).data('lebar') );
    	$('#modal_ukuran').modal('show');

    });


    $('.btn-simpan').on('click', function(ev){
    	ev.preventDefault();
        var ini = $('#form-input').serialize();

        $('.btn-simpan').addClass('disabled').html('Processing... <i class="fa fa-spinner fa-pulse"></i>');
        
		$.ajax({
            url: "./",
            method: "POST",
            cache: false,
            dataType: "JSON",
            data: ini,
            success: function(eve){

            	if( eve.status ){
            		$('.btn-close-modal').click();
            		alert(eve.msg);
            		reloading();
            	}else{
            		$('.btn-simpan').html('Simpan <i class="fa fa-send"></i>').removeClass('disabled');
            		alert(eve.msg);
            	}
  

            },
            error: function(){
            	alert('Gagal terkoneksi dengan server..');
          		$('.btn-simpan').html('Simpan <i class="fa fa-send"></i>').removeClass('disabled');
            }

         });

    });


    $('#form-input').on('submit', function(event){
    	event.preventDefault();
    	$('.btn-simpan').click();
    });


    



} );
</script>
