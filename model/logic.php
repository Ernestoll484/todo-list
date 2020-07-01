<?php

require 'db.php';

function getDataById ($columns, $table, $id) {

	$conn = OpenCon();
	$query = $conn->prepare("SELECT $columns FROM $table WHERE id = $id");
	$query->execute();
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$result = $query->fetch();
	$conn = null;
	return $result;
}

function getDataByColumn ($columns, $table, $column, $value) {

	$conn = OpenCon();
	$query = $conn->prepare("SELECT $columns FROM $table WHERE $column = :value");
	$query->execute([':value'=>$value]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$result = $query->fetchAll();
	$conn = null;
	return $result;
}

function getAllData ($columns, $table) {

	$conn = OpenCon();
	$query = $conn->prepare("SELECT $columns FROM $table");
	$query->execute();
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$result = $query->fetchAll();
	$conn = null;
	return $result;
}

function getDataSorted ($columns, $table, $column, $value) {

	$conn = OpenCon();
	$query = $conn->prepare("SELECT $columns FROM $table WHERE $column = :value ORDER BY status ASC");
	$query->execute([':value'=>$value]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$result = $query->fetchAll();
	$conn = null;
	return $result;
}

function getDataFiltered ($columns, $table, $column, $value) {

	$conn = OpenCon();
	$query = $conn->prepare("SELECT $columns FROM $table WHERE $column = :value AND NOT status = 1");
	$query->execute([':value'=>$value]);
	$query->setFetchMode(PDO::FETCH_ASSOC);
	$result = $query->fetchAll();
	$conn = null;
	return $result;
}

function addTaskToList ($listId, $taskDescription, $taskDuration) {

	$conn = OpenCon();
	$query = $conn->prepare("INSERT INTO tasks (description, duration, list_id) VALUES (:description, :duration, :listId)");
	$query->execute([':description'=>$taskDescription, ':duration'=>$taskDuration, ':listId'=>$listId]);
	$conn = null;
}

function addNewList ($listName) {

	$conn = OpenCon();
	$query = $conn->prepare("INSERT INTO lists (name) VALUES (:name)");
	$query->execute([':name'=>$listName]);
	$conn = null;
}

function deleteTasksFromList ($listId) {

	$conn = OpenCon();
    $query = $conn->prepare("DELETE FROM tasks WHERE list_id = :listId");
    $query->execute([':listId'=>$listId]);
    $conn = null;
}

function deleteList ($listId) {

	$conn = OpenCon();
    $query = $conn->prepare("DELETE FROM lists WHERE id = :listId");
    $query->execute([':listId'=>$listId]);
    $conn = null;
}

function editListName ($listId, $newListName) {

	$conn = OpenCon();
	$query = $conn->prepare("UPDATE lists SET name = :name WHERE id = :listId");
	$query->execute([':name'=>$newListName, ':listId'=>$listId]);
	$conn = null;
}

function deleteSingleTask ($taskId) {

	$conn = OpenCon();
    $query = $conn->prepare("DELETE FROM tasks WHERE id = :taskId");
    $query->execute([':taskId'=>$taskId]);
    $conn = null;
}

function editTaskName ($taskId, $newTaskName) {

	$conn = OpenCon();
	$query = $conn->prepare("UPDATE tasks SET description = :description WHERE id = :taskId");
	$query->execute([':taskId'=>$taskId, ':description'=>$newTaskName]);
	$conn = null;
}

function editTaskDuration ($taskId, $newTaskDuration) {

	$conn = OpenCon();
	$query = $conn->prepare("UPDATE tasks SET duration = :duration WHERE id = :taskId");
	$query->execute([':taskId'=>$taskId, ':duration'=>intval($newTaskDuration)]);
	$conn = null;
}

function tickStatus ($taskId, $newStatus) {

	$conn = OpenCon();
	$query = $conn->prepare("UPDATE tasks SET status = :status WHERE id = :taskId");
	$query->execute([':taskId'=>$taskId, ':status'=>$newStatus]);
	$conn = null;
}