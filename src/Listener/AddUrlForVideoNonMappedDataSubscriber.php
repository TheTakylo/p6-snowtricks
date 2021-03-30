<?php

namespace App\Listener;

use App\Entity\Video;
use App\Service\VideoService\VideoServiceFinder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AddUrlForVideoNonMappedDataSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return array(
            FormEvents::POST_SET_DATA => 'onPostSetData'
        );
    }

    public function onPostSetData(FormEvent $event)
    {
        $form = $event->getForm();

        /** @var Video|null $entity */
        $entity = $event->getData();

        if ($entity && $entity->getPlatform() && $entity->getVideoId()) {
           $form->get('url')->setData(VideoServiceFinder::getLink($entity->getPlatform(), $entity->getVideoId()));
        }
    }
}
