<?php

require_once('words.php');
require_once('lib/HashGenerator.php');
require_once('lib/Hashids.php');

$hashids = new Hashids\Hashids('itbullshit');

if($_REQUEST['id']){
	$reqnum = $hashids->decode(addslashes($_REQUEST['id']));
	$hasid = true;
}

$nums = array(
	1 => $hasid ? $reqnum[0] : rand(0,count($words[1])-1),
	2 => $hasid ? $reqnum[1] : rand(0,count($words[2])-1),
	3 => $hasid ? $reqnum[2] : rand(0,count($words[3])-1),
	4 => $hasid ? $reqnum[3] : rand(0,count($words[4])-1)
);

$hash = $hashids->encode($nums[1], $nums[2], $nums[3], $nums[4]);

$data = array(
	'bullshit' => $words[1][$nums[1]] . " " . $words[2][$nums[2]] . " " . $words[3][$nums[3]] . " " . $words[4][$nums[4]] . ".",
	'hash' => $hash
);

//check if empty
if(!$words[1][$nums[1]] || !$words[2][$nums[2]] || !$words[3][$nums[3]] || !$words[4][$nums[4]]){
	$data['error'] = array('message' => 'Hiányzik az egyik szó!', 'index' => $nums, 'words' => array($words[1][$nums[1]] , $words[2][$nums[2]] , $words[3][$nums[3]] , $words[4][$nums[4]]));
}

header('Content-Type: application/json');

if(isset($_GET['callback'])){
	echo $_GET['callback']."(".json_encode($data).")";
} else {
	echo json_encode($data);
}

?>