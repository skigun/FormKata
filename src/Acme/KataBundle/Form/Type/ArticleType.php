<?php

namespace  Acme\KataBundle\Form\Type;

use Acme\KataBundle\Form\Extension\DataMapper\XmlDocumentMapper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('author')
            ->add('submit', 'submit')
        ;

        $builder->setDataMapper(new XmlDocumentMapper());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'article';
    }
}
