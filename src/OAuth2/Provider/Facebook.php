<?php

namespace OAuth2\Provider;

use OAuth2\Provider;
use OAuth2\Token_Access;

class Facebook extends Provider
{
	public $name = 'facebook';

	public $uid_key = 'uid';

	public $scope = array('email', 'read_stream');

	public function url_authorize()
	{
		return 'https://www.facebook.com/v2.0/dialog/oauth';
	}

	public function url_access_token()
	{
		return 'https://graph.facebook.com/oauth/access_token';
	}

	public function get_user_info(Token_Access $token)
	{
		$url = 'https://graph.facebook.com/v2.1/me?'.http_build_query(array(
			'access_token' => $token->access_token,
		));

		$user = json_decode(file_get_contents($url));

		// Create a response from the request
		return array(
			'uid' => $user->id,
			'nickname' => (property_exists($user, 'username') ? $user->username : null),
			'first_name'=> (property_exists($user, 'first_name') ? $user->first_name : null),
			'last_name'=> (property_exists($user, 'last_name') ? $user->last_name : null),
			'name' => $user->name,
			'email' => (property_exists($user, 'email') ? $user->email : null),
			'location' => !empty($user->hometown->name) ? $user->hometown->name : null,
			'gender' => (property_exists($user, 'gender') ? $user->gender : null),
			'timezone' => $user->timezone,
			'verified' => $user->verified,
			'image' => 'https://graph.facebook.com/v2.1/me/picture?type=normal&access_token='.$token->access_token,
			'urls' => array(
			  'Facebook' => $user->link,
			),
		);
	}
	
	public function get_user(Token_Access $token)
	{
		$url = 'https://graph.facebook.com/v2.1/me?'.http_build_query(array(
			'access_token' => $token->access_token,
		));

		$user = json_decode(file_get_contents($url), true);
		
		return $user;
	}
}
