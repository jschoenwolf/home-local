<?php

/**
 * password.php
 *
 * Copyright (c) 2010-2011 Brad Proctor. (http://bradleyproctor.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author      Brad Proctor
 * @copyright   Copyright (c) 2010-2011 Brad Proctor
 * @license     MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @link        http://bradleyproctor.com/
 * @package     framework
 * @since       1.0
 * @version     1.3
 */
/*
 * Required values:
 * AUTH_SALT: a unique site-wide value to compliment the unique salts
 * AUTH_LEVEL: Used for key stretching.  It is used to calculate the number of iterations to run the
 *    hashing algorithm. Raise this to increase security, lower this to make it run faster.  Default value
 *    is 5.
 */
define('AUTH_SALT', 'jZ42&2snyR9j8wm*Fc^j@DZNP&N%4D4q');
define('AUTH_LEVEL', 5);
/**
 * The Password class works by generating a 104-character hash.  The first 16 characters are a unique
 * salt value that is generated for each password.  The rest of the 88 characters is the hash generated
 * by the whirlpool algorithm, which is much stronger than common md5 or sha1 methods.  The hash value is
 * also created using the HMAC method and a site wide key is used to further secure the hash.  The site
 * wide key can be any value, but a very strong 80-character unique value for AUTH_SALT can be generated at
 * http://bradleyproctor.com/tools/salt.php
 *
 * Usage:
 * $hash = Password::createPasswordHash('password');  // Store this value in your database
 *
 * if (Password::comparePassword('password', $hash) === true) {
 *    // Password is correct
 * } else {
 *    // Password was incorrect
 * }
 */
abstract class Jgs_Password
{

    private function __construct()
    {

    }

    /**
     * Generate a password salt
     *
     * @param int $length
     *    The number of characters that the salt should be
     *
     * @return
     *    Returns a salt that can be used to salt a password hash
     */
    final static private function createPasswordSalt($length = 16)
    {
        $salt = '';
        while (strlen($salt) < $length) {
            $salt .= pack('C', dechex(mt_rand()));
        }
        return substr(base64_encode($salt), 0, $length);
    }

    /**
     *  PBKDF2 Implementation (described in RFC 2898)
     *  Password-Based Key Derivation Function
     *  (Simplified, since some variables are known)
     *
     *  @param string $password
     *      The plain text password
     *
     *  @param string $salt
     *      The salt used to generate the hash
     *
     *  @return string
     *      Derived key
     */
    final static private function pbkdf2($password, $salt)
    {
        $hl = strlen(hash('whirlpool', null, true));
        $ib = $b = hash_hmac('whirlpool', $salt . pack('N', 1), $password, true);
        for ($i = 1; $i < AUTH_LEVEL * 1000; $i++) {
            $ib ^= ( $b = hash_hmac('whirlpool', $b . AUTH_SALT, $password, true));
        }
        return base64_encode($ib);
    }

    /**
     * Generate a 104 character password hash
     *
     * @param $password
     *    The plain text password
     *
     * @param $salt
     *    The salt to use to generate the password
     *
     * @return
     *    Returns the 104-character hashed and salted password
     */
    final static public function createPasswordHash($password, $salt = null)
    {
        if (is_null($salt)) {
            $salt = self::createPasswordSalt();
        } else {
            $salt = $salt;
        }
//        $salt or $salt = self::createPasswordSalt();
        return $salt . self::pbkdf2($password, $salt);
    }

    /**
     * Compare a password with a hash
     *
     * @param $password
     *    The plain text password to compare
     *
     * @param $hash
     *    The 104 character password hash
     *
     * @return
     *    Returns TRUE if the password matches, FALSE if not
     */
    final static public function comparePassword($password, $hash)
    {
        return $hash === self::createPasswordHash($password, substr($hash, 0, 16), AUTH_LEVEL);
    }
}