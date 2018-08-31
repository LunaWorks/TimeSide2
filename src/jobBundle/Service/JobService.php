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
    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function getAllJobs() {
        return $this->em
                        ->getRepository(jobEntity::class)
                        ->findAll();
    }

    /**
     * @param Form $form
     * @return bool
     */
    public function addJob(Form $form) {
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
     * @return bool
     */
    public function getJob(Form $form) {
        $success = false;
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->getRepository(jobEntity::class)->findBy(['name' => $form['name']->getData()]);
            $success = true;
        }
        return $success;
    }

    /**
     * @param Form $form
     * @return jobEntity
     */
    public function getJobId(Form $form) {
        return $this->em->getRepository(jobEntity::class)->findBy(['name' => $form['name']->getData()]);
    }

    /**
     * @param int $job_id
     * @return jobEntity
     */
    public function getJobName($job_id) {
        return $this->em->getRepository(jobEntity::class)->find($job_id);
    }

    /**
     * @param int $job_id
     * @return bool
     */
    public function getForUpdate($job_id) {
        $jobs = $this->em
                ->getRepository(jobEntity::class)
                ->find($job_id);
        if ($jobs) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param Form $form , jobEntity $jobs
     * @return bool
     */
    public function updateJob(Form $form, $jobs) {
        $success = false;
        if ($form->isSubmitted() && $form->isValid()) {

            if ($jobs) {
                $jobs->setName($form['name']->getData());
                $this->em->flush();
                $success = true;
            }
        }
        return $success;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function FindJobForDelete($name) {
        $jobs = $this->em->getRepository(jobEntity::class)->findBy(['id' => $name]);
        if ($jobs) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param jobEntity $job
     * @return bool
     */
    public function deleteJob($job) {
        $this->em->remove($job);
        $this->em->flush();
        return true;
    }
}
