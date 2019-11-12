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
       
            <form action='' method='POST'>
            <fieldset> 
            <div class="form-group">
                <label for="exampleTextarea" class='review_label'> Enter your review:</label>
                <style> #reviewText {
                    position: absolute;
                    left: 43%;
                    top: 10%;
                    width: 15%;}</style>

                    <style>.review_label {
                    position: absolute;
                    left: 43%;
                    top: 7%;
                    width: 15%;}</style>

                    <style>.submit_review {
                    position: absolute;
                    left: 43%;
                    top: 30%;
                    width: 15%;}</style>


                <textarea id="reviewText" placeholder='Enter a review for your peer' rows="5" cols='50'></textarea>
            </div>
           <br>
            <div class="form-group">
                <label for="exampleInputFile">File input</label>
                <input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
                <small id="fileHelp" class="form-text text-muted">Image Formats: .jpg, .png</small>
            </div> <br> <br>
            <input type="submit" value="Upload Image" class='submit_review' name="submit">
        </fieldset>
            </form>
        </div>
    </body>
</html>