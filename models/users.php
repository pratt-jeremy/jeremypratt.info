<?php

class User
{
	var $id;
	var $email;
	var $passwordHash;
	var $firstName;
	var $lastName;
	var $roleId;
}



function CalculatePasswordHash($password) {
	return sha1($password . 'addSomeExtraSalt123');
}


function CheckSession()
{
	return(GetLoggedInUserId() != null);
}



function DeleteUser($id)
{
	$query = 'DELETE FROM users WHERE ID=:id';
	DbExecute($query, array(':id' => $id));
}


function GetAllUsers()
{
	$users = array();
	$query = 'SELECT * FROM users';
	$result = DbSelect($query);
	
	foreach ($result as $item)
	{
		$user = new User();
		$user->id = $item['Id'];
		$user->email = $item['email'];
		$user->firstName = $item['firstname'];
		$user->lastName = $item['lastname'];
		$user->roleId = $item['roleId'];
		
		$users[] = $user;
	}
	
	return $users;
}



function GetLoggedInUserId()
{
	return (array_key_exists('UserId', $_SESSION)) ? $_SESSION['UserId'] : null;
}



function GetUser($userId) {
	$query = 'SELECT * FROM users WHERE ID=:id';
	$result = DbSelect($query, array(':id' => $userId));
	
	if (array_key_exists(0, $result))
	{
		$user = new User();
		$user->id = $result[0]['Id'];
		$user->email = $result[0]['email'];
		$user->firstName = $result[0]['firstname'];
		$user->lastName = $result[0]['lastname'];
		$user->roleId = $result[0]['roleId'];
		
		return $user;
	}
	
	return false;
}



function LoggedInUserIsAdmin()
{
	return array_key_exists('UserRole', $_SESSION) && $_SESSION['UserRole'] == ROLE_ID_ADMIN;
}



function LoginUser($email, $password) {
	$loggedIn = false;
	
	if ($email && $password) {
		$hash = CalculatePasswordHash($password);
		$query = "SELECT * FROM users WHERE email=:email AND passwordhash=:hash";
		$result = DbSelect($query, array(':email' => $email, ':hash' => $hash));
		
		if (is_array($result) && array_key_exists(0, $result)) {
			$user = new User();
			$user->id = $result[0]['Id'];
			$user->roleId = $result[0]['roleId'];
			SetUserSessionVariables($user);
			$loggedIn = true;
		}
	}
	
	return $loggedIn;
}



function RegisterUser($first, $last, $email, $pass1, $pass2, &$message) {
	$registered = false;
	
	if (ValidateNames($first, $message) &&
		ValidateNames($last, $message) &&
		ValidateEmail($email, $message) &&
		ValidatePasswordLength($pass1, $message)) {
		if ($pass1 == $pass2) {
			$query = "SELECT * FROM users WHERE email=':email'";
			$result = DbSelect($query, array(':email' => $email));
			
			if (is_array($result) && count($result) == 0) {
				$hash = CalculatePasswordHash($pass1);
				$query = "INSERT INTO users(firstname, lastname, email, passwordhash, roleId)";
				$query .= " VALUES(:first, :last, :email, :pass, :role)";
				
				$id = DbInsert($query, array(':first' => $first, ':last' => $last, ':email' => $email, ':pass' => $hash, ':role' => ROLE_ID_USER));
				$u = new User();
				$u->id = $id;
				$u->roleId = null;
				SetUserSessionVariables($u);
				$registered = true;
			}
		}
		else
		{
			$message .= "Password and Verify Password must match.";
		}
	}
	
	return $registered;
}


function ValidateNames($name, &$message) {
	if (strlen($name) >= 2) {
		return true;	
	} else {
		$message .= "Name must be at least 2 characters long";
		return false;
	} 
}

function ValidateEmail($email, &$message) {
	
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return true;
	}
	
	$message .= "Invalid Email address";
	return false;
}

function ValidatePasswordLength($name, &$message) {
	
	
	if (strlen($name) >= 5) {
		return true;	
	} else {
		$message .= "Password must be at least 5 characters long";
		return false;
	} 
}


function SetUserSessionVariables(User $user) {
	$_SESSION['UserId'] = $user->id;
	$_SESSION['UserRole'] = $user->roleId;
}


function UpdateUserInfo($id, $email, $firstname, $lastname)
{
	$query = 'UPDATE users SET email=:email, firstName=:firstname, lastname=:lastname WHERE ID=:id';
	DbExecute($query, array(':email' => $email, ':firstname' => $firstname, ':lastname' => $lastname, ':id' => $id));
}


function UpdateUserPassword($password, $id = null)
{
	$id = ($id == null) ? GetLoggedInUserId() : $id;
	$hash = CalculatePasswordHash($password);
	
	$query = 'UPDATE users SET passwordhash=:hash WHERE ID=:id';
	DbExecute($query, array(':hash' => $hash, ':id' => $id));
}



function UpdateUserRole($id, $roleName)
{
	if ($id && $roleName)
	{
		$roleId = (strtolower($roleName) == 'admin') ? ROLE_ID_ADMIN : ROLE_ID_USER;
		
		$query = 'UPDATE users SET roleId=:roleId where Id=:id';
		DbExecute($query, array(':roleId' => $roleId, ':id' => $id));	
	}
}


function ValidateOldPassword($password)
{
	$return = false;
	$id = GetLoggedInUserId();
	$hash = CalculatePasswordHash($password);
	$query = 'SELECT * FROM users WHERE ID=:id AND passwordhash=:hash';
	
	$result = DbSelect($query, array(':id' => $id, ':hash' => $hash));
	
	if ($result && count($result) > 0)
	{
		$return = true;
	}
	
	return $return;
}



function ValidatePassword($password, &$message)
{
	$valid = false;
	
	if (strlen($password) >= 3)
	{
		$valid = true;
	}
	else
	{
		$message = "The password must be at least 3 characters long.";
	}
	
	return $valid;
}
