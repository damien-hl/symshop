<?php

namespace App\Doctrine\Listener;

use App\Entity\Category;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Class CategorySlugListener
 * @package App\Doctrine\Listener
 */
class CategorySlugListener
{
    /**
     * @var SluggerInterface
     */
    protected SluggerInterface $slugger;

    /**
     * ProductSlugListener constructor.
     * @param SluggerInterface $slugger
     */
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    /**
     * @param Category $entity
     * @param LifecycleEventArgs $event
     */
    public function prePersist(Category $entity, LifecycleEventArgs $event)
    {
        if (empty($entity->getSlug())) {
            $entity->setSlug(strtolower($this->slugger->slug($entity->getName())));
        }
    }
}
