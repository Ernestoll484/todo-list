<?php

require 'model/logic.php';

if (!empty($_POST['taskDescription'])) {
	$taskDuration = intval($_POST['taskDuration']);
	addTaskToList($_GET['listId'], $_POST['taskDescription'], $taskDuration);
}
header('Location: index.php?openList=' . $_GET['listId']);