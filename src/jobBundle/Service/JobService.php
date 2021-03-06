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
        return $this->em
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
        if ($form->isSubmitted() && $form->isValid()) {
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
     * @return jobEntity
     */
    public function getJob(Form $form) 
    {
        return $this->em->getRepository(jobEntity::class)->findBy(['name' => $form['name']->getData()]);
    }

    /**
     * @param int $job_id
     * @return jobEntity
     */
    public function retriveJobById($job_id) 
    {
        return $this->em->getRepository(jobEntity::class)->find($job_id);
    }

    /**
     * @param Form $form , jobEntity $jobs
     * @return bool
     */
    public function updateJob($form, $job) 
    {

        $job->setName($form['name']->getData());
        $this->em->flush();
    }

    /**
     * @param jobEntity $job_id
     * @return bool
     */
    public function removeJobById($job_id) 
    {
        $job = $this->retriveJobById($job_id);
        $this->em->remove($job);
        $this->em->flush();
    }
}
