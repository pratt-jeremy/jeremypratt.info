<?php

session_start();

require 'models/db.php';
require 'models/users.php';
require 'models/comments.php';
require 'models/items.php';
require 'models/navigation.php';
require 'models/roles.php';

include 'views/header.php';

$action = strtolower(filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING));

switch ($action)
{
    case 'about':
	   include 'views/about.php';
	   break;
       
    case 'work':
	   include 'views/work.php';
	   break;
       
    case 'changerole':
        $userid = (int) filter_input(INPUT_GET, 'userid', FILTER_SANITIZE_NUMBER_INT);
        $role = filter_input(INPUT_GET, 'role', FILTER_SANITIZE_STRING);
        
        if (LoggedInUserIsAdmin() && $userid && $role)
        {
            UpdateUserRole($userid, $role);
        }
        
        header('Location: /?action=editusers');
        exit();
        
    case 'contact':
        include 'views/contact.php';
        break;
    
    case 'siteplan':
        include 'views/siteplan.php';
        break;
    
    case 'teaching-presentation':
        include 'views/teaching-presentation.php';
        break;
        
    case 'deleteitem':
        $id = (int) filter_input(INPUT_GET, 'itemId', FILTER_SANITIZE_NUMBER_INT);
        DeleteItem($id);
        header('Location: /?action=gallery');
        exit();
    
    case 'deleteuser':
        $id = (int) filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        
        if (LoggedInUserIsAdmin() && $id)
        {
            DeleteUser($id);
        }
        
        header('Location: /?action=editusers');
        exit();
        
    case 'editusers':
        $page = (LoggedInUserIsAdmin()) ? 'views/editusers.php' : 'views/login.php';
        $users = GetAllUsers();
        include $page;
        break;
        
    case 'info':
        include 'views/info.php';
        break;

    case 'music':
        $items = GetOrderedItems();
        include 'views/music.php';
        break;
        
    case 'home':
        $items = GetOrderedItems();
        include 'views/home.php';
        break;
       
    case 'login':
        include 'views/login.php';
        break;
        
    case 'loginsubmit':
        $email = filter_input(INPUT_POST, 'emaillogin', FILTER_SANITIZE_EMAIL);
	    $password = filter_input(INPUT_POST, 'passwordlogin', FILTER_SANITIZE_STRING);

        if (LoginUser($email, $password)) {
            header('Location: /?action=menu');
            exit();
        }
        
        include 'views/login.php';
        break;
        
    case 'logout':
        session_destroy();
        $_SESSION = array();
        header('Location: /');
        exit();
        break;
        
    case 'menu':
        $page = (CheckSession()) ? 'views/menu.php' : 'views/login.php';
        include $page;
        break;
        
    case 'myinfo':
        $page = 'views/login.php';
        
        if ($userId = GetLoggedInUserId()) 
        {
            $page = 'views/myinfo.php';
            $user = GetUser($userId);
        }
        
        include $page;
        break;
        
    case 'newitem':
        $page = (CheckSession()) ? 'views/newitem.php' : 'views/login.php';
        include $page;
        break;
        
    case 'newitemsubmit':
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
	    $url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);
        
        if ($name && $url && $itemId = SaveNewItem($name, $url))
        {
            $item = GetItemById($itemId);
            $comments = GetCommentsWithUsersForItem($itemId);
            include 'views/itemdetails.php';
        }
        else
        {
            include 'views/newitem.php';
        }
        
        break;
        
    case 'postcomment':
        $itemId = (int) filter_input(INPUT_POST, 'itemId', FILTER_SANITIZE_NUMBER_INT);

        if ($userId = GetLoggedInUserId())
        {
            $text = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);
        
            if ($itemId && $text)
            {
                SaveComment($itemId, $userId, $text);
            }
        }
        
        $item = GetItemById($itemId);
        $comments = GetCommentsWithUsersForItem($itemId);
        include 'views/itemdetails.php';
        break;
    
    case 'registersubmit':
        $regFirst = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $regLast = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $regmail = filter_input(INPUT_POST, 'emailreg', FILTER_SANITIZE_EMAIL);
        $regpass1 = filter_input(INPUT_POST, 'passwordreg1', FILTER_SANITIZE_STRING);
        $regpass2 = filter_input(INPUT_POST, 'passwordreg2', FILTER_SANITIZE_STRING);
        $message = '';
        
        if (RegisterUser($regFirst, $regLast, $regmail, $regpass1, $regpass2, $message)) {
            header('Location: /?action=menu');
            exit();
        }
        
        include 'views/login.php';
        break;
    
    case 'viewitem':
        $itemId = (int) filter_input(INPUT_GET, 'itemId', FILTER_SANITIZE_NUMBER_INT);
        $item = GetItemById($itemId);
        $comments = GetCommentsWithUsersForItem($itemId);
        include 'views/itemdetails.php';
        break;
        
    case 'updateinfo':
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $regFirst = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $regLast = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        
        if ($userId = GetLoggedInUserId()) 
        {
            $page = 'views/myinfo.php';
            
            if ($email && $regFirst && $regLast) 
            {
                UpdateUserInfo($userId, $email, $regFirst, $regLast);
                $user = GetUser($userId);
                $message = 'User Info Updated.';
            }
            else
            {
                $message = 'Please fill in all information to update.';
            }
        }
        else
        {
            $page = 'views/login.php';
        }
        
        include $page;
        break;
    
    case 'updatepassword':
        $oldpassword = $_POST['currentpassword'];
        $newpassword = $_POST['newpassword'];
        $newpassword2 = $_POST['repeatpassword'];
        $message = '';
        
        if ($newpassword == $newpassword2)
        {
            $validMessage = '';
            if (ValidatePassword($newpassword, $validMessage))
            {
                if (ValidateOldPassword($oldpassword))
                {
                    UpdateUserPassword($newpassword);
                    $message = 'Password Updated';
                }
                else
                {
                    $message = 'The old password did not match.';
                }
            }
            else
            {
                $message = $validMessage;
            }
        }
        else
        {
            $message = "The new passwords do not match";
        }
        
        if ($userId = GetLoggedInUserId()) 
        {
            $page = 'views/myinfo.php';
            $user = GetUser($userId);
        }
  
        include 'views/myinfo.php';
        break;
        
    
    
    default:
        $items = GetOrderedItems();
        include 'views/home.php';
}

include 'views/footer.php';