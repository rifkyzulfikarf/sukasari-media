<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Aplikasi Kunjungan Sukasari</title>

		<!-- Bootstrap CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="stylesheet" href="css/jquery.sidr.dark.css">
		<link rel="stylesheet" href="css/animate.min.css">

		<link rel="stylesheet" href="css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="css/jquery.dataTables.bootstrap.css">
		<link rel="stylesheet" href="css/jquery-ui.min.css">
		<link rel="stylesheet" href="css/ionicons.min.css">
		<link rel="stylesheet" media="screen" type="text/css" href="css/dropzone.css" />
		<link rel="stylesheet" href="app/style.css">
		<link rel="stylesheet" href="css/chosen.min.css">
		<link rel="shortcut icon" href="img/favicon.png">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- jQuery -->
		<script src="js/jquery.js"></script>
		<script src="js/jquery-ui.min.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.sidr.min.js"></script>
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/jquery.dataTables.bootstrap.js"></script>
		<script src="js/highcharts.js"></script>
		<script src="js/chosen.jquery.min.js"></script>
		<script type="text/javascript" src="js/dropzone.js"></script>
		<script type="text/javascript">// to make loading animation before page completely loaded
		$(window).load(function() {
		  $("#spinner").fadeOut("slow");
		})
		</script>
		<script src="js/wow.min.js"></script>
		<script>
			new WOW().init();
		</script>
		<script>
		  $(function() {
		    $(".datepicker").datepicker({
		    	dateFormat : "yy-mm-dd"
		    });


		    $(".link-menu").on("click",function(ev){
		    	ev.preventDefault();

                $('#isi_halaman').html("<div class='col-lg-12 text-center loading'><h1><i class='fa fa-refresh fa-4x fa-spin'></i><br>Loading...</h1></div>");
                var uri = $(this).data('hash');
                
                $.ajax({
                    url : "./",
                    method: "POST",
                    cache: false,
                    data: {"mod" : $(this).data('link'), "title" : $(this).data('title') },
                    success: function(event){
                        
                        $('#isi_halaman').html(event);
                        /* $('.table').dataTable(); */
                        $('.datepicker').datepicker({dateFormat: "yy-mm-dd"});
                        window.location.hash = uri;
						$("#simple-menu").click();

                    },
                    error: function(){
                        $('.loading').remove();
                        alert('Gagal terkoneksi dengan server, coba lagi..!');
                                
                    }
                    
                });
		    });

			$(".btn-logout").on('click', function(){
				window.location = "login/";
			});

		  });
		 </script>

		 <script>
			function ngePrint() {
			    window.print();
			}
			</script>
		<!-- function konfirmasi delete -->
		<script>
			function konfirmasiNonaktif(){
				confirm('Yakin ingin di non-aktifkan?');
			}
			function konfirmasiAktif(){
				confirm('Yakin untuk meng-aktifkan modul ini?');
			}
			function konfirmasiDel(){
				confirm('Yakin ingin di hapus?');
			}
		</script>
		<script>
			$(document).ready(function(){
				var cekNotif = function () {
					$.ajax({
						url : "./",
						method: "POST",
						cache: false,
						dataType: "JSON",
						data: {"aksi" : "<?php echo e_url('./app/get-notif.php'); ?>", "title" : "Notif", "apa" : "get"},
						success: function(ev){
							if (ev.jumlahNotif == 0) {
								$('#notif-list').html("<li><a>No new notification</a></li>");
								$('#notif-sign').hide();
							} else {
								$('#notif-list').html(ev.listNotif);
								$('#notif-sign').show();
							}
						},
						error: function(err){
							console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
							alert('Gagal terkoneksi dengan server, coba lagi..!');
						}
					});	
					
					setTimeout(cekNotif, 30000);
				};
				
				cekNotif();
				
				$( ".dropdown-menu" ).on( "click", ".notif-read", function(ev) {
					ev.preventDefault();
					$.ajax({
						url : "./",
						method: "POST",
						cache: false,
						dataType: "JSON",
						data: {"aksi" : "<?php echo e_url('./app/get-notif.php'); ?>", "title" : "Notif", "apa" : "set"},
						success: function(ev){
							$('#notif-list').html("<li><a>No new notification</a></li>");
							$('#notif-sign').hide();
							alert(ev.pesan);
						},
						error: function(err){
							console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
							alert('Gagal terkoneksi dengan server, coba lagi..!');
						}
					});	
				});
				
			});
		</script>