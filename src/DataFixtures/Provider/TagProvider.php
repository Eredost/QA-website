<?php


namespace App\DataFixtures\Provider;


class TagProvider
{
    /**
     * Provides all possible tags for an question.
     *
     * @var array TAGS
     */
    protected const TAGS = [
        'html',
        'css',
        'javascript',
        'php',
        'symfony',
        'laravel',
        'bash'
    ];

    /**
     * @return array TAGS
     */
    public static function getTags()
    {
        return static::TAGS;
    }
}
