<?php

require 'model/logic.php';

if (!empty($_GET['taskId'])) {
	$listId = getDataById('list_id', 'tasks', $_GET['taskId']);
	deleteSingleTask($_GET['taskId']);
}
header('Location: index.php?openList=' . $listId['list_id']);