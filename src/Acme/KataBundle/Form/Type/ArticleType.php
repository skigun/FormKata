<?php

namespace  Acme\KataBundle\Form\Type;

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
            ->add('title', null, array('help_message' => 'Enter a cool title !'))
            ->add('content', null, array('help_message' => 'Enter a cool Content !'))
            ->add('author', null, array('help_message' => 'Enter a cool Name !'))
            ->add('submit', 'submit')
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'article';
    }
}
