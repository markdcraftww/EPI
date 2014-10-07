<?php
session_start();
require_once("twitteroauth.php"); //Path to twitteroauth library
 
$twitteruser = $_GET['username'];
$notweets = $_GET['limit'];
$consumerkey = "ZvxvktelVAjsITil7wyQTw";
$consumersecret = "OypcpNfAuFXdmV8dTOVRJKmRiS8xNTbDdQYD2iU";
$accesstoken = "5682582-adHGsTe47vjqOGjgzNSXoGkNDzxC8R2B8eIl3mlHGl";
$accesstokensecret = "NW3cUYADuDYHZXL0ZLBvDOW8SsGCCKMVruKyZz3Gf3yKX";
 
function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  return $connection;
}
  
$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
 
$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
 
echo json_encode($tweets);
?>