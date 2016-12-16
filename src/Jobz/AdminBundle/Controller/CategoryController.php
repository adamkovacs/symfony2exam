<?php

namespace Jobz\AdminBundle\Controller;

use Jobz\CoreBundle\Entity\Category;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/*
 * Class CategoryController
 *
 */
class CategoryController extends Controller
{
    /**
     * @return array
     *
     * @Route("/category/")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('CoreBundle:Category')->findAll();

        return array(
            'categories' => $categories,
        );
    }

    /**
     * @param Request $request
     * @param Category    $category
     *
     * @return array
     *
     * @Route("/category/{id}/edit")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, Category $category)
    {
        $editForm = $this->createForm('Jobz\CoreBundle\Form\CategoryType', $category);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('jobz_admin_category_edit', array('id' => $category->getId()));
        }
        return array(
            'category' => $category,
            'edit_form' => $editForm->createView(),
        );
    }
}
