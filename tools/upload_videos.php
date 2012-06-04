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

$myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();
 

$dirs_ary = glob('*',GLOB_ONLYDIR);
foreach ($dirs_ary as $dir) {


  $filestring = file_get_contents($dir.'/lecture_settings.html');
  $dom = new DOMDocument();
  @$dom->loadHTML($filestring);
  $vidName = $dom->getElementById("source_video")->getAttribute('value');
  $lectureTitle = $dom->getElementById("title")->getAttribute('value');

  if ($lectureTitle=="CKY Example (21:52)" ||
      $lectureTitle=="CKY Parsing (23:25)" ||
      $lectureTitle=="Charniak's Model (18:23)" ||
      $lectureTitle=="Discriminative Model Features") {
  echo $lectureTitle . ": " . $vidName . "\n";

  
  $filesource = $yt->newMediaFileSource('../source_videos/'.$vidName);
    $filesource->setContentType('video/mp4');
    $filesource->setSlug($vidName);
 
    $myVideoEntry->setMediaSource($filesource);
 
    
    $myVideoEntry->setVideoTitle($lectureTitle);
    $myVideoEntry->setVideoDescription($lectureTitle);
    // Note that category must be a valid YouTube category !
    $myVideoEntry->setVideoCategory('Education');
 
    // Set keywords, note that this must be a comma separated string
    // and that each keyword cannot contain whitespace
    $myVideoEntry->SetVideoTags('natural language processing');
    $myVideoEntry->SetVideoDeveloperTags(array('NLPClass', substr($lectureTitle,0,16)));

    //Turn off ratings, comments, videoResponses and make video unlisted

    $listElement = new Zend_Gdata_App_Extension_Element('yt:accessControl', 'yt', 'http://gdata.youtube.com/schemas/2007', ''); 
    $listElement->extensionAttributes = array(array('namespaceUri' => '', 'name' => 'action', 'value' => 'list'), array('namespaceUri' => '', 'name' => 'permission', 'value' => 'denied'));

    $commentElement = new Zend_Gdata_App_Extension_Element('yt:accessControl', 'yt', 'http://gdata.youtube.com/schemas/2007', ''); 
    $commentElement->extensionAttributes = array(array('namespaceUri' => '', 'name' => 'action', 'value' => 'comment'), array('namespaceUri' => '', 'name' => 'permission', 'value' => 'denied'));

    $videoRespondElement = new Zend_Gdata_App_Extension_Element('yt:accessControl', 'yt', 'http://gdata.youtube.com/schemas/2007', ''); 
    $videoRespondElement->extensionAttributes = array(array('namespaceUri' => '', 'name' => 'action', 'value' => 'videoRespond'), array('namespaceUri' => '', 'name' => 'permission', 'value' => 'denied'));

    $rateElement = new Zend_Gdata_App_Extension_Element('yt:accessControl', 'yt', 'http://gdata.youtube.com/schemas/2007', ''); 
    $rateElement->extensionAttributes = array(array('namespaceUri' => '', 'name' => 'action', 'value' => 'rate'), array('namespaceUri' => '', 'name' => 'permission', 'value' => 'denied'));

 
    $myVideoEntry->extensionElements = array($listElement, $commentElement, $videoRespondElement, $rateElement);

    // Upload URI for the currently authenticated user
    $uploadUrl =
    'http://uploads.gdata.youtube.com/feeds/users/default/uploads';
 
    // Try to upload the video, catching a Zend_Gdata_App_HttpException
    // if availableor just a regular Zend_Gdata_App_Exception
 
    
    try {
      $newEntry = $yt->insertEntry($myVideoEntry,$uploadUrl, 'Zend_Gdata_YouTube_VideoEntry');
    } catch (Zend_Gdata_App_HttpException $httpException) {
    echo $httpException->getRawResponseBody();
    } catch (Zend_Gdata_App_Exception $e) {
    echo $e->getMessage();
    }


    $vidID = $newEntry->getVideoId();
    file_put_contents($dir.'/vidID.json',json_encode($vidID));

    sleep(20);
  }
}


?>
