# Amuz Socialite Provider

This package provides Amuz OAuth 2.0 support for Laravel Socialite.

## Installation

Add the repository to your `composer.json` (until it is published on Packagist):

```json
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:amuzcorp/amuz-socialite-providers.git"
    }
]
```

Then install via composer:

```bash
composer require socialiteproviders/amuz
```

## Configuration

Add the following to your `config/services.php`:

```php
'amuz' => [
    'client_id' => env('AMUZ_CLIENT_ID'),
    'client_secret' => env('AMUZ_CLIENT_SECRET'),
    'redirect' => env('AMUZ_REDIRECT_URI'),
],
```

## Usage

In your `AppServiceProvider` or `EventServiceProvider` (depending on Laravel version), add the event listener:

```php
use Illuminate\Support\Facades\Event;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Amuz\Provider;

Event::listen(function (SocialiteWasCalled $event) {
    $event->extendSocialite('amuz', Provider::class);
});
```

### Usage in Controller

```php
return Socialite::driver('amuz')->redirect();
```

### Retrieving User Data

The Amuz provider returns a custom User object with helper methods for `crew` and `manager` data:

```php
$user = Socialite::driver('amuz')->user();

// Standard Socialite methods
$user->getId();
$user->getName();
$user->getEmail();

// Amuz specific methods
if ($user->isCrew()) {
    $crew = $user->getCrew();
    // $crew['team'], $crew['position']...
}

if ($user->isManager()) {
    $manager = $user->getManager();
    $company = $user->getCompany(); 
    // $company['business_name'], $company['code']...
}
```
