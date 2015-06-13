<?php

namespace EasyCrontab\Crontab;

use EasyCrontab\Job;
use Symfony\Component\Process\ProcessBuilder;

class CrontabFileManager
{
    /**
     * @param CrontabProcessBuilder $crontabProcessBuilder
     * @param CrontabParser $crontabParser
     * @param CrontabDumper $crontabDumper
     */
    public function __construct(CrontabProcessBuilder $crontabProcessBuilder, CrontabParser $crontabParser, CrontabDumper $crontabDumper)
    {
        $this->crontabProcessBuilder = $crontabProcessBuilder;
        $this->crontabParser = $crontabParser;
        $this->crontabDumper = $crontabDumper;
    }

    /**
     * @return CrontabFileManager
     */
    public static function create()
    {
        $crontabProcessBuilder = new CrontabProcessBuilder(new ProcessBuilder());
        $crontabParser = new CrontabParser();
        $crontabDumper = new CrontabDumper();
        return new self($crontabProcessBuilder, $crontabParser, $crontabDumper);
    }

    /**
     * @return array|Job[]
     */
    public function readJobs()
    {
        $process = $this->crontabProcessBuilder->getCrontabListProcess();
        $process->run();

        return $this->crontabParser->parse($process->getOutput());
    }

    /**
     * @param array|Job[] $jobs
     */
    public function saveJobs(array $jobs)
    {
        $content = $this->crontabDumper->dump($jobs);

        $process = $this->crontabProcessBuilder->getCrontabSetContentProcess();
        $process->setInput($content);
        $process->run();
    }
}
