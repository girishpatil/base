<?PHP
require_once 'is_logged.php';
is_logged();

$_SESSION['uid'] = 12345;

if(isset($_GET['eid'])&&isset($_GET['vote'])){
	$eid = mysqli_real_escape_string($con,$_GET['eid']);
	$vote = mysqli_real_escape_string($con,$_GET['vote']);
	if($vote!='up' && $vote!='dw'){
		header('Location:'.$_SERVER['PHP_SELF']);
		exit();
	}
	$vote_stuff = [];
	$qry = sprintf("SELECT user_college FROM users WHERE user_id = '%s'",$_SESSION['uid']);
	$res = $con->query($qry);
	$vote_stuff[] = $res->fetch_assoc();
	$qry = sprintf("SELECT user_id FROM articles WHERE article_id = '%s' ",$aid);
	$res = $con->query($qry);
	$vote_stuff[] = $res->fetch_assoc();
	$qry = sprintf("SELECT user_college FROM users WHERE user_id = '%s'",$vote_stuff[1]['user_id']);
	$res = $con->query($qry);
	$vote_stuff[] = $res->fetch_assoc();


	if($vote_stuff[0]['user_college']!=$vote_stuff[2]['user_college']){
		$qry = sprintf("UPDATE edits SET reputation = reputation + 1 WHERE edit_id = '%s'",$eid);
		$res= $con->query($qry);
	}
}


?>