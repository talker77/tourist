<?php

namespace App\Twig;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CustomStyleExtension extends AbstractExtension
{


    private $host = null;

    public function __construct(ContainerInterface $container)
    {
        $request = $container->get('request_stack');


        if($request->getCurrentRequest()) {
            $this->host = $request->getCurrentRequest()->getHost();
        }
    }


    public function getFilters()
    {
        return [
            new TwigFilter('logo', [$this, 'logo']),
        ];
    }

    public function logo()
    {
        $logo ="img/cityberry_logo_50.png";
        if(substr_count($this->host,"istanbultouristpass"))
        {
            $logo = "img/TouristPassLogoBuyuk.png";
        }

        return $logo;
    }

    public function customCss()
    {

        return "";
    }


    public function getName()
    {
        return 'custom_style_extension';
    }
}