<?php
// Include FB configuration file


//require_once 'fbconfig.php';


if(isset($accessToken)){
    if(isset($_SESSION['facebook_access_token'])){
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }else{
        // Put short-lived access token in session
        $_SESSION['facebook_access_token'] = (string) $accessToken;
        
        // OAuth 2.0 client handler helps to manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();
        
        // Exchanges a short-lived access token for a long-lived one
        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
        $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
        
        // Set default access token to be used in script
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }
    
    //FB post content
    $message = 'Test message from CodexWorld.com website';
    $title = 'Post From Website';
    //$link = 'http://www.codexworld.com/';
    $description = 'CodexWorld is a programming blog.';
    //$picture = 'http://www.codexworld.com/wp-content/uploads/2015/12/www-codexworld-com-programming-blog.png';
            
    $attachment = array(
        'message' => $message,
        'name' => $title,
        //'link' => $link,
        'description' => $description,
        //'picture'=>$picture,
    );

    $postId = $response->getDecodedBody()['id'];
    
    try{
        // Post to Facebook
        $fb->post('/me/feed', $attachment, $accessToken);
        
        // Display post submission status
        echo 'The post was published successfully to the Facebook timeline.';
        echo  'Post ID: ' . $graphNode['id'];
    } catch (Facebook\Exceptions\FacebookResponseException $e) {
        // Handle API errors
        echo 'Graph returned an error: ' . $e->getMessage();
        exit();
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        // Handle SDK errors
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit();
    }
}else{
    // Get Facebook login URL
    $fbLoginURL = $helper->getLoginUrl('http://localhost3000/Post/', $fbPermissions);
    
    // Redirect to Facebook login page
    //echo '<a href="'.$fbLoginURL.'"><img src="fb-btn.png" /></a>';
    echo '<a href="'.$fbLoginURL.'"><img src="fb-btn.png" /></a>';
    
}