<?php
require_once '../sdk/php-graph-sdk-5.x/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '1959252487767032',
  'app_secret' => 'ba1e13e19de5facfd490492460782a61',
  'default_graph_version' => 'v17.0',
]);

$access_token = 'EAAb17gSPAZCgBADwBfeD9Pr29TfdOIeqEtxOUbAAkBAXY0zCtomAOisWy32RUXzL8NbnoshrIB7ntj64Lg2r5vnIlQVYLrFrCcn0n9po6VcRZAX3wBuHQD3WdHMcosKFRhBVovPrRVS3BM9vUBCPEqNCNxXVTqW4EXNUlkngZDZD'; // Replace with the access token you obtained

try {
  $response = $fb->post('/689296817927096/feed', [
    'message' => 'Hello, Facebook!',
    'name' => 'My Post', // Add a name parameter
    'access_token' => $access_token,
  ]);
  
  $graphNode = $response->getGraphNode();
  
  echo 'Post ID: ' . $graphNode['id'];
} catch (Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
} catch (Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
}
?>
