<?php

namespace Acme\KataBundle\Form\EventListener;

use Acme\KataBundle\Entity\Tag;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TagFieldSubscriber implements EventSubscriberInterface
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA    => 'preSetData',
            FormEvents::POST_SUBMIT     => 'postSubmit',
        );
    }

    public function preSetData(FormEvent $event)
    {
        $article = $event->getData();
        $form = $event->getForm();
        $tagsString = '';

        if ($article && $tags = $article->getTags()) {
            foreach ($tags as $tag) {
                $tagsString.= $tag->getTitle().' ';
            }
        }

        $form->add('tags', 'text', array(
            'data' => $tagsString,
        ));
    }

    public function postSubmit(FormEvent $event)
    {
        $article = $event->getData();
        $tagsString = $article->getTags();

        $titles = explode(' ', $tagsString);
        $existingTags = $this->em
            ->getRepository('AcmeKataBundle:Tag')
            ->findByTitle($titles)
        ;

        foreach ($titles as $title) {
            if (!in_array($title, $existingTags)) {
                $tag = new Tag();
                $tag->setTitle($title);
                $this->em->persist($tag);
                $existingTags[] = $tag;
            }
        }

        $article->setTags($existingTags);
    }
}