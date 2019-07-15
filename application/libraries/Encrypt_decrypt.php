<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Encrypt_decrypt{
	public function __construct(){
		$this->ci =& get_instance();
		/** @var string Encryption method. */
		$this->enc_method = 'AES-256-CBC';
	}

	/**
	 * Encrypting data with openssl driver 
	 * using $this->enc_method as the method.
	 *
	 * @param string|array $plain Plain text to be encrypted.
	 *   The acceptable format for the array parameter:
	 *     $array = [
	 *   		['dataName1', 'dataContent1'],
	 *   		['dataName2', 'dataContent2'],
	 *   		['dataNameN', 'dataContentN']
	 *     ];
	 * @param binary $enc_key The encryption key.
	 * @param binary $iv The initialization vector for encryption.
	 * 
	 * @return string|array Pass the encrypted data.
	 */
	public function enc($plain, $enc_key, $iv){
		if(is_array($plain)){
			foreach($plain as $value){
				$data[$value[0]] = openssl_encrypt($value[1], $this->enc_method, $enc_key, OPENSSL_RAW_DATA, $iv);
			}
			return $data;
		}else{
			return openssl_encrypt($plain, $this->enc_method, $enc_key, OPENSSL_RAW_DATA, $iv);
		}
	}

	/**
	 * Decrypting data with openssl driver 
	 * using $this->enc_method as the method.
	 * 
	 * @param string|array $plain Plain text to be decrypted.
	 *   The acceptable format for the array parameter:
	 *     $array = [
	 *   		['dataName1', 'dataContent1'],
	 *   		['dataName2', 'dataContent2'],
	 *   		['dataNameN', 'dataContentN']
	 *     ];
	 * @param binary $enc_key The decryption key.
	 * @param binary $iv The initialization vector for decryption.
	 *
	 * @return string|array Pass the decrypted data.
	 */
	public function dec($cipher, $enc_key, $iv){
		if(is_array($cipher)){
			foreach($cipher as $value){
				$data[$value[0]] = openssl_decrypt($value[1], $this->enc_method, $enc_key, OPENSSL_RAW_DATA, $iv);
			}
			return $data;
		}else{
			return openssl_decrypt($cipher, $this->enc_method, $enc_key, OPENSSL_RAW_DATA, $iv);
		}
	}

}

/* End of file Encrypt_decrypt.php */
/* Location: ./application/libraries/Encrypt_decrypt.php */
