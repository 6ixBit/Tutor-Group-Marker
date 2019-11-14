CREATE TABLE `Tutor` (
  `Tutor_id` INT AUTO_INCREMENT PRIMARY KEY,
  `uid_` VARCHAR(11),
  `password_` VARCHAR(255)
);

CREATE TABLE `Groups` (
  `Groups_id` INT AUTO_INCREMENT PRIMARY KEY,
  `group_name` VARCHAR(255),
  `no_of_users` INT,
  `no_of_evaluations` INT
);

CREATE TABLE `Member` (
  `Member_id` INT AUTO_INCREMENT PRIMARY KEY,
  `Groups_id` INT,
  `e_mail` VARCHAR(255),
  `password` VARCHAR(255),
  `uid` VARCHAR(30),
  `role` VARCHAR(30),
  `overall_grade` INT,
   FOREIGN KEY (Groups_id) REFERENCES Groups (Groups_id)
);


CREATE TABLE `Rating` (
  `Rating_id` INT,
  `Groups_id` INT,
  `Member_id` INT,
  `verdict` INT,
  `description` VARCHAR(255),
  `image_path` VARCHAR(255),
  `user_reviewed` INT,
  `finalised` BOOLEAN,
  PRIMARY KEY (`rating_id`),
  FOREIGN KEY (Groups_id) REFERENCES Groups (Groups_id),
  FOREIGN KEY (Member_id) REFERENCES Member (Member_id)
);
