<?php
$dirs_ary = glob('*',GLOB_ONLYDIR);
foreach ($dirs_ary as $dir) {
  $cmd = 'wget http://cware-dev2.stanford.edu/demo/'.rawurlencode($dir).'/lecture_annotated.pdf -O "'.$dir.'/lecture_annotated.pdf" &';
  exec($cmd);
  $cmd = 'wget http://cware-dev2.stanford.edu/demo/'.rawurlencode($dir).'/video.mp4 -O "'.$dir.'/video.mp4" &';
  exec($cmd);
}

?>