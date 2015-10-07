<?PHP
require_once '../../incs/db_details.php';

require_once '../../incs/is_logged.php';
is_logged();

$con = new mysqli(host,user,pass,"base");
$aid = mysqli_real_escape_string($con,$_GET['aid']);

$_SESSION['uid'] = 12345;


if(isset($_POST['edit-submit'])){
	require_once '../../incs/article.class.php';
	$stuff['edit'] = (isset($_POST['edit-content']))?$_POST['edit-content'] : "";
	$stuff['aid'] = $aid;
	$stuff['uid'] = $_SESSION['uid'];
	$tm = new article($stuff,"edit");
	$err = $tm->msg;
}else if(!isset($_GET['aid'])|| empty($_GET['aid'])){
	header('Location:../');
}






$qry = sprintf("SELECT * FROM articles WHERE article_id = '%s'",$aid);
$res = $con->query($qry);
$stuff = $res->fetch_assoc();
if(empty($stuff)){
	header('Location:../');

}

function what_cate($c){
	switch ($c) {
			case 10: $c = "important questions";
				break;
			case 20: $c = "sports";
				break;	
			case 30: $c = "concepts in science";
				break;
			case 40: $c = "others";
				break;
			default: $c = "others";
				break;
		}
		return $c;
}



?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../../assets/css/main.css">
	<link rel="stylesheet" type="text/css" href="../../assets/css/home.css">
    <link rel="stylesheet" href="../../assets/others/fa/css/font-awesome.min.css">
</head>
<body>


<?PHP

require_once '../../incs/header.php';

?>
<script type="text/javascript" src="../../assets/js/jquery-min.js"></script>
	<script type="text/javascript" src="../../assets/others/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
	tinymce.init({
	    selector: "textarea",
	    plugins: [
	         "autolink lists link image anchor ",
	        "searchreplace  fullscreen",
	        "insertdatetime media contextmenu "
	    ],
	    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
	});
	</script>
<div id="container-wrap">
	<div class="container-wrap">

<?php

			echo '<div class="lav-title">
					<h1>'.$stuff['article_title'].'</h1>
					Category : <span class="mini">'.what_cate($stuff['cate']).'</span><span><i class="fa-calendar"></i>'.$stuff['article_date'].'</span>
				</div>
				<div class="lav-desc">'.$stuff['article'].'
				</div>

				';


?>

	<div class="notice">
		<h2>Read this before you edit.</h2>
		<p>
			<ul>
				<li>Please write appropriate content only.</li>
				<li>Your edit will not be commited unless the edit meets necessary requirements. (i.e the changes will not be visible o public who do not login)</li>
			</ul>			
		</p>
	</div>
	<h1 class="wsy-head">Edit this article</h1>
	<form method="post"  id="wsy" action="<?PHP echo $_SERVER['PHP_SELF'].'?aid='.$aid;?>">
	<div class="field">
		<label>Content of your article</label>
	</div>
		<textarea name="edit-content" style="width:100%;font-size:16px;border:1px solid #d9d9d9;font-family:helvetica ,segoe ui;letter-spacing:.8px;"></textarea>
	   	<?PHP if(!empty($err)) print_r($err); ?>
	    <button type="submit"  name="edit-submit" class="bg-but-at">Submit</button>
	</form>


	</div>
</div>




