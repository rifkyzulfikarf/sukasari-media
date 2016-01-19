<?php

include './layar/class.layar.php';
$data = new layar();

?>

<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
		<center>
				<h4>Master Data Jenis Layar</h4>
			</center>
		</div>
		<div class="col-md-3">
			<a class="btn btn-danger btn-orange btn-sm pull-right baru" ><i class="fa fa-plus"></i> Input Jenis Layar Baru</a>
			<div class="modal fade" id="modal_layar" data-backdrop="static">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header custom orange">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><i class="fa fa-plus"></i> Input Jenis Layar Baru</h4>
						</div>
						<div class="modal-body">
							<form action="#" id="form-input" class="form-horizontal" method="POST">
								<input type="hidden" name="apa" id="apa" value="">
								<input type="hidden" name="aksi" id="aksi" value="<?php echo e_url('layar/layar_aux.php'); ?>">
								<input type="hidden" name="id" id="id" value="">
								<input type="text" name="bahan" id="bahan" class="form-control" placeholder="Bahan">
								<input type="text" name="harga" id="harga" class="form-control" placeholder="Harga/m">
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
			<table class="table table-bordered table-striped table-mod" id="tabel-layar">
				<thead>
					<tr>
						<th>BAHAN</th><th>HARGA/M</th><th></th>
					</tr>
				</thead>
				<tbody>

				<?php
					if( $daftar = $data->getLayar() ){
						while( $rs = $daftar->fetch_assoc() ){

							echo "<tr>
							<td>".$rs['bahan']."</td>
							<td>Rp ".number_format($rs['harga/m'],0,",",".")."</td>
							<td> <a href='#' class='btn btn-sm btn-danger btn-orange edit-layar' data-id='".$rs['no']."' data-bahan='".$rs['bahan']."' data-harga='".$rs['harga/m']."'>edit</a> 
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
            data: {"mod" : "<?php echo e_url('layar/layar.php'); ?>", "title" : "Master Data Layar" },
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

    $('#tabel-layar').DataTable();

    $(document).on('click', '.baru', function(event) {
    	event.preventDefault();
    	$('#apa').val('input-layar');
    	$('#bahan').val('');
    	$('#harga').val('');
    	$('#modal_layar').modal('show');
    });

    $(document).on('click', '.edit-layar', function(event){
    	event.preventDefault();
    	$('#apa').val('edit-layar');
    	$('#id').val( $(this).data('id') );
    	$('#bahan').val( $(this).data('bahan') );
    	$('#harga').val( $(this).data('harga') );
    	$('#modal_layar').modal('show');

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
