<?PHP

if(!isset($_GET['aid'])|| empty($_GET['aid'])){
	header('Location:../');
}

require_once '../../incs/db_details.php';

$con = new mysqli(host,user,pass,"base");

if(isset($_GET['who'])&&isset($_GET['eid'])&&isset($_GET['wh'])){
	if($_GET['who']=="ad"&&$_GET['wh']=='app_edit'){
		$eid = mysqli_real_escape_string($con,$_GET['eid']);
		$qry = sprintf("UPDATE edits SET activity = 200 ,who='admin' WHERE edit_id='%s'",$eid);
		$res = $con->query($qry);
	}
}


$aid = mysqli_real_escape_string($con,$_GET['aid']);


require_once '../../incs/vote.php';

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

<div id="container-wrap">
	<div class="container-wrap">

<?php
$qry =sprintf("SELECT edit FROM edits WHERE article_id='%s'AND activity=200",$aid);
$edits = [];
$res=$con->query($qry);
while($row=$res->fetch_assoc()){
	$edits[] = $row;
}
			echo '<div class="lav-title">
					<h1>'.$stuff['article_title'].'</h1>
					Category <span class="mini">'.what_cate($stuff['cate']).'</span><span><i class="fa-calendar"></i>'.$stuff['article_date'].'</span>
				</div>
				<div class="lav-desc">'.$stuff['article'].'
				<div class="recent-add">
					<h3>Changes commited</h3>';
					foreach ($edits as $value) {
						echo '<div>'.$value['edit'].'</div><hr>';
					}
			echo '</div>';
				if(is_log()){
					echo '<div><a href="../edit/?aid='.$aid.'" class="a-but bg-attractive">Help us improve this article</a></div>';
				}
			echo '</div>
				<div class="about">
					<span>Views <span class="mini">120 views WHAT </span></span>
					<span>Followers <span class="mini">150 WHAT</span></span>
				</div>

		';


$qry = sprintf("SELECT * FROM edits WHERE article_id = '%s' AND activity!=200",$aid);
$res = $con->query($qry);
if(mysqli_num_rows($res)>0){
$st = [];
while($row = $res->fetch_assoc()){
	$st = $row;
}
$qry = sprintf("SELECT user_name FROM users WHERE user_id = '%s'",$st['user_id']);
$res = $con->query($qry);
$user_name = $res->fetch_assoc();


?>

<div class="cm" id="chn">
	<h3>Changes suggested.</h3>

		<?PHP

	echo '<div class="cm-wrap">
				<div class="cm-vote voter">
					<div><a href="?aid='.$aid.'&eid='.$st['edit_id'].'&vote=up"  class="upvote"  onclick="vote(this.id,\'up\');"><i class="fa-thumbs-up"></i></a></div>
					<div><a href="?eid='.$aid.'&eid='.$st['edit_id'].'&vote=dw"  class="dwvote"  onclick="vote(this.id,\'dw\');"><i class="fa-thumbs-down"></i></a></div>
				</div>
				<div class="cm-content">
					<div class="cm-desc">
						'.htmlentities($st['edit']).'
					</div>
					<div class="about">
						<span>User <span class="mini">'.$user_name['user_name'].'</span></span>
						<span>Date <span class="mini">'.$st['edit_date'].'</span></span>
						<span>Time <span class="mini">'.$st['edit_time'].'</span></span>
					</div>';
					if(is_log()){
						echo '<span>
								<a href="?who=ad&wh=app_edit&eid='.$st['edit_id'].'&aid='.$aid.'" class="a-but bg-orange">Approve</a>
							</span>';
						}
				echo '</div>
			</div>
		</div>';
}
		?>

	</div>
</div>

<div class="clear">
</div>

</div></body></html>