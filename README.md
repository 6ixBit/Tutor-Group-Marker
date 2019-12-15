# Tutor-Group-Marker
Application allows for students to sign up and assign themselves to one of ten available student groups. No more than 3 students are allowed to register for one group.

Once students have signed up they can submit a peer review for either of the members within their group, they can choose to temporarily save it and then edit it later or finalised it and will only be able to view it in the future.  Users peer reviews accepts text, a rating out of 10 and an image (optional).

The Tutor for the system can view all users within each group on a user profile page, tutor can send emails to groups who have not submitted all of their reviews yet and can also send an email containing the results of each student within a certain group once everyone in the group has submitted their reviews for their peers. Tutor can also search for students via their ID or by ggrade in ascending or descending order.

# Features
 - ReCaptcha on registration page
 - Registration form protected from SQL injection using prepapred statements
 - Passwords encrypted using BCrypt
 - Sessions handled through PHP's session global
 - Users can upload text and an image when reviewing pairs
 - Tutor can search for users by grade or by ID
 - Search results are paginated
 - Last search term for Tutor is remembered using Cookies
 - Tutor can send emails to groups with incomplete work as a reminder
 
# MVC
- All DB related functionality is stored in models.php
- Functions with responsibility of processing data before pushed to views is stored in controller.php
- Views are stored in root directory in pages such as login.php, register.php


# Style
CSS Theme Used : https://bootswatch.com/superhero/

# Relational Database Schema (MySQL)
https://ibb.co/wM4nXfr
