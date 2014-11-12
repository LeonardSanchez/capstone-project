<?php


class User
{
	/**
	 * user id for  User; this is the primary key
	 **/
	private $userId;
	/**
	 * email for the User; this is a unique field
	 **/
	private $email;
	/**
	 * SHA512 PBKDF2 hash of the password
	 **/
	private $password;
	/**
	 * salt used in the PBKDF2 hash
	 **/
	private $salt;
	/**
	 * authentication token used for  new accounts and password resets
	 **/
	private $authenticationToken;
}

	/**
	 * constructors for the User
	 * @param mixed $newUserId user id (or null if new object)
	 * @param string $newEmail email
	 * @param string $newPassword PBKDF2 hash of the password
	 * @param string $newSalt salt used in the PBKDF2 hash
	 * @param mixed $newAuthenticationToken authentication token used in new accounts and password resets (or null if active User)
	 * @throws UnexpectedValueException when a parameter is wrong type
	 * @throws RangeException when a parameter is invalid
	 **/

