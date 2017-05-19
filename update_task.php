<?php
/**
 * This script is to be used to receive a POST with the object information and then either updates, creates or deletes the task object
 */
require('Task.class.php');

$task = new Task($_POST['TId']);
print_r($task);
print_r($_POST);

switch($_POST['action']){
	case 'save':
		$Tname = htmlentities($_POST['TName']);
		$Tdis = htmlentities($_POST['TDisc']);
		$task->TaskName = $Tname;
		$task->TaskDescription = $Tdis;
		$task->save();
		die();
	case 'del':
		$task->Delete();
		die();
}


?>