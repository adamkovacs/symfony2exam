<?php

namespace Jobz\AdminBundle\Controller;

use Jobz\CoreBundle\Entity\Job;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/*
 * Class JobController
 * */
class JobController extends Controller
{
    /**
     * @return array
     *
     * @Route("/")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $jobs = $em->getRepository('CoreBundle:Job')->findAll();

        return array(
            'jobs' => $jobs,
        );
    }

    /**
     * @param Job $job
     *
     * @return array
     *
     * @Route("/{id}")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Job $job)
    {
        $deleteForm = $this->createDeleteForm($job);
        return array(
            'job'        => $job,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @param Request $request
     * @param Job    $job
     *
     * @return array
     *
     * @Route("/{id}/edit")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, Job $job)
    {
        $deleteForm = $this->createDeleteForm($job);
        $editForm = $this->createForm('Jobz\CoreBundle\Form\JobType', $job);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();
            return $this->redirectToRoute('jobz_admin_job_edit', array('id' => $job->getId()));
        }
        return array(
            'job' => $job,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * @param Request $request
     * @param Job    $job
     *
     * @return RedirectResponse
     *
     * @Route("/{id}")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Job $job)
    {
        $form = $this->createDeleteForm($job);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($job);
            $em->flush();
        }
        return $this->redirectToRoute('jobz_admin_job_index');
    }
    /**
     * @param Job $job
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Job $job)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('jobz_admin_job_delete', array('id' => $job->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}

