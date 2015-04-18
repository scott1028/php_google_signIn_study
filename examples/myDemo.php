<?php

session_start();

// enable extension=php_openssl.dll
require_once realpath(dirname(__FILE__) . '/../src/Google/autoload.php');

$client = new Google_Client();
$client->setApplicationName("OAuth Proxy");
$client->setClientId("101418681396-4r2fodu9vkhmn8kn4r8mkhf43n42ba4b.apps.googleusercontent.com");
$client->setClientSecret("R2nbM1SeNZQTQ1pCf0DHJKMp");
$client->setRedirectUri("http://localhost:8080/myDemoLogined.php");
$client->addScope(array(
    // Know your basic profile info and list of people in your circles.
    // "https://www.googleapis.com/auth/plus.login",
    // Know who you are on Google
    "https://www.googleapis.com/auth/plus.me",
    // View your email address
    "https://www.googleapis.com/auth/userinfo.email",
    // View basic information about your account
    "https://www.googleapis.com/auth/userinfo.profile"
));
echo "<a href='" . $client->createAuthUrl() . "'>Login with Google+</a>";

?>