<?PHP

require_once '../../incs/article.class.php';
if(!isset($_SESSION)){
	session_start();
}
$err = "";
if(isset($_POST['art-submit'])){
	$st['title'] 	= $_POST['art-title'];
	$st['cate'] 	= $_POST['art-cate'];
	$st['article']  = $_POST['art-content'];
	$art = new article($st,"article");
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
require_once '../../incs/is_logged.php';
require_once '../../incs/header.php';

?>

<div id="container-wrap">
	<div class="container-wrap">
<br>
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

<h1 class="wsy-head">Write an article</h1>
<?PHP if(isset($_SESSION['msg'])){
		echo '<div class="red">'.$_SESSION['msg'].'</div>';
		unset($_SESSION['msg']);
	}?>
	<form method="post"  id="wsy" action="<?PHP echo $_SERVER['PHP_SELF'];?>">
	<div class="field">
		<label>Title of the article.</label>
		<input type="text" name="art-title" placeholder="Your article's title">
	</div>
	<div class="field">
		<label>Select category</label>
		<select name="art-cate">
			<option value="0">Choose category</option>
			<option value="10">important questions</option>
			<option value="20">Sports</option>
			<option value="30">concepts in chapters</option>
			<option value="40">others</option>
		</select>
	</div>
	<div class="field">
		<label>Content of your article</label>
	</div>
		<textarea name="art-content" style="width:100%;font-size:16px;border:1px solid #d9d9d9;font-family:helvetica ,segoe ui;letter-spacing:.8px;"></textarea>
	    <button type="submit"  name="art-submit" class="bg-but-at">Submit</button>
	</form>

	</div>
</div>



</div></div></body></html>