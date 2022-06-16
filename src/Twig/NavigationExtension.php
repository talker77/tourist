<?php

namespace App\Twig;
use App\Entity\NavigationItem;
use App\Service\NavigationService;
use App\Utility\StringUtility;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class NavigationExtension extends AbstractExtension
{

    private $navigationService;

    private $locale;
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(NavigationService $navigationService,RouterInterface $router)
    {
        $this->locale =  \Locale::getDefault();
        $this->navigationService = $navigationService;
        $this->router = $router;
    }


    public function getFilters()
    {
        return [
            new TwigFilter('navigation', [$this, 'navigation']),
            new TwigFilter('navigationTree', [$this, 'navigationTree']),
            new TwigFilter('alink', [$this, 'alink']),
            new TwigFilter('slugify', [$this, 'slugify']),
        ];
    }

    public function alink(NavigationItem $navigationItem)
    {
        return $this->getActiveUrl($navigationItem);
    }

    private function getActiveUrl(NavigationItem $navigationItem)
    {
        if($navigationItem->getDocument())
        {
            return $this->router->generate('app_general_index',array('slug'=> $navigationItem->getDocument()->getHandle()));
        }


        if($navigationItem->getUrl() && $navigationItem->getUrl() != '')
        {
            return $navigationItem->getUrl();
        }

        return "#";

    }

    public function navigation($slug)
    {
       return $this->navigationService->getNavigationItemWithPlaceHolder($slug,$this->locale);
    }

    public function slugify($slug)
    {
        return StringUtility::urlSlugify($slug);
    }

    public function navigationTree($slug)
    {
        $navigation = $this->navigationService->getNavigationBySlug($slug,$this->locale);
        $items = $this->navigationService->getNavigationItems($navigation);

        return array('name'=>$navigation->getName(),'items'=> $items,'title'=>$navigation->getTitle());
    }

    public function getName()
    {
        return 'navigation_extension';
    }
}