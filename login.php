<?php
$root = "website.com";

/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
include_once "incs/google-api-php-client/examples/templates/base.php";
session_start();
require_once 'incs/google-api-php-client/src/Google/autoload.php';

/************************************************
  ATTENTION: Fill in these values! Make sure
  the redirect URI is to this page, e.g:
  http://localhost:8080/user-example.php
 ************************************************/
$client_id = 'REPLACE_THIS_WITH_YOUR_CLIENT_ID';
$client_secret = 'REPLACE_THIS_WITH_YOUR_CLIENT_SECRET';
$redirect_uri = 'REPLACE_THIS_WITH_YOUR_REDIRECT_URL_FROM_DASHBOARD_WHICH_YOU_SET';
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->setScopes('email');
/************************************************
  If we're logging out we just need to clear our
  local access token in this case
 ************************************************/
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['access_token']);
}
/************************************************
  If we have a code back from the OAuth 2.0 flow,
  we need to exchange that with the authenticate()
  function. We store the resultant access token
  bundle in the session, and redirect to ourself.
 ************************************************/
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($root.'/articles', FILTER_SANITIZE_URL));
}
/************************************************
  If we have an access token, we can make
  requests, else we generate an authentication URL.
 ************************************************/
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
}
/************************************************
  If we're signed in we can go ahead and retrieve
  the ID token, which is part of the bundle of
  data that is exchange in the authenticate step
  - we only need to do a network call if we have
  to retrieve the Google certificate to verify it,
  and that can be cached.
 ************************************************/
if ($client->getAccessToken()) {
  $_SESSION['access_token'] = $client->getAccessToken();
  $token_data = $client->verifyIdToken()->getAttributes();
}
if (strpos($client_id, "googleusercontent") == false) {
  echo missingClientSecretsWarning();
  exit;
}
?>
<div class="box">
  <div class="request">
<?php
if (isset($authUrl)) {
  echo "<a class='login' href='" . $authUrl . "'>Log in</a>";
} 
?>
  </div>

  <div class="data">
<?php 
if (isset($token_data)) {
  $con = new mysqli(host,user,pass,"base");
  $uemail  = $token_data['payload']['email'];
  $uid  = generate_user_id();
  $qry = sprintf("INSERT INTO users (user_id,user_email,user_date,user_time) VALUES('%s','%s',CURRENT_DATE,CURRENT_TIME)",$uemail,$uid);
  $res = $con->query($qry);
  if($res){
    header('Location:articles/');
  }
}



function generate_user_id(){
  $id = date('hmi');
  $id = md5($id);
  return $id;
}


?>
  </div>
</div>
