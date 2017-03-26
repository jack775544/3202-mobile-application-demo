<?php

/**
 * Encrypts a password into a strong hash
 * Logic taken from https://alias.io/2010/01/store-passwords-safely-with-php-and-mysql/
 * @param $password string The password to encrypt
 * @param $cost int The cost of the encryption, higher cost is more processing time but stronger hash
 * @return string A hash of the password
 */
function encrypt_password($password, $cost=10) {
    // Create a random salt
    $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

    // Prefix information about the hash so PHP knows how to verify it later.
    // "$2a$" Means we're using the Blowfish algorithm. The following two digits are the cost parameter.
    $salt = sprintf("$2a$%02d$", $cost) . $salt;
    return crypt($password, $salt);
}


function password_check($password, $hash) {
    return hash_equals($hash, crypt($password, $hash));
}