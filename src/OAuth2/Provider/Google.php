<?php 

namespace OAuth2\Provider;

use OAuth2\Provider;
use OAuth2\Token_Access;
use OAuth2\Exception;

class Google extends Provider {  
	
	public $name = 'google';
	
	public $human = 'Google';

	public $uid_key = 'uid';
	
	public $method = 'POST';

	public $scope_seperator = ' ';

	public function url_authorize()
	{
		return 'https://accounts.google.com/o/oauth2/auth';
	}

	public function url_access_token()
	{
		return 'https://accounts.google.com/o/oauth2/token';
	}

	public function __construct(array $options = array())
	{
		// Now make sure we have the default scope to get user data
		empty($options['scope']) and $options['scope'] = array(
			'https://www.googleapis.com/auth/userinfo.profile', 
			'https://www.googleapis.com/auth/userinfo.email'
		);
	
		// Array it if its string
		$options['scope'] = (array) $options['scope'];
		
		parent::__construct($options);
	}

	/*
	* Get access to the API
	*
	* @param	string	The access code
	* @return	object	Success or failure along with the response details
	*/	
	public function access($code, $options = array())
	{
		if ($code === null)
		{
			throw new Exception(array('message' => 'Expected Authorization Code from '.ucfirst($this->name).' is missing'));
		}

		return parent::access($code, $options);
	}

	public function get_user_info(Token_Access $token)
	{
		$url = 'https://www.googleapis.com/oauth2/v1/userinfo?alt=json&'.http_build_query(array(
			'access_token' => $token->access_token,
		));
		
		$user = json_decode(file_get_contents($url), true);
		return array(
			'uid' => $user['id'],
			'nickname' => strtolower(\Str::slug($user['name'], '_')),
			'name' => $user['name'],
			'first_name' => $user['given_name'],
			'last_name' => $user['family_name'],
			'email' => $user['email'],
			'location' => null,
			'image' => $user['picture'],
			'description' => null,
			'urls' => array(),
		);
	}
}
