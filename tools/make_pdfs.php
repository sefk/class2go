<?php
$dirs_ary = glob('*',GLOB_ONLYDIR);
foreach ($dirs_ary as $dir) {
  $cmd = 'convert -trim +repage "'.$dir.'/lecture.pdf" "'.$dir.'/lecture.jpg"';
  exec($cmd);
}

?>