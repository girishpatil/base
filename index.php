<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
	<link rel="stylesheet" type="text/css" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/others/fa/css/font-awesome.min.css">
</head>
<body>

<?PHP 
if(!isset($_SESSION)){
	session_start();
}

	require_once 'incs/header.php';
	require_once 'incs/db_details.php';
?>

<div id="container">
	<div class="container-wrap">

<?PHP
if(isset($_POST['college-submit'])){
	print_r($_POST);
	$con = new mysqli(host,user,pass,"base");
	$name = mysqli_real_escape_string($con,$_POST['user-name']);
	$col = mysqli_real_escape_string($con,$_POST['college']);
	if(!empty($col)){
		$qry = sprintf("UPDATE users SET user_name ='%s' ,user_college = '%s' WHERE user_id = 12345",$name,$col,$_SESSION['uid']);
		$res = $con->query($qry);
		unset($_SESSION['first_time']);
		header("Location:articles/");
		exit();
	}else{
		$err = "Please enter all details";
	}
}

if(isset($_SESSION['access_token']) && isset($_SESSION['first_time'])){
	echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post" style="max-width:650px;margin:50px auto;">
		<div class="field">
			<input type="text" name="user-name" placeholder="Your name">
		</div>
		<div class="field">
			<input type="text" name="college" placeholder="Your college name">
		</div>
		<div class="field">
			<button type="submit" value="submit" name="college-submit" class="bg-orange">SUBMIT</button>
		</div>';
		if(isset($err)&& !empty($err)){
			echo '<span class="red">'.$err.'</span>';
			$err ="";
			unset($err);
		}
}else{

?>
		<div class="content">
			<h1>Welcome to VTU's Knowledge base.</h1>
			<p>Here you can read articles submitted by other students and teachers or submit your own.</p>
			<p>create an account or <a href="">login</a> to write an article</p>
			<div class="social">
				<a href="" class="social-login-gp"><i class="fa-google-plus"></i>Google</a>
			</div>
			<div class="main-content">
<?PHP
}

?>

			</div>
		</div>
	</div>
</div>

</body>
</html>




<?PHP

$tab[] = "users";
$tab[] = "articles";
$tab[] = "edits";
$con = new mysqli (host,user,pass,"base");

foreach ($tab as $key) {
	$qry = "ALTER TABLE $key AUTO_INCREMENT = 1";
	$e = $con->query($qry);
}

?>