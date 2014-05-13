<?php

namespace Acme\KataBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HelpMessageExtension extends AbstractTypeExtension
{
    public function getExtendedType()
    {
        return 'form';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array('help_message'));
        $resolver->setAllowedTypes(array('help_message' => array('string')));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (array_key_exists('help_message', $options)) {
            $view->vars['help_message'] = $options['help_message'];
        }
    }
}
