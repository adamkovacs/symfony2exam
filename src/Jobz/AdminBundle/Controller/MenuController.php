<?php

namespace Jobz\AdminBundle\Controller;

use Jobz\CoreBundle\Entity\Menu;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/*
 * Class MenuController
 */
class MenuController extends Controller
{
    /**
     * @return array
     *
     * @Route("/menu/")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $menus = $em->getRepository('CoreBundle:Menu')->findAll();

        return array(
            'menus' => $menus,
        );
    }

    /**
     * @param Request $request
     *
     * @return array
     *
     * @Route("/menu/new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction(Request $request)
    {
        $menu = new Menu();
        $form = $this->createForm('Jobz\CoreBundle\Form\MenuType', $menu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();
            return $this->redirectToRoute('jobz_admin_menu_index');
        }
        return array(
            'menu' => $menu,
            'form' => $form->createView(),
        );
    }

    /**
     * @param Request $request
     * @param Menu    $menu
     *
     * @return array
     *
     * @Route("/menu/{id}/edit")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, Menu $menu)
    {
        $deleteForm = $this->createDeleteForm($menu);
        $editForm = $this->createForm('Jobz\CoreBundle\Form\MenuType', $menu);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();
            return $this->redirectToRoute('jobz_admin_menu_edit', array('id' => $menu->getId()));
        }
        return array(
            'menu' => $menu,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @param Request $request
     * @param Menu    $menu
     *
     * @return RedirectResponse
     *
     * @Route("/menu/{id}")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Menu $menu)
    {
        $form = $this->createDeleteForm($menu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($menu);
            $em->flush();
        }
        return $this->redirectToRoute('jobz_admin_menu_index');
    }

    /**
     * @param Menu $menu
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Menu $menu)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('jobz_admin_menu_delete', array('id' => $menu->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
