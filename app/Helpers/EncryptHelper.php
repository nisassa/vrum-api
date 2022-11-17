<?php

namespace App\Helpers;

/**
 * Helper methods for encrypting as SDCMS.
 */
class EncryptHelper
{
	/**
	 * Length of the salt used by the encrypt method.
	 *
	 * @var	integer
	 */
	protected $salt_length;

	/**
	 * Create a new helper instance.
	 *
	 * @param	int	$salt_length	The length of the salt used by the encrypt method.
	 * @param	string	$algorithm	The length of the salt used by the encrypt method.
	 * @param	int	$iterations	The length of the salt used by the encrypt method.
	 * @param	int	$key_length	The length of the salt used by the encrypt method.
	 * @return void
	 */
	public function __construct($salt_length, $algorithm, $iterations, $key_length)
	{
		$this->salt_length = $salt_length;
		$this->algorithm = $algorithm;
		$this->iterations = $iterations;
		$this->key_length = $key_length;
	}

	/**
	 * Decode from base64 and extract the salt and cryptographic key from the stored secret,
	 * then run the key derivation function against the incoming message and compare the results.
	 *
	 * @param	string	$message	The message to verify.
	 * @param	string	$secret	The existing encrypted message.
	 * @return	bool
	 */
	public function verify($message, $secret)
	{
		$secret = base64_decode($secret);

		$salt = substr($secret, 0, $this->salt_length);

		$key = $this->pbkdf2($message, $salt);

		return substr($secret, $this->salt_length) === $key;
	}

	/**
	 * Return an encrypted string using the same encryption used in SDCMS.
	 *
	 * @param	string	$message	The message to encrypt.
	 * @return	string
	 */
	public function encrypt($message)
	{
		$salt = openssl_random_pseudo_bytes($this->salt_length);

		$key = $this->pbkdf2($message, $salt);

		return base64_encode($salt . $key);
	}

	/**
	 * Implementation of password-based key derivation function based on the following article.
	 *
	 * http://www.itnewb.com/tutorial/Encrypting-Passwords-with-PHP-for-Storage-Using-the-RSA-PBKDF2-Standard
	 *
	 * @param	string	$password
	 * @param	string	$salt
	 * @return	string
	 */
	protected function pbkdf2($password, $salt) {

		$key = '';
		$keyBlocks = ceil($this->key_length / strlen(hash($this->algorithm, null, true)));

		for($block = 1; $block <= $keyBlocks; $block++) {

			$blockHash = hash_hmac($this->algorithm, $salt . pack('N', $block), $password, true);
			$keyHash = $blockHash;

			for($i = 1; $i < $this->iterations; $i++) {
				$blockHash = hash_hmac($this->algorithm, $blockHash, $password, true);
				$keyHash ^= $blockHash;
			}

			$key .= $keyHash;
		}

		return substr($key, 0, $this->key_length);
	}
}
