<?php
/**
 * generates a random token by hashing a random number
 *
 * @return string random token
 */
function generateToken() {
	$token = hash("sha512", mt_rand(0, mt_getrandmax()));
	return($token);
}

/**
 * generates hidden form tags for inclusion in a CSRF resistant form
 *
 * @return string hidden input tags
 * @throws RunTimeException if there's no session to store the CSRF data in
*/
function generateInputTags() {

}