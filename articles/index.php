<?PHP

require_once '../incs/db_details.php';

$con = new mysqli(host,user,pass,"base");
$qry = "SELECT article_id,article_title,cate FROM articles WHERE activity = 200";

$res = $con->query($qry);
$stuff = array();
while ($rw = $res->fetch_assoc()) {
	$stuff[] = $rw;
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


<?PHP

require_once '../incs/header.php';

?>

<div id="container-wrap">
	<div class="container-wrap">
	<center><h1>Recent Articles.</h1></center>
	<div class="grid-content">
<?PHP
	
	foreach ($stuff as $value) {
		$c = "";
		switch ($value['cate']) {
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
		echo '<a href="details?aid='.$value['article_id'].'" class="grid">
				<div class="grid-top">
					<h4>'.$value['article_title'].'</h4>
				</div>
				<div class="grid-bottom"><span class="mini">'.$c.'</span></div>
			  </a>';
	}



?>



		
		



	</div>

	</div>
</div>


</body>
</html>