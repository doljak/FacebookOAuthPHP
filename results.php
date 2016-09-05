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
    
        echo 'ID: ' . $user['id'];
    ?><br><?php    
}  else {
    echo "Dont know about session";    
}

include($_SERVER['DOCUMENT_ROOT']."/dbconnection.php"); 


while ($row = mysqli_fetch_array($getUserResults)) {
$userResults[] = array(
'userid' => $row['userid'],
    'topic' => $row['topic'],
    'score' => $row['score'],
    'entry_date' => $row['entry_date']);
}


foreach ($userResults as $userResult): ?>


<h2><?php echo $userResult['userid'] . " Scored:" .$userResult['score']; ?></h2> 

<?php endforeach; ?>
