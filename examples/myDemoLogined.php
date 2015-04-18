<?php

session_start();

// enable extension=php_openssl.dll
require_once realpath(dirname(__FILE__) . '/../src/Google/autoload.php');

$client = new Google_Client();
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

if($_GET['code']){
    $client->authenticate($_GET['code']);
    $access_token = $client->getAccessToken();

    echo 'Google Response:<br />';
    var_dump($access_token);
    echo '<br />';
    echo '<br />';

    echo 'Response To JSON:<br />';
    $_SESSION['access_token'] = json_decode($access_token)->{'access_token'};
    echo $_SESSION['access_token'];
    echo '<br />';
    echo '<br />';

    var_dump($_SESSION);
    echo '<br />';
    echo '<br />';
}
else{
    echo 'google login, please!';
    exit;
}

// due to "exit;"
echo 'user has logined.';
echo "<br />";

function call_api($accessToken, $url){
    // enable extension=php_curl.dll
    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

    // disable SSL peer Check
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $curlheader[0] = "Authorization: Bearer " . $accessToken;
    curl_setopt($curl, CURLOPT_HTTPHEADER, $curlheader);
    $json_response = curl_exec($curl);

    curl_close($curl);
    
    $responseObj = json_decode($json_response);
    return $responseObj; 
}

// invoke logined user data
$accountObj = call_api($_SESSION['access_token'], "https://www.googleapis.com/oauth2/v1/userinfo");

echo 'User Data:';
echo '<br />';
var_dump($accountObj);


?>