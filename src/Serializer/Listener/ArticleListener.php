<?php


namespace App\Serializer\Listener;


use App\Entity\Article;
use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\Metadata\StaticPropertyMetadata;

class ArticleListener implements EventSubscriberInterface
{

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            [
                'event' => Events::POST_SERIALIZE, //évènement post serialize à écouter
                'format' => 'json', //dans quel format la sérialisation doit se passer
                'class' => Article::class,
                'method' => 'onPostSerialize', // quelle méthode appeler au moment où le listener est appelé
            ]
        ];
    }

    /**
     * @param ObjectEvent $event
     * @var \JMS\Serializer\JsonSerializationVisitor $visitor
     * @throws \Exception
     */

    public static function onPostSerialize(ObjectEvent $event)
    {
        $date = new \DateTime();
        //$event->getVisitor()->addData('serialized_at', $date->format('l jS \of F Y h:i:s A'));
        $visitor = $event->getVisitor();
        $visitor->visitProperty(new StaticPropertyMetadata('', 'subscribed_at', null ), $date->format('l jS \of F Y h:i:s A'));
    }
}