<?php

namespace OAuth2\Provider;

use OAuth2\Provider;
use OAuth2\Token_Access;

/*
 * Moves API credentials: https://dev.moves-app.com/clients
 * Moves API docs: https://dev.moves-app.com/docs/authentication
 */


/**
 * Moves OAuth Provider
 *
 * @package    laravel-oauth2
 * @category   Provider
 * @author     Andreas Creten
 */

class Moves extends Provider {
	/**
	* @var  string  provider name
	*/
	public $name = 'moves';

	/**
	 * @var  string  the method to use when requesting tokens
	 */
	protected $method = 'POST';

	/**
	 * Returns the authorization URL for the provider.
	 *
	 * @return  string
	 */
	public function url_authorize()
	{
		return 'https://api.moves-app.com/oauth/v1/authorize';
	}

	/**
	* Returns the access token endpoint for the provider.
	*
	* @return  string
	*/
	public function url_access_token()
	{
		return 'https://api.moves-app.com/oauth/v1/access_token';
	}
}
