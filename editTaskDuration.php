<?php

require 'model/logic.php';

if (!empty($_POST['newTaskDuration'])) {
	$listId = getDataById('list_id', 'tasks', $_GET['taskId']);
	editTaskDuration($_GET['taskId'], $_POST['newTaskDuration']);
}
header('Location: index.php?openList=' . $listId['list_id']);