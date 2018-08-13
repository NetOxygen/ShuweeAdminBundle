<?php

namespace Wanjee\Shuwee\AdminBundle\Datagrid\Field;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccess;

use Wanjee\Shuwee\AdminBundle\Datagrid\Datagrid;

/**
 * Class DatagridField
 * @package Wanjee\Shuwee\AdminBundle\Datagrid\Field
 */
class DatagridField implements DatagridFieldInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var \Wanjee\Shuwee\AdminBundle\Datagrid\Field\Type\DatagridFieldTypeInterface
     */
    protected $type;

    /**
     * @var array
     */
    protected $options;


    /**
     * @param string $name
     * @param \Wanjee\Shuwee\AdminBundle\Datagrid\Field\Type\DatagridFieldTypeInterface $type
     * @param array $options
     */
    public function __construct($name, $type, $options = [])
    {
        $this->name = $name;
        $this->type = $type;

        // manage options
        $resolver = new OptionsResolver();
        $resolver
            ->setDefaults(
                [
                    'label'        => ucfirst($name),
                    'sortable'     => false,
                    'sort_alias'   => null,
                    'sort_column'  => null,
                    'help'         => null,
                ]
            )
            ->setAllowedTypes('label', ['string'])
            ->setAllowedTypes('sortable', ['boolean'])
            ->setAllowedTypes('sort_alias', ['null', 'string'])
            ->setAllowedTypes('sort_column', ['null', 'string'])
            ->setAllowedTypes('help', ['null', 'string']);

        $type->configureOptions($resolver);

        $this->options = $resolver->resolve($options);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \Wanjee\Shuwee\AdminBundle\Datagrid\Field\Type\DatagridFieldTypeInterface
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasOption($name)
    {
        return array_key_exists($name, $this->options);
    }

    /**
     * @param string $name
     * @param mixed $default
     */
    public function getOption($name, $default = null)
    {
        if ($this->hasOption($name)) {
            return $this->options[$name];
        }

        return $default;
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * @param mixed $row
     * @return mixed
     */
    public function getData($entity)
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $value = $accessor->getValue($entity, $this->name);
        return $value;
    }
}
