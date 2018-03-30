<?php

namespace jobBundle\Controller;

//Basic Symfony routes
use jobBundle\Service\JobService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
    
// For database operations
use jobBundle\Entity\Entity\jobEntity;
use Symfony\Component\HttpFoundation\Response;

// Form types
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class JobController extends Controller
{
    private $jobService = null;
    /**
     * JobController constructor.
     * @param JobService $service
     */
    public function __construct(JobService $service)
    {
        $this->jobService = $service;
    }
    
     /**
      * 
      * Thte main menu of the job site.
      * 
     * @Route("/job")
     */
    public function index()
    {
      
      return $this->render('job/job.html.twig');
  
    }
    
    /**
     * 
     * Select everything from database ordered by the id.
     * 
     * @Route("job/job_select")
     */
        public function getJobs()      
    {
        $getJobs = $this->getDoctrine()
                           ->getRepository(jobEntity::class)
                           ->findAll();
      return $this->render('job/job_select.html.twig', array(
            'jobs' => $getJobs
      ));
    }

    /**
     * The user can add new job types to the database.
     *
     * TODO: Split form generation and form processing to two separate action.
     *
     * @Route("job/job_new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function addJob(Request $request)
    {
        $success = false;
        // Creating form
        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('Felvesz', SubmitType::class)
            ->getForm();
        // Process request into form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Do the business logic
            $success = $this->jobService->addJob($form);
        }
        // Render templates depending on previous actions
        if($success) {
            $this->addFlash(
               'notice',
               'Job added'
            );
            return $this->redirectToRoute("job_job_getjobs");
        } else {
            return $this->render(
                'job/job_new.html.twig', array(
                'form' => $form->createView()
            ));
        }
    }
    
    
     /**
      * 
      * Find a job by its id, if it is already in database.
      * 
      * @Route("job/job_search")
     */
    
    public function getJob(Request $request)
    {
       $job = new jobEntity();

       $form = $this->createFormBuilder()
        ->add('id', TextType::class)
        ->add('Keres', SubmitType::class)
        ->getForm();
       
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $id = $form['id']->getData();
            
            $job = $this->getDoctrine()
           ->getRepository(jobEntity::class)
           ->find($id);
            
           if (!$job) {
                return new Response('Nincs ilyen id, hogy '.$id );
              } else {
                 $job_name = $job->getName();
                return new Response('Van ilyen id , '. $id. ' Neve: '. $job_name   );
           }
        
        }
        
        return $this->render('job/job_search.html.twig', array(
            'form' => $form->createView()
         ));
            
    }
    
      /**
       * 
       * Select all of the jobs, and select for update the name of the job.
       * 
       * @Route("job/job_update")
     */

    public function getJobsForUpdate(Request $reguest)
    {
 
          $getJobs = $this->getDoctrine()
                           ->getRepository(jobEntity::class)
                           ->findAll();
          
         return $this->render('job/job_update.html.twig', array(
            'jobs' => $getJobs
          ));
    }
    
    
    
     /**
      * 
      * Update the job name.
      * 
      * @Route("job/job_update/{job_id}")
     */
    public function updateJob($job_id,Request $request)
    {
         $jobs = new jobEntity();  
         $em = $this->getDoctrine()->getManager();
         $jobs = $this->getDoctrine()
           ->getRepository(jobEntity::class)
           ->find($job_id);
            
       if (!$jobs) {
           return new Response('Nincs ilyen id, hogy '.$job_id );
        } else {
      
        $form = $this->createFormBuilder()
           ->add('name', TextType::class)
           ->add('Update', SubmitType::class)
           ->getForm();
  
        $name = $form['name']->setData($jobs->getName());
        
        $form->handleRequest($request);
        
            if($form->isSubmitted() && $form->isValid()){

            $name = $form['name']->getData();
            $jobs->setName($name);
            $em->flush();

            return new Response('Frissités sikeres volt!');
            }
         
         return $this->render('job/job_update_id.html.twig', array(
             'form' => $form->createView()
          ));
        }
    } 
}
