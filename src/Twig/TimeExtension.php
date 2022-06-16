<?php

namespace App\Twig;
use Twig\TwigFilter;

class TimeExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return [
            new TwigFilter('timeAgo', [$this, 'timeAgo']),
        ];
    }

    public function timeAgo(\DateTime $dater)
    {
        $estimate_time = time() - $dater->getTimestamp();

        if( $estimate_time < 60 )
        {
            return 'Just Now';
        }

       return $dater->format('Y-m-d H:i:s');
    }

    public function getName()
    {
        return 'time_extension';
    }
}