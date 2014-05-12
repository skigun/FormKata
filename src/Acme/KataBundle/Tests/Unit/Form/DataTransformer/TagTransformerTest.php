<?php

namespace Acme\KataBundle\Tests\Unit\Form\DataTransformer;

use Acme\KataBundle\Form\DataTransformer\TagTransformer;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Process\Process;

class TagTransformerTest extends WebTestCase
{
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();

        $process = new Process('php app/console d:f:l --env=test');
        $process->run();
    }

    public function testTransform()
    {
        /** @var EntityManager $em */
        $em = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $dataTransformer = new TagTransformer($em);

        $result = $dataTransformer->transform(null);
        $this->assertSame('', $result);


        $tags = $em->getRepository('AcmeKataBundle:Tag')->findAll();

        $result = $dataTransformer->transform($tags);
        $this->assertSame('chocolat coca nature meteo ', $result);
    }

    public function testReverseTransform()
    {
        /** @var EntityManager $em */
        $em = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $dataTransformer = new TagTransformer($em);

        $result = $dataTransformer->reverseTransform('');
        $this->assertNull($result);

        $result = $dataTransformer->reverseTransform(' ');
        $this->assertNull($result);

        $result = $dataTransformer->reverseTransform('   ');
        $this->assertNull($result);

        $results = $dataTransformer->reverseTransform('pomme cerise');
        $this->assertCount(2, $results);
        $this->assertSame('Acme\KataBundle\Entity\Tag', get_class($results[0]));
        $this->assertSame('pomme', $results[0]->getTitle());
        $this->assertSame('cerise', $results[1]->getTitle());

        $results = $dataTransformer->reverseTransform(' chocolat pomme cerise ');
        $this->assertCount(3, $results);
        $this->assertSame('Acme\KataBundle\Entity\Tag', get_class($results[0]));
        $this->assertSame('chocolat', $results[0]->getTitle());
        $this->assertSame('pomme', $results[1]->getTitle());
        $this->assertSame('cerise', $results[2]->getTitle());
    }
}