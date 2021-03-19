<?php
/* Connect to the database */
$mysqli = new mysqli("localhost", "pma", "DSA", "mysql");
if ($mysqli->connect_errno) {
     exit();
}
 
/* Set the DB charset to utf8 */
$mysqli->query("SET CHARACTER SET utf8");
 
/* Setup the Twitter API */
ini_set('display_errors', 1);
require_once('TwitterAPIExchange.php'); // Twitter API
 
/* Your Twitter app's credentials */
$settings = array(
     'oauth_access_token' => "1248276020865703938-SlyLvromlPC0VhAh5rwB6HteUi0Ni9",
     'oauth_access_token_secret' => "sBLsS6fVjiy3jYLvCjReRezpbughnjkDw49tEdLDvTEa2",
     'consumer_key' => "NjScgsDg5Zi1aQ6iA1GjlGEkB",
     'consumer_secret' => "CbomhpCJovqFbxTRwSfcxtsspRe2UxrydNqLfcgIXQEupS7x9A"
);
 
/* Twitter API version 1.1 and the endpoint search */
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = '?q=liverpool&count=30'; // We're searching for #liverpool and return 30 (max) tweets each time
$requestMethod = 'GET';
 
/* Get tweets with a specific word */
$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
     ->buildOauth($url, $requestMethod)
     ->performRequest();
$tweets = json_decode($response);
 
/* Insert each tweet into the database (prepared statement) */
foreach ($tweets->statuses as $tweet) {
     $query = $mysqli->prepare("INSERT INTO tweets (id_str, screen_name, tweet) VALUES (?, ?, ?)");
     $query->bind_param("sss", $tweet->id_str, $tweet->user->screen_name, $tweet->text);
     $query->execute();
     $query->close();
}
 
/* Delete duplicate screen names. Save the latest tweet. */
$query = $mysqli->prepare("DELETE n1 FROM tweets n1, tweets n2 WHERE n1.tweetID > n2.tweetID AND n1.screen_name = n2.screen_name");
$query->execute();
$query->close();
 
/* Close the connection */
$mysqli->close();
 
?>