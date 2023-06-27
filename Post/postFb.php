


<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../sdk/php-graph-sdk-5.x/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '257544993552973',
  'app_secret' => '36f77fb166017bf958ac5247988ebb12',
  'default_graph_version' => 'v17.0',
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['pages_show_list' , 'pages_read_engagement' , 'pages_manage_posts']; // Add any additional permissions you need

$loginUrl = $helper->getLoginUrl('http://localhost:3000/Post/postFb.php', $permissions);


// Redirect the user to the login URL

// After the user grants permission and is redirected to the callback URL:
$accessToken = $helper->getAccessToken();

if (isset($accessToken)) {
  // The user has granted permission, and you have the access token
  try {
    // Create a new post
    $response = $fb->post('/me/feed', ['message' => 'Hello, Facebook!', 'access_token' => $accessToken]);
    
    // Get the post ID
    $postId = $response->getDecodedBody()['id'];
    
    echo 'Post created. ID: ' . $postId;
  } catch (Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
  }
} else {
  // Access token not obtained
  // Handle the error or display an appropriate message
}
?>
