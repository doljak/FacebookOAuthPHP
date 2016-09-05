<?php
ini_set('display_errors', 'On');
ini_set('html_errors', 0);
error_reporting(-1);
function ShutdownHandler()
{
if(@is_array($error = @error_get_last()))
{
return(@call_user_func_array('ErrorHandler', $error));
};
return(TRUE);
};
register_shutdown_function('ShutdownHandler');
function ErrorHandler($type, $message, $file, $line)
{
$_ERRORS = Array(
0x0001 => 'E_ERROR',
0x0002 => 'E_WARNING',
0x0004 => 'E_PARSE',
0x0008 => 'E_NOTICE',
0x0010 => 'E_CORE_ERROR',
0x0020 => 'E_CORE_WARNING',
0x0040 => 'E_COMPILE_ERROR',
0x0080 => 'E_COMPILE_WARNING',
0x0100 => 'E_USER_ERROR',
0x0200 => 'E_USER_WARNING',
0x0400 => 'E_USER_NOTICE',
0x0800 => 'E_STRICT',
0x1000 => 'E_RECOVERABLE_ERROR',
0x2000 => 'E_DEPRECATED',
0x4000 => 'E_USER_DEPRECATED'
);
if(!@is_string($name = @array_search($type, @array_flip($_ERRORS))))
{
$name = 'E_UNKNOWN';
};
return(print(@sprintf("%s Error in file \xBB%s\xAB at line %d: %s\n", $name, @basename($file), $line, $message)));
};
$old_error_handler = set_error_handler("ErrorHandler");
?>

<?php
if(!session_id()) {
session_start();
}
//ensure Facebook SDK is loaded
require_once __DIR__ . '/src/Facebook/autoload.php';

//Shake my hand!
$fb = new Facebook\Facebook(['app_id' => '1115623171853481','app_secret' => '5d34f81d31b2ff2e60926e6c32f7e466','default_graph_version' => 'v2.4',]);
$helper = $fb->getRedirectLoginHelper();

try {
$accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
// When Graph returns an error
echo 'Graph returned an error: ' . $e->getMessage();
//exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
// When validation fails or other local issues
echo 'Facebook SDK returned an error: ' . $e->getMessage();
//exit;
}

if (! isset($accessToken)) {
if ($helper->getError()) {
header('HTTP/1.0 401 Unauthorized');
echo "Error: " . $helper->getError() . "\n";
echo "Error Code: " . $helper->getErrorCode() . "\n";
echo "Error Reason: " . $helper->getErrorReason() . "\n";
echo "Error Description: " . $helper->getErrorDescription() . "\n";
} else {
header('HTTP/1.0 400 Bad Request');
echo 'Bad request';
}
exit;
}

try {
$response = $fb->get('/me?fields=id,name', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
echo 'Graph returned an error: ' . $e->getMessage();
exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
echo 'Facebook SDK returned an error: ' . $e->getMessage();
exit;
}

$user = $response->getGraphUser();

echo 'Name: ' . $user['name'];
?><br><?php
echo 'ID: ' . $user['id'];
// OR
// echo 'Name: ' . $user->getName();


// Logged in
echo '<h3>Access Token</h3>';
var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
echo '<h3>Metadata</h3>';
var_dump($tokenMetadata);

$tokenMetadata->validateAppId('1115623171853481');

$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
    exit;
  }

  echo '<h3>Long-lived</h3>';
  var_dump($accessToken->getValue());
}
echo '<h3>Storing Session Information</h3>';
echo "-->". $accessToken;
$_SESSION['fb_access_token'] = (string) $accessToken;
?><br> <?php
echo "-->". $user['name'];
?><br> <?php


header("Location: http://javaexampreparation.com/checksession.php"); /* Redirect browser */
exit();

?>

