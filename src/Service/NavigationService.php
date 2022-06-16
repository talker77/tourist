<?php

namespace App\Service;

use App\Entity\Navigation;
use App\Entity\NavigationItem;
use App\Repository\NavigationItemRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NavigationService
{

    private $container;

    private $em;

    private $navigationItemRepository ;


    public function __construct(ContainerInterface $container,NavigationItemRepository $navigationItemRepository)
    {
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager();
        $this->navigationItemRepository = $navigationItemRepository;
    }

    private $allSubCategories = array();



    public function createNavigation(Navigation $navigation,$name,$url,$parent = null,$target = null,$extraClass = null)
    {

        $parent =$this->navigationItemRepository->find($parent);
        $category = new NavigationItem();
        $category->setName($name);
        $category->setParent($parent);
        $category->setNavigation($navigation);
        $category->setUrl($url);
        $this->em->persist($category);
        $this->em->flush();
        $category->setOrder(999);
        $this->reGenerateTree($navigation);
        return $category;

    }


    /**
     * @param $slug
     * @return Navigation
     */
    public function getNavigationBySlug($slug,$locale ="tr")
    {
        return  $this->em->getRepository(Navigation::class)->findOneBy(array('placeHolder'=>$slug,'lang'=>$locale,'deletedAt'=>null));

    }

    public function getNavigationItems($navigation)
    {
        $items =  $this->em->getRepository(NavigationItem::class)->findBy(array('navigation'=>$navigation),array('order'=>'asc'));

        $cats = array();
        foreach($items as $item)
        {
            $parent = $item->getParent() ? $item->getParent()->getId() : "0";
            $cats[$parent][] = $item;
        }



        return $cats;
    }


    public function getNavigationItemWithPlaceHolder($slug,$locale ="en")
    {
        $navigation =  $this->em->getRepository(Navigation::class)->findOneBy(array('placeHolder'=>$slug,'deletedAt'=>null));

        return $this->getItemsByNavigation($navigation,$locale);
    }

    public function getTreeForJsTree(Navigation $navigation,$locale="en")
    {

        $catNormalize =array();
        $allSubCategories = $this->getItemsByNavigation($navigation,$locale);
        foreach($allSubCategories as $item) {
            $catNormalize[] = array(
                'id' => $item->getId(),
                'parent' => $item->getParent() ? $item->getParent()->getId() : "#",
                'text' => $item->getName(),
                'url' => 'item',
                'state' => array('opened'=>true)

            );
        }


        return $catNormalize;
    }

    /**
     * @param Navigation $navigation
     * @return NavigationItem[]
     */
    public function getItemsByNavigation(Navigation $navigation,$locale = "en")
    {
        return $this->navigationItemRepository->findByLocale($navigation,$locale);
    }

    public function reGenerateTree(Navigation $navigation)
    {
        $allSubCategories = $this->getItemsByNavigation($navigation);
        $this->allSubCategories = $allSubCategories;

        $list = $this->getNavigationTree(null);
        $this->updateNestedDataFromArray($list);
    }

    /**
     * @param $itemId
     * @param $parent
     * @param $position
     * @return NavigationItem|null
     */
    public  function moveItem($id, $parentId, $position){

        $navigationItem = $this->navigationItemRepository->find($id);
        $parent =  $this->navigationItemRepository->find($parentId);
        
        $navigationItem->setOrder($position);
        $navigationItem->setParent($parent);
        $this->em->flush();

        $this->reGenerateTree($navigationItem->getNavigation());

        return $navigationItem;
    }

    public  function getNavigationTree($parent,$topCategory= null)
    {

        $categories = $this->filterSubByParent($parent);
        $list = array();
        if($categories) {
            foreach ($categories as $category) {

                if($category->getParent() == null) $topCategory = $category->getId();

                $tree = $this->getNavigationTree($category->getId(),$topCategory);
                $list[$category->getId()] = array(
                    'left' => $category->getLeft(),
                    'right' => $category->getRight(),
                    'level' => $category->getLevel(),
                    'name' => $category->getName(),
                    'top'   =>$topCategory,
                    'child' => $tree
                );

            }
        }
        return $list;
    }


    public  function updateNestedDataFromArray($list = array(), &$left = -1, &$right = 0, $depth = 0)
    {
        foreach ($list as $categoryId => $item) {
            $left += 2;
            $list[$categoryId]['left'] = $left;
            $list[$categoryId]['level'] = $depth;
            if ($item['child']) {
                $list[$categoryId]['child'] = self::updateNestedDataFromArray($item['child'], $left, $right, $depth + 1);
            }
            $right = $left + 2;
            $left += 2;
            $list[$categoryId]['right'] = $right;

            $this->updateNavigationItem(
                $categoryId,
                $list[$categoryId]['left'],
                $list[$categoryId]['right'],
                $list[$categoryId]['level'],
                $list[$categoryId]['top']
            );
        }
        return $list;
    }


    public function updateNavigationItem($id,$left,$right,$level,$top)
    {
        $nav = $this->navigationItemRepository->find($id);
        $nav->setLeft($left);
        $nav->setRight($right);
        $nav->setLevel($level);
        $nav->setTop($top);
        $this->em->flush();
    }


    /**
     * @param $subId
     * @return NavigationItem[]
     */
    private function filterSubByParent($subId)
    {
        $subs = array();
        foreach($this->allSubCategories as $subCategory)
        {
            if($subCategory->getParent() && $subCategory->getParent()->getId() == $subId) {
                array_push( $subs, $subCategory );
            }elseif($subId == 0 && $subCategory->getParent() == null)
            {
                array_push( $subs, $subCategory );
            }
        }

        if(count($subs)) return $subs;

        return null;
    }












}
