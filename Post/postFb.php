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
  $app_id = '1250484182494643';
  $app_secret = 'ce9dfe54a8f90b0230f61871e3045236';
  $access_token = 'EAARxTwlZBrbMBAOLCLMZB94XtagZA9kOOUX5y3lgUQcitYUICSsEFaWAKrCW3itLCNLyuzDZB50ZBPOrVldeZA3ltZAuZCAcUTJqkyzJWCwDNec4xRMK9hd2F22Rx5ppWFTOl6ZBXpaLgBYu6ZCSRV0YNaClqq8pU7TroxW9C6IkRiGhQ0XLWuCxxY1nCf8noU3GU3hdST0qwyiwZDZD';

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