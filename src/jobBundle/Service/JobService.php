<?php

namespace jobBundle\Service;


// Form types
use Symfony\Component\Form\Form;    
use Doctrine\ORM\EntityManagerInterface;
use jobBundle\Entity\Entity\jobEntity;

class JobService {

    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * JobService constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    public function getAllJobs() 
    {          
       return  $this->em
           ->getRepository(jobEntity::class)
            ->findAll();   
    }

    /**
     * @param Form $form
     * @return bool
     */
    public function addJob(Form $form)
    {
        $success = false;
        if($form->isSubmitted() && $form->isValid()){
            $job = new jobEntity();
            $name = $form['name']->getData();
            $job->setName($name);
            $this->em->persist($job);
            $this->em->flush();
            $success = true;
        }
        return $success;
    }
    
     /**
     * @param Form $form
     * @return bool
     */
    public function getJob(Form $form)
    {
        $success = false;
        if($form->isSubmitted() && $form->isValid()){
            $this->em->getRepository(jobEntity::class)->findBy(['name' => $form['name']->getData()]);
            $success = true;
        }
        return $success;
    }
    
     public function getJobId(Form $form)
    {
         $jobs = $this->em->getRepository(jobEntity::class)->findBy(['name' => $form['name']->getData()]);
        if($jobs)
        {
           
           return "id: "." name: ".$form['name']->getData();
           
        }
        else 
        {
            return "no found for ".$form['name']->getData();
        }
    }

    public function Updatejob($job_id)
    {
         $jobs = $this->em
           ->getRepository(jobEntity::class)
           ->find($job_id);
         if($jobs){
             return true;
         } else {
             return false;
         }
    }
    
     public function FindJobForDelete($name)
    {
         $jobs = $this->em->getRepository(jobEntity::class)->findBy(['id' => $name]);
         if($jobs){
             return true;
         } else {
             return false;
         }
    }
    
    public function updateJobs(Form $form, $jobs,$job_id)
    {
        $success = false;
        if($form->isSubmitted() && $form->isValid())
        {
            $jobs = $this->em
                ->getRepository(jobEntity::class)
                ->find($job_id);
            
            if($jobs){       
                $jobs->setName($form['name']->getData());
                $this->em->flush(); 
                $success = true;
            }
        }
        return $success;
    }
    
    public function deleteJob($name)
    {
        $this->em->remove($name);
        $this->em->flush();
        return true;
    }
}
