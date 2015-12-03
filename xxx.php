
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
include 'inc/blob.php';
if( isset($_POST['nama']) && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['status']) ){
	echo "nama : ".e_code($_POST['nama'])."<br>user : ".e_code($_POST['user'])."<br>pass : ".e_code($_POST['pass'])."<br>status : ".e_code($_POST['status']);
}
?>
<hr>
	<form action="xxx.php" method="post">
		<input type="text" name="nama" placeholder="nama" >
		<input type="text" name="user"  placeholder="user">
		<input type="text" name="pass"  placeholder="pass">
		<input type="text" name="status"  placeholder="status">
		<button type="submit"> HLO ..! </button>

	</form>
</body>
</html>