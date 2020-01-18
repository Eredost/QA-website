<?php


namespace App\DataFixtures\Provider;


class TagProvider
{
    protected const TAGS = [
        'html',
        'css',
        'javascript',
        'php',
        'symfony',
        'laravel',
        'bash'
    ];

    public static function getTags()
    {
        return static::TAGS;
    }
}
