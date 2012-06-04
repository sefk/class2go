<?php
require_once ('/usr/share/php/libzend-framework-php/Zend/Gdata.php');
require_once ('/usr/share/php/libzend-framework-php/Zend/Gdata/ClientLogin.php');
require_once ('/usr/share/php/libzend-framework-php/Zend/Gdata/YouTube.php');
// Enter your Google account credentials
$username = 'stanfordnlpclass@gmail.com';
$passwd = 'parseitup';
$authenticationURL= 'https://www.google.com/accounts/ClientLogin';

try {

  $httpClient = Zend_Gdata_ClientLogin::getHttpClient(
						      $username,
						      $passwd,
						      $service = 'youtube',
						      $client = null,
						      $source = 'MySource', // a short string identifying your application
						      $loginToken = null,
						      $loginCaptcha = null,
						      $authenticationURL);
  
} catch (Zend_Gdata_App_CaptchaRequiredException $cre) {
  echo 'URL of CAPTCHA image: ' . $cre->getCaptchaUrl() . "\n";
  echo 'Token ID: ' . $cre->getCaptchaToken() . "\n";
  } catch (Zend_Gdata_App_AuthException $ae) {
    echo 'Problem authenticating: ' . $ae->exception() . "\n";
    }

$developerKey = "AI39si5GlWcy9S4eVFtajbVZk-DjFEhlM4Zt7CYzJG3f2bwIpsBSaGd8SCWts6V5lbqBHJYXAn73-8emsZg5zWt4EUlJJ4rpQA";
$applicationId = "class2go";
$clientId = "";
$yt = new Zend_Gdata_YouTube($httpClient,
                             $applicationId,
                             $clientId,
                             $developerKey);

$yt->setMajorProtocolVersion(2);
 

$dirs_ary = glob('*',GLOB_ONLYDIR);
foreach ($dirs_ary as $dir) {

  $myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();
  $filestring = file_get_contents($dir.'/vidID.json');
  $vidID = substr($filestring,1,-1);

  echo "$dir: $vidID\n";
  $videoEntry = $yt->getVideoEntry($vidID);

  echo 'Edit: ' . $videoEntry->getVideoWatchPageUrl() . "\n";

  
}


?>
