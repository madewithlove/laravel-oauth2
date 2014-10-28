<?php

namespace OAuth2\Provider;

use OAuth2\Provider;
use OAuth2\Token_Access;

/*
 * Jawbone API credentials: https://jawbone.com/up/developer/account
 * Jawbone API docs: https://jawbone.com/up/developer/authentication
 */


/**
 * Jawbone OAuth Provider
 *
 * @package    laravel-oauth2
 * @category   Provider
 * @author     Andreas Creten
 */

class Slack extends Provider {
	/**
	 * @var  string  provider name
	 */
	public $name = 'slack';

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
		return 'https://slack.com/oauth/authorize';
	}

	/**
	 * Returns the access token endpoint for the provider.
	 *
	 * @return  string
	 */
	public function url_access_token()
	{
		return 'https://slack.com/api/oauth.access';
	}

}
