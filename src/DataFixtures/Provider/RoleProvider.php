<?php


namespace App\DataFixtures\Provider;


class RoleProvider
{
    /**
     * Provides all possible roles for an application user.
     * The index of the table will be used to find the different
     * types of users in the references.
     *
     * @var array ROLES
     */
    protected const ROLES = [
        'main'      => 'ROLE_USER',
        'moderator' => 'ROLE_MODERATOR',
        'admin'     => 'ROLE_ADMIN'
    ];

    /**
     * @return array ROLES
     */
    public static function getRoles()
    {
        return static::ROLES;
    }
}
