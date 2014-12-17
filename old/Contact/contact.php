<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Contact Page</title>
         <link rel="stylesheet" type="text/css" href="/stylesheet.css">
    </head>
    <body>
        <div id = 3columns>
        <header>
            <div><h1 style="text-align: left; color: white;">jeremypratt.info</h1></div>
            <div><nav style="text-align: right">
                
                    
                    <a style="color: white;" href="/index.php" title=”View the Home Page”>Home Page</a>
                        <a style="color: white;" href="/About Me/about_me.php" title=”View the About Me”>About Me</a>
                        <a style="color: white;" href="/experience.php" title=”View the Experience”>Experience</a>
                        <a style="color: white;" href="/Contact/contact.php" title=”View the Contact”>Contact</a>
                        <a style="color: white;" href="/Blog/blog.php" title=”View the Contact”>Blog</a>
                    
                
            </nav></div>
        </header>
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
                <form method="post" action="/Contact/emailscript.php" id="contactform">

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
            <div class = "column3">
            </div>
        </div>
        </main>
        <footer>
            <a href="/assessments/site-plan.php" title=”View the Site Plan”>Site Plan|</a>
            <a href="/assessments/deliberate-practice.php" 
            title=”View the Deliberate Practice Plan”>Deliberate Practice|</a>            
            <a href="/assessments/deliberate-practice-journal.php" title=”View the Deliberate Practice Jounral”>Deliberate Practice Journal|</a>
            <a href="/assessments/teaching_presentation.php" title=”View the Teaching Presentation”>Teaching Presentation</a>
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="CYDZ7JLXLURC8">
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>
</footer>
    </body>
</html>


