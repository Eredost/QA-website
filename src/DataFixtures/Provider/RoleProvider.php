<?php


namespace App\DataFixtures\Provider;


class RoleProvider
{
    /**
     * Provides all possible roles for an application user.
     *
     * @var array ROLES
     */
    protected const ROLES = [
        'ROLE_USER',
        'ROLE_MODERATOR',
        'ROLE_ADMIN'
    ];

    /**
     * @return array ROLES
     */
    public static function getRoles()
    {
        return static::ROLES;
    }
}
