<?php

	function encrypt_pass($user_pass){
	///-- Encrypt password using Bcrypt/Default --///    
		echo password_hash($user_pass, PASSWORD_DEFAULT);
    }

	function decrypt_pass($user_pass, $hash){
	///-- Decrypt password using Bcrypt/Default --///
		if (password_verify($user_pass, $hash)) {
			echo 'Password is valid';
		} else {
		    echo 'Password is invalid';
		}
	}

	function get_dropdown_id($selected_option){
		//-- If passed as a param; Returns the ID from the group drop down menu list on register page --//
		$group_id = explode(" ", $selected_option);
		echo intval($group_id[1]); 
	}

	//get_dropdown_id("Group 5"); - WORKS
	//encrypt_pass('password'); - WORKS
	decrypt_pass('password', '$2y$10$Yl2JcGBQDKdZlLhys9iS9.zb2fhZYmMTF63jM9kh39t3IeW6eqjBK');
?>