<?php

/// Deletes an item from the database.
/// $itemId - The Id of the item to delete.
function DeleteItem($itemId)
{
	if ($itemId)
	{
		$query = "DELETE FROM items WHERE ID=:id";
		$result = DbExecute($query, array(':id' => $itemId));
	}
}


/// Retrieves and item from the database.
/// $id - the ID of the item to retrieve.
function GetItemById($id)
{
	$query = "SELECT * FROM items WHERE ID=:id";
	$result = DbSelect($query, array(':id' => $id));
	
	if (array_key_exists(0, $result))
	{
		return $result[0];
	}
	
	return false;
}

/// Retreives all items from the database, ordered by their Awesome score.
function GetOrderedItems()
{
	$query = "SELECT * FROM items ORDER BY Name";
	return DbSelect($query);
}

// Save a new Item
// $name - the name of the item.
// $imageUrl - a URL to the item image.
function SaveNewItem($name, $url)
{
	$query = "INSERT INTO items(Name, Url, createdBy) VALUES(:name, :url, :userId)";
	$id = DbInsert($query, array(':name' => $name, ':url' => $url, ':userId' => GetLoggedInUserId()));
	return $id;
}
