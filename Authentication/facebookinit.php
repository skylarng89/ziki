<?php
session_start();

require './vendor/autoload.php';

$fb = new Facebook\Facebook([
    'app_id'=>'app_id',
    'app_secret' => 'secret_key',
    'default_graph_version' => 'v3.2'
]);

$helper = $fb->getRedirectLoginHelper();
$login_url = $helper->getLoginUrl('http://localhost/blog-cms/authentication/');

try{
  $access_token = $helper->getAccessToken();
  if(isset($access_token)){
    $_SESSION['access_token'] = (string)$access_token;
    header("Location: index.php");
  }
}
  catch(Exception $e){
    echo $e->getTraceAsString();
  }

  if(isset($_SESSION['access_token'])){
    try{
        $fb->setDefaultAccessToken($_SESSION['access_token']);
        $result = $fb->get('/me?local=en_US&fields=name,email');
        $user = $result->getGraphUser();
        //echo  $user->getField('name') ." is logged in using facebook!";
        echo "Logged in";
    } catch(Exception $e){
      echo $e->getTraceAsString();

    }
  }
?>