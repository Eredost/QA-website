<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('truncate', [$this, 'truncate']),
        ];
    }

    /**
     * Split a string according to a given size.
     *
     * {{ post.description|truncate(15, "...") }}
     *
     * @author Michaël Coutin <michael.coutin62@gmail.com>
     *
     * @param string $value     The string that will be formatted
     * @param int    $length    The maximum length of the string
     * @param string $separator The separator that will be displayed at the end of the chain if it is too long
     *
     * @return string The formatted string
     *
     * @throws \LogicException when the specified string size is negative.
     */
    public function truncate(string $value, int $length, string $separator): string
    {
        if ($length < 0) {
            throw new \LogicException('The value of the string size cannot be less than 0.');
        }

        if (strlen($value) > $length) {

            return substr($value, 0, $length) . $separator;
        }
        else {

            return $value;
        }
    }
}
