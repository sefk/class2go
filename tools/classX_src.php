<?php

 

$dirs_ary = glob('*',GLOB_ONLYDIR);
foreach ($dirs_ary as $dir) {


  $filestring = file_get_contents($dir.'/lecture_settings.html');
  $dom = new DOMDocument();
  @$dom->loadHTML($filestring);
  $vidName = $dom->getElementById("source_video")->getAttribute('value');
  $lectureTitle = $dom->getElementById("title")->getAttribute('value');

  echo "$dir\n";

  exec("mkdir /opt/courseware/classX_src/$dir");
  exec("cp /opt/courseware/source_videos/$vidName /opt/courseware/classX_src/$dir/video.mp4");
  exec("cp /opt/courseware/nlp_test/$dir/lecture.pdf /opt/courseware/classX_src/$dir");

}


?>
