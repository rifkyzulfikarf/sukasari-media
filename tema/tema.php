<?php

include './tema/class.tema.php';
$data = new tema();

?>

<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
		<center>
				<h4>Master Data Tema Layar</h4>
			</center>
		</div>
		<div class="col-md-3">
			<a class="btn btn-danger btn-orange btn-sm pull-right baru" ><i class="fa fa-plus"></i> Input Tema Layar Baru</a>
			<div class="modal fade" id="modal_tema" data-backdrop="static">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header custom orange">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"><i class="fa fa-plus"></i> Input Tema Layar Baru</h4>
						</div>
						<div class="modal-body">
							<form action="#" id="form-input" class="form-horizontal" method="POST">
								<input type="hidden" name="apa" id="apa" value="">
								<input type="hidden" name="aksi" id="aksi" value="<?php echo e_url('tema/tema_aux.php'); ?>">
								<input type="hidden" name="id" id="id" value="">
								<input type="text" name="tema" id="tema" class="form-control" placeholder="Nama Tema">
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
			<table class="table table-bordered table-striped table-mod" id="tabel-tema">
				<thead>
					<tr>
						<th>Nama Tema</th><th></th>
					</tr>
				</thead>
				<tbody>

				<?php
					if( $daftar = $data->getTema() ){
						while( $rs = $daftar->fetch_assoc() ){

							echo "<tr>
							<td>".$rs['tema']."</td>
							<td> <a href='#' class='btn btn-sm btn-danger btn-orange edit-tema' data-id='".$rs['id']."' data-tema='".$rs['tema']."'>edit</a> 
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
            data: {"mod" : "<?php echo e_url('tema/tema.php'); ?>", "title" : "Master Data Tema" },
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

    $('#tabel-tema').DataTable();

    $(document).on('click', '.baru', function(event) {
    	event.preventDefault();
    	$('#apa').val('input-tema');
    	$('#tema').val('');
    	$('#modal_tema').modal('show');
    });

    $(document).on('click', '.edit-tema', function(event){
    	event.preventDefault();
    	$('#apa').val('edit-tema');
    	$('#id').val( $(this).data('id') );
    	$('#tema').val( $(this).data('tema') );
    	$('#modal_tema').modal('show');

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
