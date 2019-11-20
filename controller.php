<?php
	function encrypt_pass( $user_pass ){
	///-- Encrypt password using Bcrypt/Default --///
        $encrypted_pass = password_hash( $user_pass, PASSWORD_DEFAULT );       
		return $encrypted_pass;
    }

	function decrypt_pass( $user_pass, $hash ){
	///-- Decrypt password using Bcrypt/Default --///
		$decrypted_pass = password_verify($user_pass, $hash);

		if ($decrypted_pass == TRUE){
			return TRUE;
		}
		return FALSE;
	}







?>