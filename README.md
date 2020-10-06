# Laravel OAuth 2.0

** ⚠️ This package is abandoned **

Please use [Laravel Socialite](https://laravel.com/docs/8.x/socialite) for OAuth logins instead of this outdated package.

**This is a port to Laravel 4 of Talor Otwell's Laravel-oAuth2 bundle. Which he based on the CodeIgniter OAuth2 Spark maintained by Phil Sturgeon**

Authorize users with your application in a driver-base fashion meaning one implementation works for multiple OAuth 2 providers. This is only to authenticate onto OAuth2 providers and not to build an OAuth2 service.

Note that this package *ONLY* provides the authorization mechanism. There's an example controller below.

## Installation via Composer

Add this to you composer.json file, in the require object;

    "madewithlove/laravel-oauth2": "0.4.*"

After that, run composer install to install Laravel OAuth 2.0.

## Currently Supported

- Facebook
- Foursquare
- GitHub
- Google
- iHealth
- Jawbone
- Mailchimp
- Misfit
- Moves
- Runkeeper
- Strava
- Uber
- Under Armour
- Windows Live
- YouTube

## Usage Example

http://example.com/auth/session/facebook

```php

use OAuth2\OAuth2;
use OAuth2\Token_Access;
use OAuth2\Exception as OAuth2_Exception;

public function action_session($provider)
{
	$provider = OAuth2::provider($provider, array(
		'id' => 'your-client-id',
		'secret' => 'your-client-secret',
	));

	if ( ! isset($_GET['code']))
	{
		// By sending no options it'll come back here
		return $provider->authorize();
	}
	else
	{
		// Howzit?
		try
		{
			$params = $provider->access($_GET['code']);
			
        		$token = new Token_Access(array(
        			'access_token' => $params->access_token
        		));
        		$user = $provider->get_user_info($token);

			// Here you should use this information to A) look for a user B) help a new user sign up with existing data.
			// If you store it all in a cookie and redirect to a registration page this is crazy-simple.
			echo "<pre>";
			var_dump($user);
		}
		
		catch (OAuth2_Exception $e)
		{
			show_error('That didnt work: '.$e);
		}
	}
}
```
