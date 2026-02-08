<?php

namespace SocialiteProviders\Amuz;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider implements ProviderInterface
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
        return $this->buildAuthUrlFromBase(config('services.amuz.base_url') . '/oauth/authorize', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return config('services.amuz.base_url') . '/oauth/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(config('services.amuz.base_url') . '/api/user', [
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

        return (new \SocialiteProviders\Amuz\User)->setRaw($user)->map([
            'id' => $data['id'],
            'nickname' => $data['name'],
            'name' => $data['name'],
            'email' => $data['email'],
            'avatar' => $data['profile_photo_url'],
            'amuz_uuid' => $data['id'],
        ]);
    }
}
