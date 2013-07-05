<?php

namespace OAuth2\Provider;

use OAuth2\Provider;
use OAuth2\Token_Access;

/*
 * RunKeeper API credentials: http://runkeeper.com/partner/applications/view
 * RunKeeper API docs: http://runkeeper.com/developer/healthgraph/registration-authorization
 */


/**
 * RunKeeper OAuth Provider
 *
 * @package    laravel-oauth2
 * @category   Provider
 * @author     Andreas Creten
 */

class Runkeeper extends Provider {
	/**
	* @var  string  provider name
	*/
	public $name = 'runkeeper';

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
		return 'https://runkeeper.com/apps/authorize';
	}

	/**
	* Returns the access token endpoint for the provider.
	*
	* @return  string
	*/
	public function url_access_token()
	{
		return 'https://runkeeper.com/apps/token';
	}
}
