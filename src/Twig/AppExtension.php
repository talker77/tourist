<?php

namespace App\Twig;

use App\Entity\PageData;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Translation\Exception\NotFoundResourceException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('pageData', [$this, 'getPageData']),
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('getTitle', [$this, 'getTitle']),
            new TwigFilter('getValue', [$this, 'getValue']),
            new TwigFilter('getId', [$this, 'getId']),
            new TwigFilter('removeHtmlElements', [$this, 'removeHtmlElements'])
        ];
    }

    public function getPageData($key): PageData
    {
        try {
            $repository = $this->em->getRepository(PageData::class);
            $pageData = $repository->findOneBy(['key' => $key]);
            return $pageData;
        } catch (\TypeError $exception) {
            return new PageData();
        }
    }

    public function getTitle(PageData $value)
    {
        try {
            return $this->contentReturn($value->getTitle());
        } catch (\TypeError $exception) {
            return 'Content Not found';
        }
    }

    public function getValue(PageData $value)
    {
        try {
            return $this->contentReturn($value->getValue());
        } catch (\TypeError $exception) {
            return 'Content Not found';
        }
    }

    public function getId(PageData $value)
    {
        try {
            return $this->contentReturn($value->getId());
        } catch (\TypeError $exception) {
            return 'Content Not found';
        }
    }

    public function removeHtmlElements($content)
    {
        return strip_tags($content);
    }

    private function contentReturn($result)
    {
        if (!empty($result)) {
            return $result;
        }
        return '<span>Content Not Found</span>';
    }

    public function getName()
    {
        return 'app_extension';
    }
}