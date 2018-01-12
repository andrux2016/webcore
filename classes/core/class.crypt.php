<?php
class Crypt{
	public static function encrypt($Value, $Key = 'C592aLqN98wHx67vNyW2ivDY') {
		return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $Key, $Value, MCRYPT_MODE_ECB));
	}

	public static function decrypt($Value, $Key = 'C592aLqN98wHx67vNyW2ivDY') {
		return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $Key, base64_decode($Value), MCRYPT_MODE_ECB));
	}
}
?>