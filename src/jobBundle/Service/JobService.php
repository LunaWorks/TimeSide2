<?php

namespace jobBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use jobBundle\Entity\Entity\jobEntity;
use Symfony\Component\Form\Form;

class JobService
{
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
}