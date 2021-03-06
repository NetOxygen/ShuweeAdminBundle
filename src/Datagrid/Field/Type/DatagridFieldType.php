<?php
namespace Wanjee\Shuwee\AdminBundle\Datagrid\Field\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;


/**
 * Class DatagridFieldType
 * @package Wanjee\Shuwee\AdminBundle\Datagrid\Field\Type
 */
abstract class DatagridFieldType implements DatagridFieldTypeInterface
{
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(
                [
                    'default_value' => null,
                ]
            )
            ->setDefined(
                [
                    'callback'
                ]
            )
            ->setAllowedTypes('callback', 'callable');
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
        if ($field->getOption('callback')) {
            $value = call_user_func($field->getOption('callback'), $entity);
        }
        else {
            $value = $field->getData($entity);
        }

        return [
            'field_name' => $field->getName(),
            'value' => $value,
            'default_value' => $field->getOption('default_value', 'null'),
        ];
    }
}
