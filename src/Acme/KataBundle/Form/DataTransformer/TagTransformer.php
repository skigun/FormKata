<?php

namespace Acme\KataBundle\Form\DataTransformer;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Acme\KataBundle\Entity\Tag;

class TagTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms objects (tags) to a string.
     *
     * @param  ArrayCollection|null $tags
     * @return string
     */
    public function transform($tags)
    {
        if (null === $tags) {
            return '';
        }

        $string = '';
        foreach ($tags as $tag) {
            $string.= $tag->getTitle().' ';
        }

        return $string;
    }

    /**
     * Transforms a string to object(s) (tag).
     *
     * @param mixed $titles
     * @throws TransformationFailedException
     * @internal param string $titles
     * @return ArrayCollection
     */
    public function reverseTransform($titles)
    {
        $titles = trim($titles);

        if (empty($titles)) {
            return null;
        }

        $titles = explode(' ', $titles);

        $existingTitles = $this->om
            ->getRepository('AcmeKataBundle:Tag')
            ->findByTitle($titles)
        ;

        foreach ($titles as $title) {
            if (!in_array($title, $existingTitles)) {
                $tag = new Tag();
                $tag->setTitle($title);
                $this->om->persist($tag);
                $existingTitles[] = $tag;
            }
        }

        $this->om->flush();

        return $existingTitles;
    }
}
