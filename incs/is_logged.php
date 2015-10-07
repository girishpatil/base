<?PHP
if(!isset($_SESSION)){
	session_start();
}

function is_logged(){
	if(!is_log())
	{
	header("Location:/projects/vtu3/");
	exit();
	}
	return true;
}


function is_log(){
	if((!isset($_SESSION['access_token']) && !isset($_SESSION['uid'])) && (!isset($_SESSION['admin'])))
	{
		return false;
	}else{
		return true;
	}
}
?>