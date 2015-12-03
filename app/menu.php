<nav class="navbar navbar-default navbar-fixed-top menu" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="?">Aplikasi Media Promosi Sukasari</a>
			</div>
		
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#sidr" id="simple-menu"><i class="fa fa-bars"></i></a></li>
					
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <span class="badge alert-danger">2</span></a>
						<ul class="dropdown-menu">
							<li><a href="#">Notif A</a></li>
							<li><a href="#">Notif B</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> User <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="?mod=profil">Profil</a></li>
							<li><a data-toggle="modal" href='#sign-out'>Sign Out</a>

						</ul>
					</li>
					<li><a href="#"></a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</nav>
		<!-- MENU SIDEBAR -->
		<div id="sidr">
		<ul>
		   <!-- ITEM UNTUK MENU SIDEBAR -->
		   	<li class='dropdown'><a href='#'><i class="fa fa-chevron-down"></i> MASTER</a>
				<ul class='sub-menu-sidr'>
					<li><a href="?mod=user">User</a></li>
					<li><a href="?mod=karyawan">Karyawan</a></li>
			    	<li><a href="?mod=supplier">Supplier</a></li>
				</ul>
		   	</li>
		   
		   	<li class='dropdown'><a href='#'><i class="fa fa-chevron-down"></i> LAPORAN</a>
				<ul class='sub-menu-sidr'>
					<li><a href="?mod=laporan-kunjungan">Laporan Kunjungan</a></li>
		    		<li><a href="?mod=laporan-harian">Laporan Harian</a></li>
				</ul>
		   	</li>
		    
		</ul>

		  
		</div>
 
<script>
$(document).ready(function() {
   $('#simple-menu').sidr({
    "speed":50,
    "displace":false,
    "side":"right"
  });

});

$(document).ready(function() {
    $("#isi_halaman").click(function() {
        $.sidr('close');          
    });
});
</script>
<script>
$(document).ready(function() {
    $('.sub-menu-sidr').hide();

    $("#sidr li:has(ul)").click(function(){

    $("ul",this).toggle('fast');
    });
});
</script>