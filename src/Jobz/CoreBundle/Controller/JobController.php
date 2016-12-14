<?php

namespace Jobz\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JobController extends Controller
{
    /**
     * @return array
     *
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $latestJobs = $this->getDoctrine()->getRepository('CoreBundle:Job')->findLatest(10);

       return $this->render(
            'CoreBundle:Job:index.html.twig',
            array(
                'latestJobs' => $latestJobs
            )
        );
    }

}
