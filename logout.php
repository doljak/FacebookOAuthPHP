<?php

session_start();
require_once __DIR__ . '/src/Facebook/autoload.php';


echo '<h3>Getting Access Token information</h3>';
if (isset($_SESSION['fb_access_token'])) {
        echo '$_SESSION[fb_access_token] ==>' .$_SESSION['fb_access_token'];
        
    $fb = new Facebook\Facebook(['app_id' => '1115623171853481','app_secret' => '5d34f81d31b2ff2e60926e6c32f7e466','default_graph_version' => 'v2.4',]);

    try {  // Returns a `Facebook\FacebookResponse` object
      $response = $fb->get('/me?fields=id,name', $_SESSION['fb_access_token']);
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    $user = $response->getGraphUser();
    ?><br><?php
    echo 'Name: ' . $user['name'];
    ?><br><?php    
}  else {
    
    echo "Dont know about session";    
}
// remove all session variables
session_unset(); 

// destroy the session 
session_destroy(); 



?><br><?php
if (isset($_SESSION['fb_access_token'])) {
        echo '$_SESSION[fb_access_token] ==>' .$_SESSION['fb_access_token'];
        
    $fb = new Facebook\Facebook(['app_id' => '1115623171853481','app_secret' => '5d34f81d31b2ff2e60926e6c32f7e466','default_graph_version' => 'v2.4',]);

    try {  // Returns a `Facebook\FacebookResponse` object
      $response = $fb->get('/me?fields=id,name', $_SESSION['fb_access_token']);
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }

    $user = $response->getGraphUser();
    ?><br><?php
    echo 'Name: ' . $user['name'];
    ?><br><?php    
}  else {
    echo "Dont know about session";    
}



?>
