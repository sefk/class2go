<?php 
$title = rawurlencode($_GET['title']);
$fullpath = '/opt/courseware/nlp_test/source_videos';


$url = $_GET['url'];

$fname = $_GET['fname'];

$cmd2 = 'wget --load-cookies cookies.txt -O "'.$fullpath.'/'.$fname.'" "'. $url .'" &';
echo ($cmd2);
$cmd3 = 'wget --load-cookies cookies.txt '. $url ."&";

?>