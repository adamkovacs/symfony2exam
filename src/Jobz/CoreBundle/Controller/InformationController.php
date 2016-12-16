<?php

namespace Jobz\CoreBundle\Controller;

use Jobz\CoreBundle\Entity\Information;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InformationController extends Controller
{
    /**
     * @Route("/information/{id}")
     */
    public function indexAction(Information $information)
    {
        return $this->render(
            'CoreBundle:Information:index.html.twig',
            array(
                'information' => $information
            )
        );
    }

}
