<?php

namespace Wanjee\Shuwee\AdminBundle\Datagrid;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Wanjee\Shuwee\AdminBundle\Admin\Admin;

interface DatagridInterface
{
    /**
     * Configure options
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver);

    /**
     * Get implementation of Admin to use in this datagrid
     *
     * @return \Wanjee\Shuwee\AdminBundle\Admin\Admin
     */
    public function getAdmin();

    /**
     * Add a field to the datagrid.
     *
     * @param string $name
     * @param string $type A valid DatagridFieldType implementation name
     * @param array $options List of options for the given DatagridFieldType
     * @return DatagridInterface
     */
    public function addField($name, $type, $options = []);

    /**
     * Add a filter to the datagrid.
     *
     * @param string $name
     * @param string $type A valid DatagridFilterType implementation name
     * @param array $options List of options for the given DatagridFilterType
     * @return DatagridInterface
     */
    public function addFilter($name, $type, $options = []);

    /**
     * Add an action to the datagrid.
     *
     * @param string $name
     * @param string $type A valid DatagridActionInterface implementation
     * @param array $options List of options for the given DatagridActionInterface implementation
     * @return DatagridInterface
     */
    public function addAction($name, $type, $options = []);

    /**
     * Add a mass action to the datagrid.
     *
     * @param string $type A valid DatagridActionInterface implementation
     * @param string $route
     * @param array $options List of options for the given DatagridActionInterface implementation
     * @return DatagridInterface
     */
    public function addMassAction($type, $route, $options = []);

    /**
     * Return list of all fields configured for this datagrid
     */
    public function getFields();

    /**
     * Returns the pagination object
     *
     * @return
     */
    public function getPagination();

    /**
     * Bind the Request to the Datagrid
     *
     * @param \Wanjee\Shuwee\AdminBundle\Admin\Admin $admin
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function bind(Admin $admin, Request $request);
}
