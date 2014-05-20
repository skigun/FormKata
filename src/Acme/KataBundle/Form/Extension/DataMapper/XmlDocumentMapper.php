<?php

namespace Acme\KataBundle\Form\Extension\DataMapper;

use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class XmlDocumentMapper implements DataMapperInterface
{
    /**
     * {@inheritdoc}
     */
    public function mapDataToForms($data, $forms)
    {
        $empty = null === $data || array() === $data;

        if (!$empty && !is_object($data))  {
            throw new UnexpectedTypeException($data, 'object or empty');
        }

        foreach ($forms as $form) {
            $propertyPath = $form->getPropertyPath();

            $config = $form->getConfig();

            if (!$empty && null !== $propertyPath && $config->getMapped()) {
                $form->setData((string) $data->$propertyPath);
            } else {
                $form->setData($form->getConfig()->getData());
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function mapFormsToData($forms, &$data)
    {
        if (null === $data) {
            return;
        }

        if (!is_object($data)) {
            throw new UnexpectedTypeException($data, 'object, array or empty');
        }

        foreach ($forms as $form) {
            $propertyPath = $form->getPropertyPath();
            $config = $form->getConfig();

            // Write-back is disabled if the form is not synchronized (transformation failed),
            // if the form was not submitted and if the form is disabled (modification not allowed)
            if (null !== $propertyPath && $config->getMapped() && $form->isSubmitted() && $form->isSynchronized() && !$form->isDisabled()) {
                $data->$propertyPath = $form->getData();
            }
        }
    }
}
