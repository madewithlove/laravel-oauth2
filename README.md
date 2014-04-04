# Laravel OAuth 2.0

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
- Moves
- Runkeeper
- Windows Live
- YouTube

## Usage Example

http://example.com/auth/session/facebook

```php
<?php
use OAuth2\OAuth2;
use OAuth2\Token_Access;
use OAuth2\Exception as OAuth2_Exception;

/**
 *
 * Controller containing user functions & actions
 *
 * ===========================================================
 * Must be using PHP>=5.4 because using [] instead of array()
 * ===========================================================
 *
 */
class UserController extends BaseController {
    
    /**
     * oAuth2 login
     *
     * @param string $provider
     * @return response
     */
public function oauth2Login($provider) {
		switch ($provider) {
			case 'facebook':
				$credentials = [
					'id' 		=> 'client-id',
					'secret' 	=> 'client-secret'
				];
				break;
			default:
				// Google
				$credentials = [
					'id' 		=> 'client-id',
					'secret' 	=> 'client-secret'
				];
		}

		$provider = OAuth2::provider($provider, $credentials);

		if (!Input::has('code')) {
			// Authorize the user - redirect back here with a code to retrieve the users information
			return $provider->authorize();
		} else {
			// Get the user JSON array from the provider
			$user = $provider->get_user_info((new Token_Access([
				'access_token' => $provider->access(Input::get('code'))->access_token
			])));

			// Here you should use this information to A) look for a user B) help a new user sign up with existing data.
			//dd('<pre>' . var_dump($user) . '</pre>');
            
			$name 	= explode(' ', $user['name']);
			$email 	= $user['email'];
			$user 	= User::whereRaw('first_name = ? and last_name = ? and email = ?', [$name[0], end($name), $email]);

			if (0 == $user->count()) {
				$user = User::create([
					'first_name' 	=> $name[0],
					'last_name'		=> end($name),
					'email'			=> $email
				]);
                
				Auth::login($user);
			} else {
				Auth::login($user->first());
			}

			return Redirect::to(action('GeneralController@showHome'));
		}
	}
}

```
