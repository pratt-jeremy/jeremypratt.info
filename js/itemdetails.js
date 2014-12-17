// Used to confirm item deletion from the UI.
// id - the ItemId of the item to delete.
function DeleteItem(id) {
	var confirmed = confirm("Are you sure you want to delete the item? This will also remove all comments on the item.");
	
	if (confirmed) {
		window.location = '/?action=deleteitem&itemId=' + id;
	}
}
