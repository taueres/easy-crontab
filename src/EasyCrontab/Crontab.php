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
     * @return Crontab
     */
    public static function create()
    {
        $fileManager = CrontabFileManager::create();
        return new self($fileManager);
    }

    public function load()
    {
        $this->setJobs(
            $this->fileManager->readJobs()
        );
    }

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
     * @return array|Job[]
     */
    public function getJobs()
    {
        if (null === $this->jobs) {
            $this->load();
        }
        return $this->jobs;
    }

    public function clear()
    {
        $this->jobs = array();
    }

    /**
     * @param array|Job[] $jobs
     */
    public function setJobs(array $jobs)
    {
        $this->clear();
        $this->addJobs($jobs);
    }

    /**
     * @param array|Job[] $jobs
     */
    public function addJobs(array $jobs)
    {
        foreach ($jobs as $job) {
            $this->addJob($job);
        }
    }

    /**
     * @param Job $job
     * @return string
     */
    public function addJob(Job $job)
    {
        $id = $job->getId();
        if (array_key_exists($id, $this->getJobs())) {
            throw CrontabException::jobAlreadyExists($job);
        }
        $this->jobs[$id] = $job;

        return $id;
    }

    /**
     * @param string $id
     */
    public function removeById($id)
    {
        if ( ! array_key_exists($id, $this->getJobs())) {
            throw CrontabException::jobDoesNotExistById($id);
        }
        unset($this->jobs[$id]);
    }

    /**
     * @param Job $job
     */
    public function removeJob(Job $job)
    {
        $this->removeById($job->getId());
    }
}
