<?php

namespace SocialiteProviders\Amuz;

use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    /**
     * Unique Provider Identifier.
     */
    public const IDENTIFIER = 'AMUZ';

    /**
     * {@inheritdoc}
     */
    protected $scopes = ['read'];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://amuz.co.kr/oauth/authorize', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://amuz.co.kr/oauth/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://amuz.co.kr/api/user', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        // The user data is nested under 'user' key based on the sample
        $data = $user['user'] ?? $user;

        return (new User)->setRaw($user)->map([
            'id' => $data['id'],
            'nickname' => $data['name'],
            'name' => $data['name'],
            'email' => $data['email'],
            'avatar' => $data['profile_photo_url'],
        ]);
    }

    /**
     * Additional configuration keys.
     */
    public static function additionalConfigKeys(): array
    {
        return ['base_url'];
    }
}
