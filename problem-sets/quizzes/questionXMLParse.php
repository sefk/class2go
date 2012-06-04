<?php

$dirs_ary = glob('*',GLOB_ONLYDIR);


foreach ($dirs_ary as $dir) {

  $xmlString = file_get_contents("$dir/question.xml");
  $xmlObj = simplexml_load_string($xmlString,"SimpleXMLElement", LIBXML_NOCDATA);

  $jsonString = json_encode($xmlObj);
  file_put_contents("$dir/question.json",$jsonString);


}
?>