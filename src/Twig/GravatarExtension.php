<?php

namespace App\Twig;
use Twig\TwigFilter;

class GravatarExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return [
            new TwigFilter('gravatar', [$this, 'gravatar']),
        ];
    }

    function gravatar( $email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array() )
    {
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";

        return $url;
    }

    public function getName()
    {
        return 'gravatar_extension';
    }
}