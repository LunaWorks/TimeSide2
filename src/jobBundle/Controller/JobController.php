<?php

namespace jobBundle\Controller;

//Basic Symfony routes
use jobBundle\Service\JobService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
// For database operations
use Symfony\Component\HttpFoundation\Response;
// Form types
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class JobController extends Controller {

    /**
     * @var jobService
     */
    private $jobService = null;

    /**
     * JobController constructor.
     * @param JobService $service
     */
    public function __construct(JobService $service) {
        $this->jobService = $service;
    }

    /**
     * 
     * Thte main menu of the job site.
     * 
     * @Route("/job")
     */
    public function index() {
        return $this->render('job/job.html.twig');
    }

    /**
     * 
     * Select everything from database ordered by the id.
     * 
     * @Route("job/job_select")
     */
    public function getJobs() {
        return $this->render('job/job_select.html.twig', array(
                    'jobs' => $this->jobService->getAllJobs()
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
    public function addJob(Request $request) {
        // Creating form
        $form = $this->createFormBuilder()
                        ->add('name', TextType::class)
                        ->add('Felvesz', SubmitType::class)
                        ->getForm();

        // Process request into form
        $form->handleRequest($request);

        // Render templates depending on previous actions
        if ($this->formProcess($form)) {
            $this->addFlash(
                    'notice', 'Job added'
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
     * @param Form $form
     * @return bool
     */
    public function formProcess($form) {
        if ($form->isSubmitted() && $form->isValid()) {
            // Do the business logic
            return $this->jobService->addJob($form);
        }
        return false;
    }

    /**
     * 
     * Find a job by its id, if it is already in database.
     * 
     * @Route("job/job_search")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function getJob(Request $request) {
        // Creating the form
        $form = $this->createFormBuilder()
                ->add('name', TextType::class)
                ->add('Keres', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Render templates depending on previous actions
            $this->addFlash(
                    'notice', 'Job found'
            );
            // Do the business logic
            $jobs = $this->jobService->getJob($form);

            // Check if this job exists
            if ($jobs) {
                return $this->render(
                                'job/job_select.html.twig', array(
                            'jobs' => $jobs
                ));
            } else {
                return $this->render(
                                'job/job_error.html.twig', array(
                            'data' => $form['name']->getData()
                ));
            }
        } else {
            return $this->render(
                            'job/job_search.html.twig', array(
                        'form' => $form->createView()
            ));
        }
    }

    /**
     * 
     * Select all of the jobs, and select for update the name of the job.
     * @Route("job/job_update")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function getJobsForUpdate() {
        return $this->render('job/job_update.html.twig', array(
                    'jobs' => $this->jobService->getAllJobs()
        ));
    }

    /**
     * 
     * Update the job name.
     * 
     * @Route("job/job_update/{job_id}")
     */
    public function updateJob(Request $request, $job_id) {
        // If the id doesn't exist in the database
            $jobs = $this->jobService->retriveJobById($job_id);
        if ($jobs == null) {

            return $this->render(
                            'job/job_error.html.twig', array(
                        'data' => $job_id
            ));
        } else {
            
            $form = $this->createFormBuilder()
                    ->add('name', TextType::class)
                    ->add('Update', SubmitType::class)
                    ->getForm();
            // Write out the name for updating
            $form['name']->setData($jobs->getName());

            $form->handleRequest($request);
            // Do the business logic and check the form
            if ($form->isSubmitted() && $form->isValid()) {

                $this->jobService->updateJob($form,$jobs);

                $this->addFlash(
                        'notice', 'Job has been updated'
                );
                return $this->redirectToRoute("job_job_getjobs");
            } else {
                return $this->render('job/job_update_id.html.twig', array(
                            'form' => $form->createView()
                ));
            }
        }
    }

    /**
     * 
     * Select all of the jobs, and select for delete the job.
     * 
     * @Route("job/job_delete")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function getJobsForDelete() {
        return $this->render('job/job_delete.html.twig', array(
                    'jobs' => $this->jobService->getAllJobs()
        ));
    }

    /**
     * 
     * Delete the job from database
     * 
     * @Route("job/job_delete/{job_id}")
     */
    public function deleteJob($job_id) {
        if ($this->jobService->retriveJobById($job_id) == null) {
            // If the id doesn't exist in the database
            return $this->render(
                            'job/job_error.html.twig', array(
                        'data' => $job_id
            ));
        } else {
            // Do the business logic
            $this->jobService->removeById($this->jobService->retriveJobById($job_id));

            $this->addFlash(
                    'notice', 'Job has been deleted'
            );
            // Render templates depending on previous actions
            return $this->redirectToRoute("job_job_getjobs");
        }
    }
}
