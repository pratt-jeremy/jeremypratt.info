<?php
if ($_POST['action'] == 'Send'){

$name = $_POST['name'];

$email = $_POST['email'];

$subject = $_POST['subject'];

$message = $_POST['message'];

$captcha = strtolower($_POST['captcha']);

 } 
 // Check the data

if(empty($name) || empty($email) || empty($subject) || empty($message)) {

  $reply = 'Sorry, one or more fields are empty. All fields are     

            required.';

  include 'contact.php';

  exit;

} 

// Check the captcha

if(empty($captcha) || $captcha != 'red') {

  $reply = 'The captcha answer is incorrect.';

  include 'contact.php';

  exit;

} 
// Assemble the message

  $finalmessage = "Name: $name \n";

  $finalmessage .= "Email: $email \n";

  $finalmessage .= "Subject: $subject \n";

  $finalmessage .= "Message: \n $message"; 

// Send the message

  $to = "pratt.jeremy1@gmail.com";

  $from = "From: $email";

  $result = mail($to, $subject, $finalmessage, $from); 

// Let the client know what happened

  if ($result == TRUE) {

    $reply = "Thank you $name for contacting me.";

    unset($name);

    unset($email);

    unset($subject);

    unset($message);

    include 'contact.php';

    exit;

  } else {

    $reply = "Sorry $name but there was an error and the message could not be sent.";

    unset($name);

    unset($email);

    unset($subject);

    unset($message);

    include 'contact.php';

    exit;
  } 


    if(!empty($reply)){

      echo "<p class='notify'>$reply</p>";

    }

    unset($reply);


