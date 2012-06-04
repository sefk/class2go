<?php
/* Offset variables "fudge-factors" in the conversion */
$xoffset_mc = -15;
$yoffset_mc = -15;
$xoffset_sa = -10;
$yoffset_sa = -25;
function util_px_arith($pxstring, $adj) {
  $px=0;
  sscanf($pxstring, " %dpx ", $px);
  return ($px+$adj).'px';
}

//Load coursera template xml
$xmlstring = file_get_contents('display_templates.xml');
$templateCoursera = simplexml_load_string($xmlstring);


$dirs_ary = glob('*',GLOB_ONLYDIR);



foreach ($dirs_ary as $dir) {
  print $dir. "\n";
  exec('rm "'.$dir.'/questions.json"');
  if($xmlstring = file_get_contents($dir.'/question.xml')) {
 
    $xml = simplexml_load_string($xmlstring);
    $questions = $xml->xpath("//question[@id]");
    $questionsJSON = Array('videoWidth'=>960,'videoHeight'=>540);
    foreach ($questions as $question) {
      $time = (int)round((float)$question->data->video['time']);

      if ($time != 0) {//For some reason, questions at time 0 don't display on Coursera.

	$outputdir = "q_$time";
	//Take a snapshot at the question time
	$mplayer_cmd = sprintf('mplayer -ao null -vo jpeg:quality=100:outdir=%s -ss %d -frames 1 "%s/student_lowres.mp4"',$outputdir,$time,$dir);
	echo($mplayer_cmd);
	exec($mplayer_cmd);
	$cp_cmd=sprintf('cp "%s/00000001.jpg" "%s/q_%d.jpg"',$outputdir,$dir,$time);
	$rm_cmd=sprintf('rm -rf "%s"',$outputdir);
	exec($cp_cmd);
	exec($rm_cmd);

	//load specific template;
	$xpQuery = "//display[@load_template_id='".$question->data->video->display['load_template_id']."']";
	$templates = $templateCoursera->xpath($xpQuery);
	$template = $templates[0];

	//Setup default object which will eventually be output as JSON
	$json = Array(
		      'time'=>intval($time),
		      'bgOpacity'=>'0',            //defaults
		      'fontColor'=>'rgb(0,0,0)',  //defaults to black
		      'buttonPos'=>Array('left'=>'720px','top'=>'490px'),  //default buttom right
		      'qPos'=>Array('left'=>'auto','top'=>'auto','width'=>'800px','height'=>'100px')
		      );

	
	$bgSetting = (string)$question->data->video->display['background'];
    

	//Transparency
	switch ($bgSetting) {
	case "color":
	  $json['bgOpacity']='1';
	  break;
	case "transparent":
	case "video":
	  $json['bgOpacity']='0';
	break;
	}


	if(!isset($template->question_text) || (bool)$template->question_text['hide_text']) {	  
	  $json['qText']='';
	} else {
	  $json['qText']=(string)$question->data->text;
	}

	$json['qExplanation']=(string)$question->data->explanation;

	
	//Question position
	if (isset($template->question_text)) {
	  $json['qPos']=Array(
			      'left'=>util_px_arith((string)$template->question_text['x'],$xoffset_mc),
			      'top'=>util_px_arith((string)$template->question_text['y'],$yoffset_mc),
			      'width'=>(string)$template->question_text['width'],
			      'height'=>(string)$template->question_text['height'],
			      );
	}

	//Case on question type to handle mulitple-choice and short answer differently
	//Multiple-choice questions
	switch((string)$question['type']) {
	case 'GS_Choice_Answer_Question' :

	  $json['qType']='m-c';
	  $json['mcType']=(string)$question->metadata->parameters->choice_type;
	  //Handle answers
	  $answers = Array();
	  $optionNum = 0;
	  foreach ( $question->data->option_groups->option_group->option as $option) {
	    $optTemplate =  $template->question_option[$optionNum];
	    $answer = Array();

	    //Answer text
	    if ((bool)$optTemplate['hide_text']) {
	      $answer['text']='';
	    } else {
	      $answer['text']=(string)$option->text;
	    }
      
	    //Should be selected or not

	    if ($option['selected_score']==0) {
	      $answer['correct']=false;
	    } else {
	      $answer['correct']=true;
	    }

	    //Answer Positioning
	    $answer['tablePos'] = Array (
					 'left' => util_px_arith((string)$optTemplate['x'],$xoffset_mc),
					 'top' => util_px_arith((string)$optTemplate['y'],$yoffset_mc)
					 );
	    $answer['aSize'] = Array (
				      'width' => (string)$optTemplate['width'],
				      'height' => (string)$optTemplate['height']
				      );


	    $answers[$optionNum+1]=$answer;
	    $optionNum++;
	  }

	  $json['answers']=$answers;
	  
	  
	  break; //case  'GS_Choice_Answer_Question'

	case 'GS_Short_Answer_Question_Simple':
	  
	  $json['qType']='s-a';
	  //Handle answers
	  
	  $option = $question->data->option_groups->option_group->option;

	  
	  $optTemplate =  $template->question_option[0];

	  //Answer text
	  $json['aText']=(string)$option->text;
	  $json['isRegexp']=true; // all of these are regexp
	  $json['fontColor']='rgb(255,255,255)';

	  //Answer Positioning
	  $json['aPos'] = Array (
				 'left' => util_px_arith((string)$optTemplate['x'],$xoffset_sa),
				 'top' => util_px_arith((string)$optTemplate['y'],$yoffset_sa),
				 'width' => (string)$optTemplate['width'],
				 'height' => (string)$optTemplate['height']
				 );

	  break;
	default:
	  echo "Unknown question type: ".(string)$question['type']."\n";
      
	}

	$questionsJSON[''.$time]=$json;
      }
    }

    file_put_contents($dir.'/questions.json',json_encode($questionsJSON));
  }
}
?>