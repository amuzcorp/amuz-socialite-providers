<?php

namespace SocialiteProviders\Amuz;

use Laravel\Socialite\Two\User as BaseUser;

class User extends BaseUser
{
    /**
     * Get the crew's profile if available.
     *
     * @return array|null
     */
    public function getCrew()
    {
        return $this->user['crew'] ?? null;
    }

    /**
     * Get the manager's profile if available.
     *
     * @return array|null
     */
    public function getManager()
    {
        return $this->user['manager'] ?? null;
    }

    /**
     * Get the company information related to the manager.
     *
     * @return array|null
     */
    public function getCompany()
    {
        return $this->user['manager']['client'] ?? null;
    }

    /**
     * Check if the user is a crew member.
     *
     * @return bool
     */
    public function isCrew()
    {
        return !empty($this->getCrew());
    }

    /**
     * Check if the user is a manager (client/supplier/partner).
     *
     * @return bool
     */
    public function isManager()
    {
        return !empty($this->getManager());
    }
}
