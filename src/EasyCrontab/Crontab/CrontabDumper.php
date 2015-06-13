<?php

namespace EasyCrontab\Crontab;

use EasyCrontab\Job;

class CrontabDumper
{
    const LINE_FORMAT = "%s %s %s %s %s %s\n";

    /**
     * @param array|Job[] $jobs
     * @return string
     */
    public function dump(array $jobs)
    {
        $content = '';
        foreach ($jobs as $job) {
            $content .= $this->dumpJob($job);
        }

        return $content;
    }

    /**
     * @param Job $job
     * @return string
     */
    private function dumpJob(Job $job)
    {
        return sprintf(
            self::LINE_FORMAT,
            $job->getMinute(),
            $job->getHour(),
            $job->getDayOfMonth(),
            $job->getMonth(),
            $job->getDayOfWeek(),
            $job->getCommand()
        );
    }
}
