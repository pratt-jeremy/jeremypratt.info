<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Contact Page</title>
        <link rel="stylesheet" type="text/css" href="/triathlon/stylesheet.css">
    </head>
    <body>
        <header>
            <div><h1 style="text-align: left; color: white;">Prison to Prison Triathlon</h1>
                <img src="Logo.png" width="200" height="100"></div>
            <div><nav style="text-align: right">
                
                    
                    <a style="color: #003366;" href="/triathlon/index.php" title=”View the Home Page”>Home Page</a>
                    <a style="color: #003366;" href="/triathlon/route.php" title=”View the Route”>Route</a>
                    <a style="color: #003366;" href="/triathlon/registration.php" title=”View the Registration”>Registration</a>
                                  
            </nav></div>
        </header>
        <div id = 2columns>
        
        <main>
                <div class= "column1">
             
            </div>
            <div class= "column2">
                <h1>Contact</h1>
                <?php

                    if(!empty($reply)){

                      echo "<p class='notify'>$reply</p>";

                    }

                    unset($reply);

                ?> 
                <p>*All fields are required</p>
                <form method="post" action="/triathlon/emailscript.php" id="contactform">

<fieldset>

<label for="name">Name:</label>

<input type="text" name="name" id="name" size="10" value="<?php 

echo $name; ?>" required><br>

<label for="email">Email Address:</label>

<input type="email" name="email" id="email" size="30" value="<?php echo $email; ?>" required><br>

<label for="subject">Subject:</label>

<input type="text" name="subject" id="subject" size="60" value="<?php echo $subject; ?>" required><br>

<label for="message">Message</label>

<textarea name="message" id="message" rows="10" cols="60" required><?php echo $message; ?></textarea><br>

<p>Answer the following CAPTCHA question in the box below.</p>

<label for="captcha">What color is a red apple?</label>

<input type="text" name="captcha" id="captcha" size="5" required><br>

<label for="action">&nbsp;</label>

<input type="submit" name="action" id="action" value="Send">

</fieldset>

</form> 
                </div>
            
        </div>
        </main>
        <footer>
          ©Jeremy Pratt 2014
          <a href="/triathlon/site-plan.php" title=”View the Site Plan”>Site Plan|</a>
          <a href="/triathlon/contact.php" title=”View the Resources”>Contact|</a> 
          <a href="/triathlon/resource.php" title=”View the Resources”>Resources|</a>
</footer>
    </body>
</html>


