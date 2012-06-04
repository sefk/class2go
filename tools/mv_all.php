<?php
$dirs_ary = glob('*',GLOB_ONLYDIR);
foreach ($dirs_ary as $dir) {
  $cmd = 'cp index.html "'.$dir.'"';
  exec($cmd);
  
}

?>