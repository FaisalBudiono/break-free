<?php
/**
 * simple method to encrypt or decrypt a plain text string
 * initialization vector(IV) has to be the same when encrypting and decrypting
 * 
 * @param string $action: can be 'encrypt' or 'decrypt'
 * @param string $string: string to encrypt or decrypt
 *
 * @return string
 */
function encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret iv';
    $secret_iv = 'This is my secret iv';

    // hash
    $key = hash('sha256', $secret_key, true);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv, true), 0, openssl_cipher_iv_length($encrypt_method));
    // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($encrypt_method));

    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, OPENSSL_RAW_DATA, $iv);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt($string, $encrypt_method, $key, OPENSSL_RAW_DATA, $iv);
    }
    // var_dump($key);
    return $output;
}
echo "<pre>";

$plain_txt = "123456789 123456789 123456789 123456789 123456789 123456789 1234";
echo "Plain Text = " .$plain_txt. "\n";

$encrypted_txt = encrypt_decrypt('encrypt', $plain_txt);
echo "Encrypted Text = \n";
var_dump($encrypted_txt);

$decrypted_txt = encrypt_decrypt('decrypt', $encrypted_txt);
echo "Decrypted Text = " .$decrypted_txt. "\n";

if ( $plain_txt === $decrypted_txt ) echo "SUCCESS";
else echo "FAILED";

echo "\n";
echo "</pre><hr>";

/*
	End of openssl_encrypt and openssl_decrypt example
*/

// echo "<pre>";
// print_r(openssl_get_cipher_methods());
// echo "</pre>";

// date_default_timezone_set('Asia/Jakarta');
// echo date("d F Y -- H:i");
// var_dump(hash("sha256","asd"));

// var_dump(hash_algos());
// var_dump(hash("sha3-224", "test"));
?>