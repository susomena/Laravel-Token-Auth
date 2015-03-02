<?php
/**
 * 
 * Author: Jesús Mena
 * Email: suso.mena@gmail.com
 * Date: 27/02/15
 * 
 */

return [

	/*
	|--------------------------------------------------------------------------
	| Expiration time
	|--------------------------------------------------------------------------
	|
	| The time a token is valid. TokenAuth classes automatically check if
	| a token ha expired and creates a new token if necessary. Expiration
	| time expressed in seconds.
	|
	*/

	'expires' => 24*60*60,

	/*
	|--------------------------------------------------------------------------
	| Username authentication field
	|--------------------------------------------------------------------------
	|
	| The field used in the application to authenticate the user. This field
	| is the user's email by default.
	|
	*/

	'username' => 'email'

	];