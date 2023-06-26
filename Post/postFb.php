<?php

function checkInternetConnection()
{
  $connected = @fsockopen("www.facebook.com", 80);
  if ($connected) {
    fclose($connected);
    return true; // Internet connection established
  } else {
    return false; // No internet connection
  }
}

if (checkInternetConnection()) {
  require_once '../sdk/php-graph-sdk-5.x/src/Facebook/autoload.php';
  $app_id = '257544993552973 ';
  $app_secret = '36f77fb166017bf958ac5247988ebb12';
  $access_token = 'EAADqPF3auk0BAElytvEfnQn6YHZCKcebZCSOVJtLlilPchRoY9GLV4MG0xqXeFXPqfuN6Kqvh6aMhew46PacyvhMRH5oMYbkKGys2h7zmqP6ihhSlok1EDZBmWHbEvfqNOTL6HAAIad50ITDmXo8RGeb217DO79erbNOVzlTB40rO0KG73Y';

  $fb = new Facebook\Facebook([
    'app_id' => $app_id,
    'app_secret' => $app_secret,
    'default_graph_version' => 'v17.0',
  ]);

  $fb->setDefaultAccessToken($access_token);
      

      try {
        $response = $fb->post('/me/feed', ['message' => 'Hello, Facebook!']);
        $graphNode = $response->getGraphNode();
        echo 'Post ID: ' . $graphNode['id'];

      } catch (Facebook\Exceptions\FacebookResponseException $e) {
        // Handle API errors
        echo 'Graph returned an error: ' . $e->getMessage();
      } catch (Facebook\Exceptions\FacebookSDKException $e) {
        // Handle SDK errors
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
      }
    } else {
      echo '<p class="error-message">No internet connection. Please check your network connection and try again.</p>';
    }


    
    ?>