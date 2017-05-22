<?php
/**
 * This script is to be used to receive a POST with the object information and then either updates, creates or deletes the task object
 */
require('Task.class.php');

$task = new Task($_POST['TId']);

$Tname = htmlentities($_POST['TName']);
$Tdis = htmlentities($_POST['TDisc']);

function check(){
global $Tname;
global $Tdis;
if(!isset($Tname) || empty($Tname)) die(json_encode(array("status"=>0, "cause"=> "Name cant be empty")));
if(!isset($Tdis) || empty($Tdis)) die(json_encode(array("status"=>0, "cause"=> "Discryption cant be empty")));
}


switch($_POST['action']){
	case 'save':
		check();
		if(!$task->Exists()){
			die(json_encode(array("status"=>0, "cause"=> "Task does not exists")));
		}
	case 'create':
		check();
		$task->TaskName = $Tname;
		$task->TaskDescription = $Tdis;
		if($task->save()){
			echo json_encode(array("status"=>1));
		}else{
			echo json_encode(array("status"=>0, "cause"=> "Failed to save"));
		}
		die();
	case 'del':
		if($task->Delete()){
			echo json_encode(array("status"=>1));
		}else{
			echo json_encode(array("status"=>0, "cause"=> "Failed to delete"));
		}
		die();
}


?>