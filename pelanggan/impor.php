<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<center>
				<h4>Impor Ubah Data Pelanggan</h4>
			</center>
		</div>
		<div class="col-md-3">
			
		</div>
	</div>
	<hr>
	<div id="dropzone" class="dropzone"></div>
</div>

<script>
$(document).ready( function () {
	
	var myDropzone = $("#dropzone").dropzone({ 
		url: "inc/impor-ubah-pelanggan.php",
		acceptedFiles: "application/vnd.ms-excel"
	});

	function reloading(){
		$('#isi_halaman').append("<div class='pull-right loading'><h1><i class='fa fa-refresh fa-spin'></i></h1></div>");
		
		$.ajax({
        	url : "./",
            method: "POST",
            cache: false,
            data: {"mod" : "<?php echo e_url('pelanggan/impor.php'); ?>", "title" : "impor" },
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

});
</script>