<?php

	function encrypt_pass($user_pass){
	///-- Encrypt password using Bcrypt/Default --///    
		return password_hash($user_pass, PASSWORD_DEFAULT);
    }

	function decrypt_pass($user_pass, $hash){
	///-- Decrypt password using Bcrypt/Default --///
		if (password_verify($user_pass, $hash)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function get_dropdown_id($selected_option){
	///-- If passed as a param; Returns the ID from the group drop down menu list on register page --///
		$group_id = explode(" ", $selected_option);
		return intval($group_id[1]); 
	}

	function convert_image(){
	///--Converts image into binary and returns it --///
		$verify_img = getimagesize($_FILES['img_form']['tmp_name']);

		if (verify_img == false) {
			//-- IF no image size is stored
			echo "Error when verifying image";
		} else {
			//-- Store content of image as binary 
			$image = addslashes($_FILES['img_form']['tmp_name']);
			$image = file_get_contents($image);
			$image = base64_encode($image);
		}
		return $image;
	}

	function send_reminder_email($student_email){
		ini_set("sendmail_from","mn7754c@gre.ac.uk");

		$subject = "Reminder to complete your work";
		$body = "This is a reminder email from your tutor for you to complete your work";

		mail("mn7754c@gre.ac.uk", $subject, $body, "From: mn7754c@gre.ac.uk\r\n");
	}

	function send_final_results($student_email, $student_id, $final_grade) {
		ini_set("sendmail_from","mn7754c@gre.ac.uk");

		$subject = "Peer assessment grade";
		$body = "Final grade for student "."(".$student_id.")"." is ".$final_grade;

		mail($student_email, $subject, $body, "From: mn7754c@gre.ac.uk\r\n");

	}

	//send_final_results("mn7754c@gre.ac.uk", "000967991", "9");

?>