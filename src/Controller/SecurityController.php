<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

class SecurityController extends AppController 
{		
	/**
	 * Below are encryption functions by using unique key with url safe character output
	 * @link http://www.99points.info/2010/06/php-encrypt-decrypt-functions-to-encrypt-url-data/
	 */
	 
	/***** start *****/
	private function safe_b64encode($string) {
		$data = base64_encode($string);
		$data = str_replace(['+', '/', '='], ['-', '_', ''], $data);
		return $data;
	}
	
	private function safe_b64decode($string) {
		$data = str_replace(['-', '_'], ['+', '/'], $string);
		$mod4 = strlen($data) % 4;
		
		if ($mod4) {
			$data .= substr('====', $mod4);
		}
		
		return base64_decode($data);
	}
	
	public function encode($value) {
		if (!$value) {
			return false;
		}
		
		$text = $value;
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, Configure::read('unique_key'), $text, MCRYPT_MODE_ECB, $iv);
		
		return trim($this->safe_b64encode($crypttext));
	}
	
	public function decode($value) {
		if (!$value) {
			return false;
		}
		
		$crypttext = $this->safe_b64decode($value);
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, Configure::read('unique_key'), $crypttext, MCRYPT_MODE_ECB, $iv);
		
		return trim($decrypttext);
	}
	/***** end *****/
	
	/**
	 * base64url_encode method
	 * encode url
	 * @param string $data
	 * @return string $data
	 */
	function base64url_encode($data) {
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}
	
	/**
	 * base64url_decode method
	 * decode url
	 * @param string $data
	 * @return string $data
	 */
	function base64url_decode($data) {
		return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
	}
	
	/**
	 * random method
	 * generate random string
	 * @param int $length
	 * @return string $result
	 */
	public function random($length) {
		$result = "";
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$charArray = str_split($chars);
		for ($i = 0; $i<$length; $i++) {
			$randItem = array_rand($charArray);
			$result .= "". $charArray[$randItem];
		}
		return $result;
	}
}
