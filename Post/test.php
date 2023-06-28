

<?php

require_once '../sdk/php-graph-sdk-5.x/src/Facebook/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);


$fb = new Facebook\Facebook([
  'app_id' => '154636180952262',
  'app_secret' => '0b2faa329e43335709569ae19c2b4235',
  'default_graph_version' => 'v13.0',
]);

$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch (Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch (Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (!isset($accessToken)) {
  // Redirect to login page or display an error message
  exit;
}

// Use the access token to make API requests or perform actions on behalf of the user

// Example: Publish a post to a Facebook page
$pageId = '689296817927096';
$message = 'Hello, Facebook!';

try {
  $response = $fb->post("/$pageId/feed", ['message' => $message], $accessToken);
  $postId = $response->getDecodedBody()['id'];
  echo 'Post ID: ' . $postId;
} catch (Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
} catch (Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
}
?>

