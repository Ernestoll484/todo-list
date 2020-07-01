<?php

require 'model/logic.php';

if (!empty($_GET['taskId'])) {
	$task = getDataById('list_id, status', 'tasks', $_GET['taskId']);
	if ($task['status'] == 0) {
		$newStatus = 1;
	} else if ($task['status'] == 1) {
		$newStatus = 0;
	}
	tickStatus($_GET['taskId'], $newStatus);
	header('Location: index.php?openList=' . $task['list_id']);
}
© 2020 GitHub, Inc.
