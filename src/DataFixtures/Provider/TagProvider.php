<?php


namespace App\DataFixtures\Provider;


class TagProvider
{
    /**
     * Provides all possible tags for an question.
     * The key represent the name of the tag and options are contained in the value as array
     *
     * @var array TAGS
     */
    protected const TAGS = [
        [
            'name'      => 'html',
            'bgColor'   => '#2BBBAD',
            'textColor' => '#FFFFFF',
        ],
        [
            'name'      => 'css',
            'bgColor'   => '#4285F4',
            'textColor' => '#FFFFFF',
        ],
        [
            'name'      => 'javascript',
            'bgColor'   => '#F8DC3D',
            'textColor' => '#000000',
        ],
        [
            'name'      => 'php',
            'bgColor'   => '#AA66CC',
            'textColor' => '#FFFFFF',
        ],
        [
            'name'      => 'symfony',
            'bgColor'   => '#000000',
            'textColor' => '#FFFFFF',
        ],
        [
            'name'      => 'laravel',
            'bgColor'   => '#ED615C',
            'textColor' => '#FFFFFF',
        ],
        [
            'name'      => 'bash',
            'bgColor'   => '#3C4548',
            'textColor' => '#FFFFFF',
        ]
    ];

    /**
     * @return array TAGS
     */
    public static function getTags()
    {
        return static::TAGS;
    }
}
