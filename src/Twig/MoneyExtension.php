<?php

namespace App\Twig;
use Twig\TwigFilter;

class MoneyExtension extends \Twig_Extension
{

    public function getFilters()
    {
        return [
            new TwigFilter('money', [$this, 'money']),
            new TwigFilter('YTL', [$this, 'YTL']),
            new TwigFilter('EURO', [$this, 'EURO']),
        ];
    }


    public function money($val)
    {
        return number_format($val,2, '.', ',')." €";

    }

    public function EURO($val)
    {
        return number_format($val,2, '.', ',')." EUR";

    }

    public function YTL($val)
    {
        return number_format($val,2, '.', ',')." YTL";

    }

    public function getName()
    {
        return 'money_extension';
    }
}