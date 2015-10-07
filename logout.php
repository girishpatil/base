<?php

require_once 'incs/is_logged.php';

if(is_logged()==true){

	if(isset($_SESSION['admin'])){
		unset($_SESSION['admin']);
	}
	if(isset($_SESSION['access_token'])){
		unset($_SESSION['access_token']);
	}
	if(isset($_SESSION['uid'])){
		unset($_SESSION['uid']);
	}
	if(isset($_SESSION['logged_in'])){
		unset($_SESSION['logged_in']);
	}
	header('Location:articles/');

}



?>