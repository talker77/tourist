<?php


namespace App\Service;


use App\Entity\Blog;
use App\Repository\BlogRepository;
use Doctrine\ORM\EntityManagerInterface;

class BlogService
{


    /**
     * @var BlogRepository
     */
    private $blogRepository;

    public function __construct(EntityManagerInterface $em,BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function getBlogBySLug($slug): ?Blog
    {
       return $this->blogRepository->findOneBySlug($slug);
    }
}