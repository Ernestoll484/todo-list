<?php

require 'model/logic.php';

if (!empty($_POST['newListName'])) {
	editListName($_GET['listId'], $_POST['newListName']);
}
header('Location: index.php?openList=' . $_GET['listId']);