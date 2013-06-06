<?php

namespace ML\DemoBundle\Controller;

use ML\HydraBundle\Controller\HydraController;
use ML\HydraBundle\Mapping as Hydra;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ML\DemoBundle\Entity\EntryPoint;

/**
 * EntryPoint controller
 *
 * @Route("/")
 */
class EntryPointController extends HydraController
{
    /**
     * The APIs main entry point.
     *
     * @Route("/", name="entry_point")
     * @Method("GET")
     *
     * @Hydra\Operation()
     *
     * @return ML\DemoBundle\Entity\EntryPoint
     */
    public function getAction()
    {
        return new EntryPoint($this->getUser());
    }
}
