<?php

namespace App\Helpers;

class Message
{
    private $encryptionKey;

    public function __construct() {
        $this->encryptionKey = config('constants.ENCRYPTION_KEY');
    }

    public static function setFlashMessage($type, $message, $convert = true)
    {
        $output = '<div class="alert alert-' . $type . ' alert-dismissible text-center" role="alert">
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
								<span aria-hidden="true"></span>
							</button>' . ($convert != false ? ucwords(strtolower($message)) : $message)  . '</div>';
        session()->flash('message', $output);
    }

    public static function readMessage()
    {
        if (session()->has('message')) {
            echo session()->get('message');
        }
    }

    public static function encode($plainText , $key = null) {
        $thisClass = new Message();
        if(!empty($key)){
			$thisClass->encryptionKey = $key;
		}
		if (empty($plainText)) {
			return '';
		}
		$ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
		$iv = openssl_random_pseudo_bytes($ivlen);
		$ciphertext_raw = openssl_encrypt($plainText, $cipher, $thisClass->encryptionKey, $options = OPENSSL_RAW_DATA, $iv);
		$hmac = hash_hmac('sha256', $ciphertext_raw, $thisClass->encryptionKey , $as_binary = true);
		$ciphertext = self::safebase64_encode($iv . $hmac . $ciphertext_raw);
		return $ciphertext;
    }

    public static function decode($plainText , $key = null) {
        if (empty($plainText)) {
			return '';
		}
		if(strlen($plainText) < 22 ){
			return '';
		}
		$thisClass = new Message();
		if(!empty($key)){
			$thisClass->encryptionKey = $key;
		}
		$c = self::safebase64_decode($plainText);
		$ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
		$iv = substr($c, 0, $ivlen);
		$hmac = substr($c, $ivlen, $sha2len = 32);
		$ciphertext_raw = substr($c, $ivlen + $sha2len);
		$original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $thisClass->encryptionKey, $options = OPENSSL_RAW_DATA, $iv);
		$calcmac = hash_hmac('sha256', $ciphertext_raw, $thisClass->encryptionKey , $as_binary = true);
		if (hash_equals($hmac, $calcmac))
		{
			return $original_plaintext . "\n";
		}
    }

    public static function safebase64_encode($val)
	{
		return rtrim(strtr(base64_encode($val), '+/', '-_'), '=');
	}

    public static function safebase64_decode($val)
	{
		return base64_decode(str_pad(strtr($val, '-_', '+/'), strlen($val) % 4, '=', STR_PAD_RIGHT));
	}
}
