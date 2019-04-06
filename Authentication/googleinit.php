<?php
require ("vendor/autoload.php");

$g_client = new Google_Client();
$g_client->setClientId("app_id");
$g_client->setClientSecret("secret_key");
$g_client->setRedirectUri('http://localhost/blog-cms/authentication/');
$g_client->setScopes("email");

//function to save access token to json file
//$KEY_LOCATION = __DIR__ . '/client_secret.json';

//Google created authorization url
$glogin_url = $g_client->createAuthUrl();

//Google authorization  code
$code = isset($_GET['code']) ? $_GET['code'] : NULL;


//Fetch access token
if(isset($code)) {
  try {
 
      $gaccess_token = $g_client->fetchAccessTokenWithAuthCode($code);
      $_SESSION['accesstoken'] = $gaccess_token;
      $g_client->setAccessToken($_SESSION['accesstoken']);
      
      header('Location: index.php');


  }catch (Exception $e){
      echo $e->getMessage();
  }

  try {
      $user = $g_client->verifyIdToken();
      //$user = $plus->people->get('');

  }catch (Exception $e) {
      echo $e->getMessage();
  }
} else{
  $user = null;
}
if(isset($_SESSION['accesstoken'])){
  //Whatever you want to do once user is verified
  try{
    echo "Logged in";

  }catch(Exception $e){
    echo $e->getMessage();
 }
}

