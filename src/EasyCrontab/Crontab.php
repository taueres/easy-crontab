<?php

namespace EasyCrontab;

use EasyCrontab\Crontab\CrontabFileManager;
use EasyCrontab\Exception\CrontabException;

class Crontab
{
    /**
     * @var CrontabFileManager
     */
    private $fileManager;

    /**
     * @var array|Job[]
     */
    private $jobs;

    /**
     * @param CrontabFileManager $crontabFileManager
     */
    public function __construct(CrontabFileManager $crontabFileManager)
    {
        $this->fileManager = $crontabFileManager;
    }

    /**
     * Load job collection from crontab system file
     * Warning! Job list will be overwritten
     */
    public function load()
    {
        $this->setJobs(
            $this->fileManager->readJobs()
        );
    }

    /**
     * Save current collection of jobs to crontab system file
     */
    public function save()
    {
        if (null === $this->jobs) {
            throw CrontabException::jobsNotLoaded();
        }

        $this->fileManager->saveJobs(
            $this->getJobs()
        );
    }

    /**
     * Get array of jobs, keys contain job identifiers
     *
     * @return array|Job[]
     */
    public function getJobsIdentified()
    {
        if (null === $this->jobs) {
            $this->load();
        }
        return $this->jobs;
    }

    /**
     * Get array of jobs (numeric indexed array)
     *
     * @return array|Job[]
     */
    public function getJobs()
    {
        return array_values($this->getJobsIdentified());
    }

    /**
     * Remove any job registered in the crontab
     */
    public function clear()
    {
        $this->jobs = array();
    }

    /**
     * Overwrite the job collection with the given one
     *
     * @param array|Job[] $jobs
     */
    public function setJobs(array $jobs)
    {
        $this->clear();
        $this->addJobs($jobs);
    }

    /**
     * Append the given jobs to the collection of the crontab
     *
     * @param array|Job[] $jobs
     */
    public function addJobs(array $jobs)
    {
        foreach ($jobs as $job) {
            $this->addJob($job);
        }
    }

    /**
     * Add the given job to the crontab
     *
     * @param Job $job
     * @return string
     */
    public function addJob(Job $job)
    {
        $id = $job->getId();
        if (array_key_exists($id, $this->getJobsIdentified())) {
            throw CrontabException::jobAlreadyExists($job);
        }
        $this->jobs[$id] = $job;

        return $id;
    }

    /**
     * Remove the job with the given identifier from the collection
     * CrontabException will be thrown if the job does not exist
     *
     * @param string $id
     */
    public function removeById($id)
    {
        if ( ! array_key_exists($id, $this->getJobsIdentified())) {
            throw CrontabException::jobDoesNotExistById($id);
        }
        unset($this->jobs[$id]);
    }

    /**
     * Remove the given job from the crontab
     * CrontabException will be thrown if the job does not exist
     *
     * @param Job $job
     */
    public function removeJob(Job $job)
    {
        $this->removeById($job->getId());
    }
}
