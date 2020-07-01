<?php

require 'model/logic.php';

if (!empty($_POST['listName'])) {
	addNewList($_POST['listName']);
	$listId = getDataByColumn('id', 'lists', 'name', $_POST["listName"]);
}
header('Location: index.php?openList=' . $listId[0]['id']);