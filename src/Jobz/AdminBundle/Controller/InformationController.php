<?php

namespace Jobz\AdminBundle\Controller;

use Jobz\CoreBundle\Entity\Information;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/*
 * Class InformationController
 */
class InformationController extends Controller
{
    /**
     * @return array
     *
     * @Route("/information/")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $informations = $em->getRepository('CoreBundle:Information')->findAll();

        return array(
            'informations' => $informations,
        );
    }

    /**
     * @param Request $request
     *
     * @return array
     *
     * @Route("/information/new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction(Request $request)
    {
        $information = new Information();
        $form = $this->createForm('Jobz\CoreBundle\Form\InformationType', $information);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($information);
            $em->flush();
            return $this->redirectToRoute('jobz_admin_information_index');
        }
        return array(
            'information' => $information,
            'form' => $form->createView(),
        );
    }

    /**
     * @param Request $request
     * @param Information    $information
     *
     * @return array
     *
     * @Route("/information/{id}/edit")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, Information $information)
    {
        $deleteForm = $this->createDeleteForm($information);
        $editForm = $this->createForm('Jobz\CoreBundle\Form\InformationType', $information);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($information);
            $em->flush();
            return $this->redirectToRoute('jobz_admin_information_edit', array('id' => $information->getId()));
        }
        return array(
            'information' => $information,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @param Request $request
     * @param Information    $information
     *
     * @return RedirectResponse
     *
     * @Route("/information/{id}")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Information $information)
    {
        $form = $this->createDeleteForm($information);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($information);
            $em->flush();
        }
        return $this->redirectToRoute('jobz_admin_information_index');
    }

    /**
     * @param Information $information
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Information $information)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('jobz_admin_information_delete', array('id' => $information->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
