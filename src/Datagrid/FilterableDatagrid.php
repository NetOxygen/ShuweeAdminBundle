<?php

namespace Wanjee\Shuwee\AdminBundle\Datagrid;

use Wanjee\Shuwee\AdminBundle\Datagrid\FilterableDatagridInterface;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormFactory;

 /**
  * Class DatagridFilterable
  *
  * Decorate Datagrid class to take in account some additional parameters in query builder.
  *
  * @package Wanjee\Shuwee\AdminBundle\Datagrid
  */
class FilterableDatagrid extends Datagrid implements FilterableDatagridInterface
{
    private $additionnalParameters;

    public function __construct(PaginatorInterface $paginator, EntityManagerInterface $entityManager, FormFactory $factory)
    {
        parent::__construct($paginator, $entityManager, $factory);
        $this->additionnalParameters    = [];
    }

    /**
     * Override of parent getQueryBuilder
     * @method getQueryBuilder
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        $queryBuilder = parent::getQueryBuilder();

        if (!empty($this->additionnalParameters)) {
            foreach ($this->additionnalParameters as $field => $value) {
                $query_key = static::DEFAULT_ENTITY_ALIAS.'.'.$field;
                $parameter = ':__'. $field;
                $queryBuilder->andWhere($queryBuilder->expr()->eq($query_key, $parameter));
                // $parameters[$parameter] = $value;
                $queryBuilder->setParameter($parameter, $value);
            }

        }
        // add $additionnalParameters if exists;
        return $queryBuilder;
    }

    /**
     *
     */
    public function addCondition($field, $value, $is_foreign_key = false)
    {
        $this->additionnalParameters[$field] = $value;

        return $this;
    }
}
