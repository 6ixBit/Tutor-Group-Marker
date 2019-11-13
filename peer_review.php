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

        <h1>Your Group: 1</h1>
        <div class='select_user'>
        Select a user to review: <select value='users_in_group'>
            <option value='user_1'>User 1</option>
            <option value='user_2'>User 2</option>
            <option value='user_3'>User 3</option>
        </select>
        </div>
       
            <form action='' method='POST'>
            <fieldset> 
            <div class="form-group">
                <label for="exampleTextarea" class='review_label'> Enter your review:</label>
                    <style> #reviewText {
                    position: absolute;
                    left: 43%;
                    top: 10%;
                    width: 20%;}
                    </style>

                    <style>.review_label {
                    position: absolute;
                    left: 43%;
                    top: 7%;
                    width: 15%;}
                    </style>

                    <style>.upload_img{
                    position: absolute;
                    left: 43%;
                    top: 36%;
                    width: 15%;}
                    </style>

                    <style>.image_upload_form {
                    position: absolute;
                    left: 43%;
                    top: 27%;
                    width: 15%;}
                    </style>

                    <style>
                        .select_user {
                        position: absolute;
                        left: 1%;
                        top: 13%;
                        width: 15%;
                        }
                    </style>

                    <style>
                        .load_review {
                        position: absolute;
                        left: 1%;
                        top: 22%;
                        width: 12%;
                        }
                    </style>

                    <style>.rating {
                    position: absolute;
                    left: 43%;
                    top: 42%;
                    width: 15%;}
                    </style>

                    <style>.save_button {
                    position: absolute;
                    left: 43%;
                    top: 48%;}
                    </style>

                    <style>.finalise_button {
                    position: absolute;
                    left: 53%;
                    top: 48%;}
                    </style>

                <textarea id="reviewText" placeholder='Enter a review for your peer' rows="5" cols='50'></textarea>
            </div>
           <br>
            <div class="image_upload_form">
                <label for="Upload_image">Upload an image:</label>
                <input type="file" id="Upload_image">
            </div> <br> <br>
            <input type="submit" value="Upload Image" class='upload_img' name="submit">
        </fieldset>
        <div class='rating'>
            Rating: <select name='user_rating'>
                <option>0</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
                <option>10</option>
            </select>
        </div>
        <button name='load_review' class='load_review'>Load selected user</button>
        <button type='submit' name='save' class='save_button'>Save temporarily</button> 
        <button type='submit' name='submit_review' class='finalise_button'>Submit for marking</button> 
            </form>
        </div>
    </body>
</html>