<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Form\Tests\Extension\Core\DataMapper;

use Acme\KataBundle\Form\Extension\DataMapper\XmlDocumentMapper;
use Acme\KataBundle\Form\Type\ArticleType;
use Symfony\Component\Form\FormConfigBuilder;
use Symfony\Component\Form\FormConfigInterface;
use Symfony\Component\Form\Extension\Core\DataMapper\PropertyPathMapper;
use Symfony\Component\Form\ResolvedFormType;

class PropertyPathMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var XmlDocumentMapper
     */
    private $mapper;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $dispatcher;

    private $xmlDocument;

    protected function setUp()
    {
        $this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->mapper = new XmlDocumentMapper();
        $this->xmlDocument = $this->createXmlDocument();
    }

    private function createXmlDocument()
    {
        return new \SimpleXMLElement(
'<?xml version="1.0"?>
<article>
    <title>test</title>
    <content>plop</content>
    <author>me</author>
</article>'
        );
    }

    /**
     * @param FormConfigInterface $config
     * @param bool                $synchronized
     * @param bool                $submitted
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getForm(FormConfigInterface $config, $synchronized = true, $submitted = true)
    {
        $form = $this->getMockBuilder('Symfony\Component\Form\Form')
            ->setConstructorArgs(array($config))
            ->setMethods(array('isSynchronized', 'isSubmitted'))
            ->getMock();

        $form->expects($this->any())
            ->method('isSynchronized')
            ->will($this->returnValue($synchronized));

        $form->expects($this->any())
            ->method('isSubmitted')
            ->will($this->returnValue($submitted));

        return $form;
    }

    public function testMapDataToForms()
    {
        $config = new FormConfigBuilder('article2', '\StdClass', $this->dispatcher);
        $config->setDataMapper($this->mapper);
        $config->setData($this->xmlDocument);
        $config->setType(new ResolvedFormType(new ArticleType()));
        $form = $this->getForm($config);

        $this->mapper->mapDataToForms($this->xmlDocument, array($form));

        print_r($form->getData()); exit;

        //$this->assertSame(, $form->getData());
    }
}
