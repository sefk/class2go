<?php

//$xmlString = file_get_contents('advanced-maxent.xml');
$xmlString = file_get_contents('information-retrieval.xml');
//echo 'xml string: ' . $xmlString;
$xmlObj = simplexml_load_string($xmlString,"SimpleXMLElement", LIBXML_NOCDATA);

$jsonString = json_encode($xmlObj);
//echo 'json: ' . $jsonString;
file_put_contents('advanced-maxent.json',$jsonString);

//$printString = print_r($xmlObj,true);
//file_put_contents('advanced-maxent.print_r',$printString);

?>
