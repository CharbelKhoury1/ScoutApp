<?php
if(!session_id()){
    session_start();
}

// Include the autoloader provided in the SDK
require_once '../sdk/php-graph-sdk-5.x/src/Facebook/autoload.php';


// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

/*
 * Configuration and setup Facebook SDK
 */
$appId         = '1959252487767032'; //Facebook App ID
$appSecret     = 'ba1e13e19de5facfd490492460782a61'; //Facebook App Secret
$redirectURL   = 'http://localhost3000/Post/'; //Callback URL
$fbPermissions = array('pages_manage_posts' , 'pages_read_engagment'); //Facebook permission

$fb = new Facebook(array(
    'app_id' => $appId,
    'app_secret' => $appSecret,
    'default_graph_version' => 'v17.0',
));

// Get redirect login helper
$helper = $fb->getRedirectLoginHelper();

// Try to get access token
try {
    if(isset($_SESSION['facebook_access_token'])){
        $accessToken = $_SESSION['facebook_access_token'];
    }else{
        $accessToken = $helper->getAccessToken();
    }
} catch(FacebookResponseException $e) {
     echo 'Graph returned an error: ' . $e->getMessage();
      exit;
} catch(FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
}
?>