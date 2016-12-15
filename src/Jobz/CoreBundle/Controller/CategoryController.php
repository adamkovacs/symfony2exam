<?php

namespace Jobz\CoreBundle\Controller;

use Jobz\CoreBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryController extends Controller
{
    /**
     * @Route("/category")
     * @Template()
     */
    public function indexAction()
    {
        return $this->render('CoreBundle:Category:category.html.twig', array(
            // ...
        ));
    }

    /**
     * @return array
     *
     * @Route("/category/{id}")
     * @Template()
     */
    public function showAction(Category $category)
    {
        $jobs = $this->getDoctrine()->getRepository('CoreBundle:Job')->findBy(
            array(
                'category' => $category
            )
        );

        return $this->render(
            'CoreBundle:Category:category.html.twig',
            array(
                'category' => $category,
                'jobs' => $jobs
            )
        );
    }

}
