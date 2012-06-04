<?php
require_once ('/usr/share/php/libzend-framework-php/Zend/Gdata.php');
require_once ('/usr/share/php/libzend-framework-php/Zend/Gdata/ClientLogin.php');
require_once ('/usr/share/php/libzend-framework-php/Zend/Gdata/YouTube.php');
// Enter your Google account credentials
$username = 'stanford.crypto@gmail.com';
$passwd = 'Iks0jfisdf0mq2KKx';
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


$developerKey = "AI39si6XnLpHKQofAlknA2RvYaGTmAIi3oaaF06IT7ibI_2QM-M_QSdoD9bPZ5AIiqfKceCETIhZg1smyIc8yFhBawS9zoCFnA";
$applicationId = "Online Course";
$clientId = "";
$yt = new Zend_Gdata_YouTube($httpClient,
                             $applicationId,
                             $clientId,
                             $developerKey);

$yt->setMajorProtocolVersion(2);
$query = $yt->newVideoQuery();
$query->setAuthor($username);
$query->setMaxResults(50);
//echo $query->getQueryUrl(2);
$start=1;
while ($start % 50 == 1) {
  $feed = $yt->getVideoFeed("http://gdata.youtube.com/feeds/api/users/default/uploads?max-results=50&start-index=".$start);
  foreach ($feed as $video) {
    echo $video->getVideoId().":".$video->getVideoTitle()." 
";
    file_put_contents($video->getVideoTitle().'/vidID.json', json_encode($video->getVideoID()));
    $start++;
  }
}

?>
