<?php

namespace App\Doctrine\Listener;

use App\Entity\Product;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * Class ProductSlugListener
 * @package App\Doctrine\Listener
 */
class ProductSlugListener
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
     * @param Product $entity
     * @param LifecycleEventArgs $event
     */
    public function prePersist(Product $entity, LifecycleEventArgs $event)
    {
//        $entity = $event->getObject();
//
//        if (!$entity instanceof Product) {
//            return;
//        }

        if (empty($entity->getSlug())) {
            $entity->setSlug(strtolower($this->slugger->slug($entity->getName())));
        }
    }
}
