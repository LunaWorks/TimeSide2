<?php

namespace jobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use jobBundle\Entity\Entity\jobEntity;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class JobController extends Controller
{
     /**
     * @Route("/job")
     */
    public function index(){

      
      return $this->render('job/job.html.twig');

        
    }
    /**
     * @Route("job/job_select")
     */
    public function showAll(){

        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()
      ->getRepository(jobEntity::class);

       $query = $em->createQuery(
          'SELECT j.name,j.id
          FROM jobBundle\Entity\Entity\jobEntity j'
      );
      $jobs = $query->getResult();
      
      return $this->render('job/job_select.html.twig', array(
            'jobs' => $jobs
          ));

        
    }
      /**
     * @Route("job/job_new")
     */
    public function newData()
    {
        
      return $this->render('job/job_new.html.twig');

    }
     /**
     * @Route("job/job_new/{new_job}")
     */
    public function createAction()
    {
    
 $em = $this->getDoctrine()->getManager();

        $job = new jobEntity();
        $job->setName($new_job);
        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($job);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();
        return new Response("Új adat felvétel sikeres! ");
    }

    // if you have multiple entity managers, use the registry to fetch them
    public function editAction()
    {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();
        $em2 = $doctrine->getManager('other_connection');
    }
    
     /**
     * @Route("job/job_search")
     */
    
    public function Search()
    {
        return $this->render('job/job_search.html.twig');
            
    }
    
    /**
     * @Route("/job/job_search/{job_id}", name="job")
     */
    
    public function showAction($job_id)
    {
        $job = $this->getDoctrine()
           ->getRepository(jobEntity::class)
           ->find($job_id);

        if (!$job) {
            throw $this->createNotFoundException(
                'No product found for id '.$job_id
            );
        } else {
            $job_name = $job->getName();
             return new Response('Van ilyen id , '. $job_id. ' Neve: '. $job_name   );
        }
            
    }
      /**
     * @Route("/job/job_update/{job_id}", name="job")
     */
    public function updateAction($job_id)
    {
        $em = $this->getDoctrine()->getManager();
        $job = $em->getRepository(jobEntity::class)->find($job_id);

        if (!$job) {
            throw $this->createNotFoundException(
                'No product found for id '.$job_id
            );
        }

        $job->setName('Policeman');
        $em->flush();

      // return $this->redirectToRoute('index');
     return new Response('Frissités sikeres volt!');
        
    }
}
