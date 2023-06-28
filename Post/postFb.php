<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../sdk/php-graph-sdk-5.x/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
    'app_id' => '154636180952262',
    'app_secret' => '0b2faa329e43335709569ae19c2b4235',
    'default_graph_version' => 'v13.0'
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['']; // Specify the required permissions

$loginUrl = $helper->getLoginUrl('https://localhost/oiu.php', $permissions);

// Redirect the user to the Facebook login page
header("Location: $loginUrl");
exit();
?>
