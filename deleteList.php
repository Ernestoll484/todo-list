<?php

require 'model/logic.php';

if (!empty($_GET['listId'])) {
	deleteTasksFromList($_GET['listId']);
	deleteList($_GET['listId']);
}
header('Location: index.php');