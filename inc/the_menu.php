<?php

class menu extends koneksi{
	function cek_menu_admin($level, $induk){
		
		$level = $this->clearText($level);
		$induk = $this->clearText($induk);

		if( $daftar = $this->runQuery("SELECT * FROM `akses_menu` WHERE `level` = '$level' && `induk` = '$induk' ORDER BY `urutan` ") ){

			if( $daftar->num_rows > 0 ){
				
				return $daftar;

			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

	function cek_menu($id_user, $level, $induk){

		$id_user = $this->clearText($id_user);
		$level = $this->clearText($level);
		$induk = $this->clearText($induk);


		if( $daftar = $this->runQuery("SELECT `akses_menu`.* FROM `akses_menu` INNER JOIN `akses` ON `akses`.`id_menu` = `akses_menu`.`id` WHERE `akses`.`id_user` = '$id_user' && `akses_menu`.`level` = '$level' && `akses_menu`.`induk`='$induk'   ") ){

			if( $daftar->num_rows > 0 ){
				
				return $daftar;

			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}


	}

}//--------- end class


if( isset( $_SESSION['media-id']) && $_SESSION['media-id']<>"" && isset($_SESSION['media-status']) && $_SESSION['media-status']<>"" ){

	$menu = new menu();

?>

<nav class="navbar navbar-default navbar-fixed-top menu" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="./">Aplikasi Media Promosi Sukasari</a>
			</div>
		
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#sidr" id="simple-menu"><i class="fa fa-bars"></i></a></li>
					
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <span class="badge alert-danger" id="notif-sign">!</span></a>
						<ul class="dropdown-menu" id="notif-list">
							<li><a href="">Notif A</a></li>
							<li><a href="">Notif B</a></li>
							<li><a href="">Notif C</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['media-nama']; ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#" class="link-menu" data-link="<?php echo e_url("app/profil.php") ?>" data-hash="profil">Ubah Profil</a></li>
							<li><a data-toggle="modal" href='#sign-out'>Sign Out</a>

						</ul>
					</li>
					<li><a href="#"></a></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</nav>
		
		<div id="sidr">
		<ul>
		

<?php


//------------- Jika admin
	if( $_SESSION['media-status'] == e_code("2") || $_SESSION['media-status'] == e_code("9") ){	
		
		if( $level1 = $menu->cek_menu_admin("1","0") ){
			while( $rs1 = $level1->fetch_assoc() ){
				if( $level2 = $menu->cek_menu_admin("2",$rs1['id']) ){
					echo "<li class='dropdown'> <a href='#'> <i class='fa fa-chevron-down'></i>  <i class='".$rs1['icon']."'></i> ".$rs1['nama']."</a>
					<ul class='sub-menu-sidr'>";

					while($rs2 = $level2->fetch_assoc() ){
						echo "<li><a href='#' class='link-menu' data-link='".e_url($rs2['url'])."' data-hash='".$rs2['title']."' ><i class='".$rs2['icon']."'></i> ".$rs2['nama']."</a></li>";

					}

					echo "</ul></li>";

				}else{
					echo "<li> <a href='#' class='link-menu' data-link='".e_url($rs1['url'])."' data-hash='".$rs1['title']."'> <i class='".$rs1['icon']."'></i>".$rs1['nama']."</a> </li>";
				}
			}
		}

//------------ jika admin
	}elseif( $_SESSION['media-status'] == e_code("1") ){

		if( $level1 = $menu->cek_menu(d_code($_SESSION['media-data']),'1','0') ){
			while( $rs1 = $level1->fetch_assoc() ){
				if( $level2 = $menu->cek_menu(d_code($_SESSION['media-data']),'2',$rs1['id']) ){
					echo "<li class='dropdown'> <a href='#'> <i class='fa fa-chevron-down'></i>  <i class='".$rs1['icon']."'></i> ".$rs1['nama']."</a>
					<ul class='sub-menu-sidr'>";

					while($rs2 = $level2->fetch_assoc() ){
						echo "<li><a href='#' class='link-menu' data-link='".e_url($rs2['url'])."' data-hash='".$rs2['title']."' ><i class='".$rs2['icon']."'></i> ".$rs2['nama']."</a></li>";

					}

					echo "</ul></li>";

				}else{
					echo "<li> <a href='#' class='link-menu' data-link='".e_url($rs1['url'])."' data-hash='".$rs1['title']."'> <i class='".$rs1['icon']."'></i>".$rs1['nama']."</a> </li>";
				}
			}
		}


	}

?>

	
		</ul>
		</div><!-- #sidr -->

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





<?php

}

?>

