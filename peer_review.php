<?php
    include 'templates/loggedIn_nav.html';
    session_start();  
?>

<html>
    <head>
        <title>Student Peer Reviews</title>
    </head>
    <body>
        <div class='user_peer'>
        <center>
            <form action='' method='POST'>
            <p> Enter your review:
            <textarea rows="4" cols="50" name='review_text' placeholder='Enter your review here'>
            </textarea>
            </p> <br>
            <p> Upload an image <br>
            <input type='file' name='imageUpload'> <br>
            </p> <br>
            <input type="submit" value="Upload Image" name="submit">
        </center>   
            </form>
        </div>
    </body>
</html>