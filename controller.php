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

?>