<?php

namespace EasyCrontab\Crontab;

use EasyCrontab\Exception\ParserException;
use EasyCrontab\Job;

class CrontabParser
{
    /**
     * @param string $text
     * @return array|Job[]
     */
    public function parse($text)
    {
        $lines = explode(PHP_EOL, $text);
        $lines = array_map('trim', $lines);

        $jobs = array();
        foreach ($lines as $line) {
            $job = $this->parseLine($line);
            if ($job instanceof Job) {
                $jobs[] = $job;
            }
        }

        return $jobs;
    }

    /**
     * @param string $line
     * @return Job|null
     */
    private function parseLine($line)
    {
        if (strlen($line) === 0) {
            return null;
        }
        if ($line[0] === '#') {
            // It's a comment
            return null;
        }

        $elements = explode(' ', $line, 6);
        if (count($elements) < 6) {
            throw ParserException::insufficientArgumentsForJob($line);
        }

        $job = new Job();
        $job->setMinute($elements[0]);
        $job->setHour($elements[1]);
        $job->setDayOfMonth($elements[2]);
        $job->setMonth($elements[3]);
        $job->setDayOfWeek($elements[4]);
        $job->setCommand($elements[5]);

        return $job;
    }

}
