<?php

namespace jobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
    
use jobBundle\Entity\Entity\jobEntity;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class JobController extends Controller
{
    // Thte main menu of the job site.
    
     /**
     * @Route("/job")
     */
    public function index(){
      
      return $this->render('job/job.html.twig');
  
    }
    
    // Select everything from database ordered by the id.
    
    /**
     * @Route("job/job_select")
     */
    public function allJob(){

        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()
      ->getRepository(jobEntity::class);

       $query = $em->createQuery(
          'SELECT j.name,j.id
          FROM jobBundle\Entity\Entity\jobEntity j ORDER BY j.id'
      );
      $jobs = $query->getResult();
      
      return $this->render('job/job_select.html.twig', array(
            'jobs' => $jobs
          ));
    }
    
    // The user can add new job types to the database.

     /**
     * @Route("job/job_new")
     */
    public function addJob(Request $request)
    {
        $job = new jobEntity();

       $form = $this->createFormBuilder()
        ->add('name', TextType::class)
        ->add('Új munka felvétele', SubmitType::class)
        ->getForm();
       
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $name = $form['name']->getData();
            
            $job->setName($name);
            
             $em = $this->getDoctrine()->getManager();
             
             $em->persist($job);
             $em->flush();
             
             $this->addFlash(
               'notice',
               'Job added'
            );
         
         return $this->redirectToRoute("job_select");
        }
        
        return $this->render('job/job_new.html.twig', array(
            'form' => $form->createView()
          ));
        
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
    
    public function getJob(Request $request)
    {
       $job = new jobEntity();

       $form = $this->createFormBuilder()
        ->add('id', TextType::class)
        ->add('Keresés', SubmitType::class)
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
            
             $this->addFlash(
               'notice',
               'Job added'
            );
         
         return $this->redirectToRoute("job_select");
        }
        
        return $this->render('job/job_search.html.twig', array(
            'form' => $form->createView()
          ));
            
    }
    
      /**
     * @Route("job/job_update")
     */
    public function updateAction(Request $reguest)
    {
 
         $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()
      ->getRepository(jobEntity::class);

       $query = $em->createQuery(
          'SELECT j.name,j.id
          FROM jobBundle\Entity\Entity\jobEntity j ORDER BY j.id'
      );
      $jobs = $query->getResult();
      
     
      // return $this->redirectToRoute('index');
         return $this->render('job/job_update.html.twig', array(
            'jobs' => $jobs
          ));
    }
    
     /**
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
        ->add('Update', SubmitType::class)
        ->getForm();
  
             $job_name = $jobs->getName();
          
        

        $form->handleRequest($request);
        
         if($form->isSubmitted() && $form->isValid()){
            
        $jobs->setName($job_name);
        $em->flush();
        
         
         return new Response('Frissités sikeres volt!');
      }
       return $this->render('job/job_update_id.html.twig', array(
            'job_name' => $job_name,
            'form' => $form->createView()
          ));
        }
        
        
    }
}
