/** Get every child element from a parent element with a class
 * @param {number} parentId - Id of the parent
 * @param {string} childClassName - Name of the class each child has that you want to get
 */
function getChildrenFrom(parentId, childClassName) {

    return document.getElementById(parentId).getElementsByClassName(childClassName);
}

/** Put the element IDs from every child in an array
 * @param {array} children - Array of child elements previously gotten
 * @return {array} childrenIDs - Array of child IDs
 */
function childrenIdsInArray(children) {

    let childrenIDs = [];

    for (let i = 0; i < children.length; i++) {
        childrenIDs[i] = children[i].id;
    }

    return childrenIDs;
}

/** Enables items in list to be clicked on and deleted
 * @param {number} listId - Id of the list this form will be shown for
 */
function showDeleteItem(listId) {

    let deleteItem = document.getElementById("deleteItem" + listId);
    let children = getChildrenFrom("list" + listId, "tasks");
    let childrenIds = childrenIdsInArray(children);

    // For each child
    for (let i = 0; i < children.length; i++) {

        let element = children[i];

        // Replace special characters to prevent bugs in confirmDeleteItem
        let itemName = element.textContent.replace(/[^a-zA-Z0-9 ]/g, "");

        // Give an onclick with the child's ID and add CSS through DOM
        element.onclick = function() {confirmDeleteItem(childrenIds[i], itemName);};
        element.classList.add("clickableButton");
    }

    deleteItem.classList.remove("invisible");
}

// Similar to showDeleteItem but undo-ing everything
function hideDeleteItem(listId) {

    let deleteItem = document.getElementById("deleteItem" + listId);
    let children = getChildrenFrom("list" + listId, "tasks");

    for (let i = 0; i < children.length; i++) {

        let element = children[i];
        element.onclick = null;
        element.classList.remove("clickableButton");
    }

    deleteItem.classList.add("invisible");
}

/** Enables items in list to be clicked on and edited
 * @param {number} listId - Id of the list this form will be shown for
 */
function showEditItem(listId) {

    let editItem = document.getElementById("editItem" + listId);
    let children = getChildrenFrom("list" + listId, "tasks");
    let childrenIds = childrenIdsInArray(children);

    // For each child
    for (let i = 0; i < children.length; i++) {

        let element = children[i];

        //Split each child into two parts: [0] task name, [1] task duration
        let childContent = getChildrenFrom(element.id, "taskContent");

        // Add onclick and DOM CSS for each part
        childContent[0].onclick = function() {showEditItemNameForm(childrenIds[i]);};
        childContent[0].classList.add("clickableButton");
        childContent[1].onclick = function() {showEditItemDurationForm(childrenIds[i]);};
        childContent[1].classList.add("clickableButton");
    }

    editItem.classList.remove("invisible");
}

// Similar to showEditItem but undo-ing everything
function hideEditItem(listId) {

    let editItem = document.getElementById("editItem" + listId);
    let children = getChildrenFrom("list" + listId, "tasks");

    for (let i = 0; i < children.length; i++) {

        let element = children[i];
        let childContent = getChildrenFrom(element.id, "taskContent");
        let childForms = getChildrenFrom(element.id, "taskForm");

        // Hide everything at once to make it simple
        for (let j = 0; j < childContent.length; j++) {

            childContent[j].classList.remove("clickableButton");
            childContent[j].classList.remove("invisible");
            childContent[j].onclick = null;
            childForms[j].classList.add("invisible");
        }
    }

    editItem.classList.add("invisible");
}

// Shows the form for editing item NAMES
function showEditItemNameForm(itemId) {

    let editItemNameForm = document.getElementById("editItemNameForm" + itemId);
    let itemName = document.getElementById("itemName" + itemId);
    let inputEditItemName = document.getElementById("inputEditItemName" + itemId);

    editItemNameForm.classList.remove("invisible");
    itemName.classList.add("invisible");
    inputEditItemName.focus();
}

// Shows the form for editing item DURATIONS
function showEditItemDurationForm(itemId) {

    let editItemDurationForm = document.getElementById("editItemDurationForm" + itemId);
    let itemDuration = document.getElementById("itemDuration" + itemId);
    let inputEditItemDuration = document.getElementById("inputEditItemDuration" + itemId);

    editItemDurationForm.classList.remove("invisible");
    itemDuration.classList.add("invisible");
    inputEditItemDuration.focus();
}

// Shows the form for adding lists
function showAddListForm() {

    let addListForm = document.getElementById("addListForm");
    let annuleerAddList = document.getElementById("annuleerAddList");

    addListForm.classList.remove("invisible");
    annuleerAddList.classList.remove("invisible");
}

// I mean.. these function names speak for themselves, right?
function hideAddListForm() {

    let addListForm = document.getElementById("addListForm");
    let annuleerAddList = document.getElementById("annuleerAddList");

    addListForm.classList.add("invisible");
    annuleerAddList.classList.add("invisible");
}

function showAddItemForm(id) {

    let addItemForm = document.getElementById("addItemForm" + id);
    addItemForm.classList.remove("invisible");
}

function hideAddItemForm(id) {

    let addItemForm = document.getElementById("addItemForm" + id);
    addItemForm.classList.add("invisible");
}

function showEditListForm(id) {

    let editListForm = document.getElementById("editListForm" + id);
    editListForm.classList.remove("invisible");
}

function hideEditListForm(id) {

    let editListForm = document.getElementById("editListForm" + id);
    editListForm.classList.add("invisible");
}

// Displays a confirm for deleting LISTS
function confirmDeleteList(listId, listName) {

    let confirmDelete = confirm("Weet je zeker dat je '" + listName + "' wilt verwijderen?");

    if (confirmDelete) {
        window.location.href = ("deleteList.php?listId=" + listId);
    }
}

// Displays a confirm for deleting ITEMS
function confirmDeleteItem(itemId, itemName) {

    let confirmDelete = confirm("Weet je zeker dat je '" + itemName + "' wilt verwijderen?");

    if (confirmDelete) {
        window.location.href = ("deleteTask.php?taskId=" + itemId);
    }
}

// Change status from 0 to 1 or vice versa
function tickStatus(itemId) {

    window.location.href = ("tickStatus.php?taskId=" + itemId);
}

// Link to index with params to sort a list
function sortList(listId) {

    window.location.href = ("index.php?sortList=" + listId + "&openList=" + listId);
}

// Link to index with params to filter a list
function filterList(listId) {

    window.location.href = ("index.php?filterList=" + listId + "&openList=" + listId);
}

// Link back to index without params to switch back to default
function standardLayout(listId) {

    window.location.href = ("index.php?openList=" + listId);
}