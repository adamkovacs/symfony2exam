<?php

namespace Jobz\CoreBundle\Controller;

use Jobz\CoreBundle\Entity\Job;
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
    public function indexAction(Request $request)
    {
        $keyword = $request->get('keywords');

        if($keyword != null) {
            $jobs = $this->getDoctrine()->getRepository('CoreBundle:Job')->findByKeyword($keyword);
        } else {
            $jobs = $this->getDoctrine()->getRepository('CoreBundle:Job')->findLatest(10);
        }

        $categories = $this->getDoctrine()->getRepository('CoreBundle:Category')->findAll();

        $array = array();

        if(!empty($jobs)) {
            foreach ($categories as $cat) {
                $counter = 0;
                foreach ($jobs as $job) {
                    if ($cat->getId() == $job->getCategory()->getId()) {
                        $array[$cat->getCategoryName()]['job'][] = $job;
                        $counter++;
                    }
                }
                if ($counter > 0) {
                    $array[$cat->getCategoryName()]['category'] = $cat;
                }
            }
        }

       return $this->render(
            'CoreBundle:Job:index.html.twig',
            array(
                'array' => $array
            )
        );
    }

    /**
     * @return array
     *
     * @Route("/job/{id}")
     * @Template()
     */
    public function showAction(Job $job)
    {
        return $this->render(
            'CoreBundle:Job:job.html.twig',
            array(
                'job' => $job
            )
        );
    }

    /**
     * @return array
     *
     * @Route("/post")
     * @Template()
     */
    public function postAction(Request $request)
    {
        $job = new Job();
        $user = $this->getUser();
        $job->setEmail($user->getEmail());
        $form = $this->createForm('Jobz\CoreBundle\Form\JobType', $job);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush($job);
            return $this->redirectToRoute('jobz_core_job_index');
        }

        return $this->render(
            'CoreBundle:Job:post.html.twig',
            array(
                'job' => $job,
                'form' => $form->createView(),
            )
        );
    }



}
