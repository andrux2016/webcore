<?php
/**
 * This file is part of Webcore
 *
 * @license none
 *
 * Copyright (c) 2015-Present, Mandalorien
 * All rights reserved.
 *
 * create 2018 by  mandalorien
 */
class Security {
	
	private $key = null;
	private $signKey = null;

	public function __construct($key = null, $signKey = null) {
		
		if(is_null($key)) {
			throw new \Exception('set sccret key please.');
		}
		if(is_null($signKey)) {
			throw new \Exception('set sign key please.');
		}
		$this->key = $key;
		$this->signKey = $signKey;
		
	}

	 
	public function sign($content) {
		
		return strtoupper(hash_hmac('sha256', $content, $this->signKey));
		
	}
	
	public function verify($content, $sign) {
		
		if($sign == $this->sign($content)) {
			return true;
		}
		return false;
		
	}
	
	public function encrypt($input) {
		
		$size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
		$input = $this->pkcs5_pad($input, $size);
		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		mcrypt_generic_init($td, $this->key, $iv);
		$data = mcrypt_generic($td, $input);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		$data = bin2hex($data);
		return $data;
		
	}
	private function pkcs5_pad($text, $blocksize) {
		
		$pad = $blocksize - (strlen($text) % $blocksize);
		return $text . str_repeat(chr($pad), $pad);
		
	}
	
	public function decrypt($sStr) {
		$decrypted= mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$this->key,hex2bin($sStr), MCRYPT_MODE_ECB);
		$dec_s = strlen($decrypted);
		$padding = ord($decrypted[$dec_s-1]);
		$decrypted = substr($decrypted, 0, -$padding);
		return $decrypted;
	}
	
    private function createLinkString($para, $encode) {
		
    	ksort($para);
    	$linkString = "";
    	while ( list ( $key, $value ) = each ( $para ) ) {
    		if ($encode) {
    			$value = urlencode ( $value );
    		}
    		$linkString .= $key . "=" . $value . "&";
    	}

    	$linkString = substr ( $linkString, 0, count ( $linkString ) - 2 );
    	return $linkString;
    }
	
	protected function encodeQuote($text){
		$patterns = array();
		$patterns[0] = "/'/";
		$patterns[1] = '/"/';
		$replacements[0] = '&apos;';
		$replacements[1] = '&quot;';
		return preg_replace($patterns, $replacements, $text);		
	}
	
	protected function decodeAccent($msg){
		/*
		$msg=preg_replace("#&Agrave;#isU","À",$msg);
		$msg=preg_replace("#&Aacute;#isU","Á",$msg);
		$msg=preg_replace("#&Acirc;#isU","Â",$msg);
		$msg=preg_replace("#&Atilde;#isU","Ã",$msg);
		$msg=preg_replace("#&Auml;#isU","Ä",$msg);
		$msg=preg_replace("#&Aring;#isU","Å",$msg);
		$msg=preg_replace("#&Aelig;#isU","Æ",$msg);
		$msg=preg_replace("#&Ccedil;#isU","Ç",$msg);
		$msg=preg_replace("#&Egrave;#isU","È",$msg);
		$msg=preg_replace("#&Eacute;#isU","É",$msg);
		$msg=preg_replace("#&Ecirc;#isU","Ê",$msg);
		$msg=preg_replace("#&Euml;#isU","Ë",$msg);
		$msg=preg_replace("#&Igrave;#isU","Ì",$msg);
		$msg=preg_replace("#&Iacute;#isU","Í",$msg);
		$msg=preg_replace("#&Icirc;#isU","Î",$msg);
		$msg=preg_replace("#&Iuml;#isU","Ï",$msg);
		$msg=preg_replace("#&eth;#isU","Ð",$msg);
		$msg=preg_replace("#&Ntilde;#isU","Ñ",$msg);
		$msg=preg_replace("#&Ograve;#isU","Ò",$msg);
		$msg=preg_replace("#&Oacute;#isU","Ó",$msg);
		$msg=preg_replace("#&Ocirc;#isU","Ô",$msg);
		$msg=preg_replace("#&Otilde;#isU","Õ",$msg);
		$msg=preg_replace("#&Ouml;#isU","Ö",$msg);
		$msg=preg_replace("#&times;#isU","×",$msg);
		$msg=preg_replace("#&Oslash;#isU","Ø",$msg);
		$msg=preg_replace("#&Ugrave;#isU","Ù",$msg);
		$msg=preg_replace("#&Uacute;#isU","Ú",$msg);
		$msg=preg_replace("#&Ucirc;#isU","Û",$msg);
		$msg=preg_replace("#&Uuml;#isU","Ü",$msg);
		$msg=preg_replace("#&Yacute;#isU","Ý",$msg);
		*/
		$msg=preg_replace("#&thorn;#isU","Þ",$msg);
		$msg=preg_replace("#&szlig;#isU","ß",$msg);
		$msg=preg_replace("#&agrave;#isU","à",$msg);
		$msg=preg_replace("#&aacute;#isU","á",$msg);
		$msg=preg_replace("#&acirc;#isU","â",$msg);
		$msg=preg_replace("#&atilde;#isU","ã",$msg);
		$msg=preg_replace("#&auml;#isU","ä",$msg);
		$msg=preg_replace("#&aring;#isU","å",$msg);
		$msg=preg_replace("#&aelig;#isU","æ",$msg);
		$msg=preg_replace("#&ccedil;#isU","ç",$msg);
		$msg=preg_replace("#&egrave;#isU","è",$msg);
		$msg=preg_replace("#&eacute;#isU","é",$msg);
		$msg=preg_replace("#&ecirc;#isU","ê",$msg);
		$msg=preg_replace("#&euml;#isU","ë",$msg);
		$msg=preg_replace("#&igrave;#isU","ì",$msg);
		$msg=preg_replace("#&iacute;#isU","í",$msg);
		$msg=preg_replace("#&icirc;#isU","î",$msg);
		$msg=preg_replace("#&iuml;#isU","ï",$msg);
		$msg=preg_replace("#&eth;#isU","ð",$msg);
		$msg=preg_replace("#&ntilde;#isU","ñ",$msg);
		$msg=preg_replace("#&ograve;#isU","ò",$msg);
		$msg=preg_replace("#&oacute;#isU","ó",$msg);
		$msg=preg_replace("#&ocirc;#isU","ô",$msg);
		$msg=preg_replace("#&otilde;#isU","õ",$msg);
		$msg=preg_replace("#&ouml;#isU","ö",$msg);
		$msg=preg_replace("#&divide;#isU","÷",$msg);
		$msg=preg_replace("#&oslash;#isU","ø",$msg);
		$msg=preg_replace("#&ugrave;#isU","ù",$msg);
		$msg=preg_replace("#&uacute;#isU","ú",$msg);
		$msg=preg_replace("#&ucirc;#isU","û",$msg);
		$msg=preg_replace("#&uuml;#isU","ü",$msg);
		$msg=preg_replace("#&yacute;#isU","ý",$msg);
		$msg=preg_replace("#&thorn;#isU","þ",$msg);
		$msg=preg_replace("#&yuml;#isU","ÿ",$msg);
		
		return utf8_decode($msg);
	}
	
	/* function SecurePassword
	 * paramètres :
	 *
	 * $text de type varchar (8 si il est generer)
	 */
	static function Token($text)
	{
		$pass = hash("tiger192,3",sha1($text));

		return $pass;
	}
}
?>