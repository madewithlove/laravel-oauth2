<?php

namespace OAuth2\Provider;

use OAuth2\Provider;
use OAuth2\Token_Access;

/*
 * Docs: http://apidocs.mailchimp.com/oauth2/
 */

/**
 * Mailchimp OAuth Provider
 *
 * @package    	laravel-oauth2
 * @category   	Provider
 * @author  	Dave Kelly - hello@davidkelly.ie
 */
class Mailchimp extends Provider {

	public $name = 'mailchimp';

	protected $method = 'POST';

	public function url_authorize()
	{
		return 'https://login.mailchimp.com/oauth2/authorize';
	}

	public function url_access_token()
	{
		return 'https://login.mailchimp.com/oauth2/token';
	}

	public function get_user_info(Token_Access $token)
	{
		$url = 'https://login.mailchimp.com/oauth2/metadata';
		
		$opts = array(
		  'http'=>array(
		    'method'=>"GET",
		    'header'=>"Accept: application/json\r\n" .
		              "Authorization: OAuth $token->access_token\r\n"
		  )
		);
		$context = stream_context_create($opts);
		
		$user = json_decode(file_get_contents($url, false, $context));

		// Create a response from the request
		return array(
			'dc' 			=> $user->dc,				// data center
			'role' 			=> $user->role,
			'accountname' 	=> $user->accountname,
			'login_url' 	=> $user->login_url,
			'api_endpoint' 	=> $user->api_endpoint		
		);
	}
}
