<?php

namespace Wanjee\Shuwee\AdminBundle\Datagrid;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Wanjee\Shuwee\AdminBundle\Admin\AdminInterface;

/**
 * Allow datagrid to be filtered on different field
 */
interface FilterableDatagridInterface extends DatagridInterface
{
    /**
     * Add condition on class that let it to be filterd on different added fields
     *
     * @method addCondition
     * @param  string $field object field on which add condition
     * @param  string $value field value
     */
    public function addCondition($field, $value);
}
