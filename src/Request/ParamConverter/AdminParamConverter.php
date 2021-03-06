<?php

namespace Wanjee\Shuwee\AdminBundle\Request\ParamConverter;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Wanjee\Shuwee\AdminBundle\Manager\AdminManager;

class AdminParamConverter implements ParamConverterInterface {
    /**
     * @var \Wanjee\Shuwee\AdminBundle\Manager\AdminManager
     */
    private $adminManager;

    /**
     * @param AdminManager $adminManager
     */
    public function __construct(AdminManager $adminManager)
    {
        $this->adminManager = $adminManager;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter $configuration
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return bool|void
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $param = $configuration->getName();
        $alias = $request->attributes->get('alias');
        if(!$request->attributes->has('alias')) {
            throw new NotFoundHttpException('Cannot find admin without alias');
        }

        try {
            $admin = $this->adminManager->getAdmin($alias);
            $request->attributes->set($param, $admin);
        }
        catch(\InvalidArgumentException $e)
        {
            throw new NotFoundHttpException(sprintf('Cannot find admin with alias "%s"', $alias));
        }
    }

    /**
     * @param \Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter $configuration
     * @return bool
     */
    public function supports(ParamConverter $configuration)
    {
        return in_array('Wanjee\Shuwee\AdminBundle\Admin\AdminInterface', class_implements($configuration->getClass()));
    }
}
