# Amuz Socialite Provider

이 패키지는 Laravel Socialite를 위한 Amuz OAuth 2.0 지원을 제공합니다.

## 설치 (Installation)

`composer.json`에 저장소를 추가하세요 (Packagist에 게시되기 전까지):

```json
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:amuzcorp/amuz-socialite-providers.git"
    }
]
```

그 다음 composer를 통해 설치하세요:

```bash
composer require socialiteproviders/amuz
```

## 설정 (Configuration)

`config/services.php`에 다음 내용을 추가하세요:

```php
'amuz' => [
    'client_id' => env('AMUZ_CLIENT_ID'),
    'client_secret' => env('AMUZ_CLIENT_SECRET'),
    'redirect' => env('AMUZ_REDIRECT_URI'),
],
```

## 사용법 (Usage)

`AppServiceProvider` 또는 `EventServiceProvider` (Laravel 버전에 따라 다름)에서 이벤트 리스너를 추가하세요:

```php
use Illuminate\Support\Facades\Event;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Amuz\Provider;

Event::listen(function (SocialiteWasCalled $event) {
    $event->extendSocialite('amuz', Provider::class);
});
```

### 컨트롤러에서의 사용 (Usage in Controller)

```php
return Socialite::driver('amuz')->redirect();
```

### 사용자 데이터 조회 (Retrieving User Data)

Amuz 제공자는 `crew`와 `manager` 데이터를 위한 도우미 메서드가 포함된 사용자 정의 User 객체를 반환합니다:

```php
$user = Socialite::driver('amuz')->user();

// 표준 Socialite 메서드
$user->getId();
$user->getName();
$user->getEmail();

// Amuz 전용 메서드
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
