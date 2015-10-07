<?php

require_once '../incs/header.php';
require_once '../incs/db_details.php';


if(!isset($_SESSION)){
	session_start();
}

if(is_log()){
	header('../articles/');
	exit();
}

if(isset($_POST['adlog'])){
	$con = new mysqli(host,user,pass,"base");
	$uname = (empty($_POST['uname']))?"":mysqli_real_escape_string($con,$_POST['uname']);
	$upass = (empty($_POST['upass']))?"":mysqli_real_escape_string($con,$_POST['upass']);
	if(!empty($uname) && !empty($upass)){
		$qry = sprintf("SELECT * FROM admin WHERE admin_name = '%s'AND admin_pass='%s'",$uname,$upass);
		$res = $con->query($qry);
		if(mysqli_num_rows($res)==1){
			$qry = sprintf("UPDATE admin SET last_act = NOW() WHERE admin_name='%s' AND admin_pass='%s'",$uname,$upass);
			$res=$con->query($qry);
			$_SESSION['logged_in'] = true;
			$_SESSION['admin'] = true;
			header('Location:../articles');
		}else{
			$err = "Sorry wrong username or password";
		}
	}else{
		$err = "<div class=\" red\">Please complete all the fields</div>";
	}
}




?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../assets/css/main.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/others/fa/css/font-awesome.min.css">
</head>
<body>

<div id="container">
	<div class="container-wrap">
		<form name="ad-login" action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post" style="padding:20px;background:#fff;border-radius:3px;max-width:450px;margin:50px auto;">
			<center><h1>Admin login</h1></center>
			<div class="field">
				<input type="text" name="uname" placeholder="Username">
			</div>
			<div class="field">
				<input type="password" name="upass" placeholder="Password">
			</div>
			<div class="field">
				<button type="submit" name="adlog" value="submit" class="bg-orange">SUBMIT</button>
			</div>
			<?PHP
				if(!empty($err)){
					echo $err;
					$err="";
				}
			?>
		</form>
	</div>
</div>




</body>
</html>