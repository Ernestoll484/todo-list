<?php

//include logic voor database functies
include "model/logic.php";

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="https://kit.fontawesome.com/2f6bc0b605.js" crossorigin="anonymous"></script>
	<script src="js/javascript.js"></script>
</head>
	<body>
		<div class="container">
			<nav>
				<ul>
					<li><a href="index.php">Home</a></li>
				</ul>
			</nav>

			<h1>Overzicht lijsten</h1>
			<button class="btn btn-primary mb-2" onclick="showAddListForm()">Nieuwe lijst</button>
			<button class="btn btn-danger mb-2 invisible" onclick="hideAddListForm()" id="annuleerAddList">Annuleer</button>
			<form action="addList.php" method="post" id="addListForm" class="invisible">
				<div class="form-group m-0">
					<input name="listName" type="text" class="form-control" autocomplete="off" placeholder="Vul in de naam van de nieuwe lijst">
				</div>
			</form>
			<div class="container">
            	<div class="row">
            		<?php
            		//haal alle lijsten op, kijk of er een lijst open hoort te staan, haal taken op op basis van filteren of sorteren
					foreach (getAllData('*', 'lists') as $list) {
						if ($_GET['openList'] == $list['id']) {
							$open = 'open';
						} else {
							$open = 'closed';
						}
						if ($_GET['sortList'] == $list['id']) {
							$tasks = getDataSorted('*', 'tasks', 'list_id', $list['id']);
						} else if ($_GET['filterList'] == $list['id']) {
							$tasks = getDataFiltered('*', 'tasks', 'list_id', $list['id']);
						} else {
							$tasks = getDataByColumn('*', 'tasks', 'list_id', $list['id']);
						}
						?>
						<div id="list<?= $list['id'] ?>" class="col-lg-6 p-1 lists">
							<details <?= $open ?> >
								<summary class="listName"> <?= $list['name'] ?> </summary>
								<ul class="list-group">
									<li class="list-group-item p-1" >
										<i class="fas fa-pen ml-2" title="Wijzig lijst naam" onclick="showEditListForm(<?= $list['id'] ?>)"></i>
										<i class="fas fa-trash ml-2" title="Verwijder lijst" onclick="confirmDeleteList(<?= $list['id'] ?>, '<?= $list['name'] ?>')"></i>
										<i class="fas fa-list ml-2" title="Standaard weergave" onclick="standardLayout(<?= $list['id'] ?>)"></i>
										<i class="fas fa-sort-amount-down-alt ml-2" title="Sorteer op status" onclick="sortList(<?= $list['id'] ?>)"></i>
										<i class="fas fa-filter ml-1" title="Filtreer op status" onclick="filterList(<?= $list['id'] ?>)"></i>

										<i class="fas fa-minus float-right m-2" title="Verwijder item" onclick="showDeleteItem(<?= $list['id'] ?>)"></i>
										<i class="fas fa-plus float-right m-2" title="Voeg item toe" onclick="showAddItemForm(<?= $list['id'] ?>)"></i>
										<i class="fas fa-edit float-right mt-2 mr-1" title="Wijzig item"onclick="showEditItem(<?= $list['id'] ?>)"></i>
										<div id="deleteItem<?= $list['id'] ?>" class="invisible">
											<p class="smallerText mb-0">Klik op een item om het te verwijderen</p>
											<button class="btn btn-danger" onclick="hideDeleteItem(<?= $list['id'] ?>)">Annuleer</button>
										</div>
										<div id="editItem<?= $list['id'] ?>" class="invisible">
											<p class="smallerText mb-0">Klik op een naam of duur om het te bewerken</p>
											<button class="btn btn-danger" onclick="hideEditItem(<?= $list['id'] ?>)">Annuleer</button>
										</div>
										<div id="editListForm<?= $list['id'] ?>" class="invisible">
											<form action="editListName.php?listId=<?= $list['id'] ?>" method="post">
												<div class="form-group m-0">
													<input name="newListName" type="text" class="form-control" autocomplete="off" placeholder="Verander de lijst naam">
												</div>
											</form>
											<button class="btn btn-danger" onclick="hideEditListForm(<?= $list['id'] ?>)">Annuleer</button>
										</div>
										<div id="addItemForm<?= $list['id'] ?>" class="invisible">
											<form action="addTask.php?listId=<?= $list['id'] ?>" method="post">
												<div class="form-group m-0 mb-1">
													<input name="taskDescription" type="text" class="form-control" autocomplete="off" placeholder="Voeg een nieuwe taak toe" required>
												</div>
												<div class="form-group m-0">
													<input name="taskDuration" type="number" class="form-control" autocomplete="off" placeholder="Hoe lang gaat de taak duren">
												</div>
												<input type="submit" value="Voeg toe" class="btn btn-primary">
												<button id="annuleerAddItem" type="button" class="btn btn-danger" onclick="hideAddItemForm(<?= $list['id'] ?>)">Annuleer</button>
											</form>

										</div>
									</li>
									<?php
									//haal alle taken op per lijst, zet het vinkje op 'invisible' als de taak nog niet af is
									foreach ($tasks as $task) {
										if ($task['status'] == 0) {
											$statusClass = "invisible";
										} else {
											$statusClass = null;
										}
										?>
										<li id="<?= $task['id'] ?>" class="list-group-item tasks">
											<div id="itemName<?= $task['id'] ?>" class="taskName taskContent"> <?= $task['description'] ?> </div>
											<div id="itemStatus<?= $task['id'] ?>" class="taskStatus" onclick="tickStatus(<?= $task['id'] ?>)"><i class="fas fa-check <?= $statusClass ?>"></i></div>
											<div id="itemDuration<?= $task['id'] ?>" class="taskDuration taskContent"> <?= $task['duration'] ?> min.</div>

											<div id="editItemNameForm<?= $task['id'] ?>" class="invisible taskForm">
												<form action="editTaskName.php?taskId=<?= $task['id'] ?>" method="post" class="d-inline">
													<div class="form-group m-0">
														<input id="inputEditItemName<?= $task['id'] ?>" name="newTaskName" type="text" class="form-control" autocomplete="off" placeholder="Vul in de nieuwe naam van de taak">
													</div>
												</form>
											</div>
											<div id="editItemDurationForm<?= $task['id'] ?>" class="invisible taskForm">
												<form action="editTaskDuration.php?taskId=<?= $task['id'] ?>" method="post" class="d-inline">
													<div class="form-group m-0">
														<input id="inputEditItemDuration<?= $task['id'] ?>" name="newTaskDuration" type="text" class="form-control" autocomplete="off" placeholder="Vul in de nieuwe duur van de taak">
													</div>
												</form>
											</div>

										</li>
										<?php
									}
									?>
								</ul>
							</details>
						</div>
						<?php
					}
					?>
				</div>
			</div>

			<footer>&copy; Mike de Jong</footer>
		</div>
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	 </body>
</html>