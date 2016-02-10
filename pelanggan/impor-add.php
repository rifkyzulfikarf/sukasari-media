<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<center>
				<h4>Impor Tambah Data Pelanggan</h4>
			</center>
		</div>
		<div class="col-md-3">
			<a class="btn btn-danger btn-orange btn-sm pull-right input-pelanggan" href='#' id="btn-download-format">Download Format</a>
		</div>
	</div>
	<hr>
	<div id="dropzone" class="dropzone"></div>
</div>

<script>
$(document).ready( function () {
	
	var myDropzone = $("#dropzone").dropzone({ 
		url: "inc/impor-tambah-pelanggan.php",
		acceptedFiles: "application/vnd.ms-excel"
	});

	function reloading(){
		$('#isi_halaman').append("<div class='pull-right loading'><h1><i class='fa fa-refresh fa-spin'></i></h1></div>");
		
		$.ajax({
        	url : "./",
            method: "POST",
            cache: false,
            data: {"mod" : "<?php echo e_url('pelanggan/impor-add.php'); ?>", "title" : "impor" },
            success: function(event){
            
            	
            	$('.loading').remove();	
            	$('#isi_halaman').html(event);
            	
			},
            error: function(){
            	$('.loading').remove();
                alert('Gagal terkoneksi dengan server, coba lagi..!');
                                
			}
                
        });

	};
	
	$('#btn-download-format').click(function(ev){
		ev.preventDefault();
		
		var url = "inc/download-format-impor-pelanggan.php";
		window.open(url);
	});

});
</script>