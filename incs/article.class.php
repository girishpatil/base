<?php

require_once 'db_details.php';
require_once 'is_logged.php';

/*
	this clas handles both article creation and editing of the article
	
	creating an article
		args:
			the article
			category
			title
	editing the article
		args:
			the edit
			article id
			userid of the person who edits

*/


class article{

	private $con;
	public $msg = array();

	function __construct($data,$type){
		if($type=="" || $type!="article" || $type!="edit"){
			//redirect to home
			header('Location:').$_SERVER['PHP_SELF'];
		}
		$this->deal_with_sess();
		$this->user_id = $_SESSION['uid'];//taking the userid from the session.

		$this->start_con('base');
		$data = array_map(array($this,"clean_data"), $data);
		if($type=="article"){
			if($this->handle_article($data)){
				$_SESSION['msg']="Thank you!! your article has been submitted.";
				header('Location:/projects/vtu3/articles/create/');
			}else{
				// redirect over here itself.
			}
		}else if($type=="edit"){
			if($this->handle_article_edit($data)){
				$_SESSION['msg']="Thank you!! your edit has been submitted.";
				header('Location:/projects/vtu3/articles/create/');
			}else{
				// redirect over here itself.
			}
		}

	}

	public function deal_with_sess(){
		if(!isset($_SESSION)){
			session_start();
		}
	}

	public function handle_article($stuff){

		if($stuff['title']=="" || $stuff['cate']=="" || $stuff['cate']==0 || $stuff['article']==""){
			$_SESSION['msg'] = "Please complete all the fields";
			return false;
		}
		$this->article_id = $this->generate_article_id();
		if(!$this->is_valid_cate($stuff['cate'])){
			$_SESSION['msg'] = "Please choose a valid category";
			return false;
		}
		// preparing the query statement.
		$qry = sprintf("INSERT INTO articles (article_id,user_id,cate,article,article_title,article_date,article_time) VALUES('%d','%s','%d','%s','%s',CURRENT_DATE,CURRENT_TIME)",$this->article_id,$this->user_id,$stuff['cate'],$stuff['article'],$stuff['title']);
		if($this->con->query($qry)){
			return true;
		}
		return false;
	}

	public function handle_article_edit($stuff){
		if($stuff['edit']==""){
			$_SESSION['msg'] = "Please complete all the fields";
			return false;
		}
		$this->article_id = $stuff['aid'];
		$this->user_id    = $stuff['uid'];
		$this->generate_edit_id();
		$qry = sprintf("INSERT INTO edits (edit_id,article_id,user_id,edit_date,edit_time,edit) VALUES('%s','%d','%s',CURRENT_DATE,CURRENT_TIME,'%s')",$this->edit_id,$this->article_id,$this->user_id,$stuff['edit']);
		
		if($this->con->query($qry)){
			return true;
		}
		return false;
	}


	public function is_valid_cate($c){
		switch ($c) {
			case 10: return true;//important questions.
				break;
			case 20: return true;//sports
				break;
			case 30 : return true;//concepts in chapters
				break;
			case 40 : return true;//others
				break;
			default: return false;
				break;
		}
		return false;
	}

	public function clean_data($f){
		return mysqli_real_escape_string($this->con,$f);
	}

	private function start_con($db){
		// function to start a db connection
		$this->con = new mysqli(host,user,pass,$db);
	}

	private function generate_edit_id(){
		$eid = "";
		$eid = md5(mt_rand(10000,100000));
		$this->edit_id = $eid;
	}

	private function generate_article_id(){
		$aid = "";
		$aid = md5(mt_rand(0,10000));
		$this->article_id = $aid;
	}

}



?>