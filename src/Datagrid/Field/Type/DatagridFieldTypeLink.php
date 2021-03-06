<?php

namespace Wanjee\Shuwee\AdminBundle\Datagrid\Field\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Class DatagridFieldTypeURL
 * @package Wanjee\Shuwee\AdminBundle\Datagrid\Field\Type
 */
class DatagridFieldTypeLink extends DatagridFieldType
{
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefaults(
                [
                    'label_link' => 'Link',
                    'mailto' => false,
                ]
            )
            ->setAllowedTypes('label_link', 'string')
            ->setAllowedTypes('mailto', 'bool');
    }

    /**
     * Get administrative name of this type
     * @return string Name of the type
     */
    public function getName()
    {
        return 'datagrid_url';
    }

    /**
     * Get template block name for this type
     * @return string Block name (must be a valid block name as defined in Twig documentation)
     */
    public function getBlockName()
    {
        return 'datagrid_url';
    }

    /**
     * Get prepared view parameters
     *
     * @param \Wanjee\Shuwee\AdminBundle\Datagrid\Field\DatagridFieldInterface $field
     * @param mixed $entity Instance of a model entity
     *
     * @return mixed
     */
    public function getBlockVariables($field, $entity)
    {
        $defaults = parent::getBlockVariables($field, $entity);

        return [
            'value' => $defaults['value'],
            'label_link' => $field->getOption('label_link', 'Link'),
            'mailto' => $field->getOption('mailto', false),
        ] + $defaults;
    }
}
