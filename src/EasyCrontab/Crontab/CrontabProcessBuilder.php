<?php

namespace EasyCrontab\Crontab;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

class CrontabProcessBuilder
{
    /**
     * @var ProcessBuilder
     */
    private $processBuilder;

    /**
     * @param ProcessBuilder $processBuilder
     */
    public function __construct(ProcessBuilder $processBuilder)
    {
        $this->processBuilder = $processBuilder;
    }

    /**
     * @return Process
     */
    public function getCrontabListProcess()
    {
        return $this
            ->processBuilder
            ->create(['crontab', '-l'])
            ->getProcess();
    }

    /**
     * @return Process
     */
    public function getCrontabSetContentProcess()
    {
        return $this
            ->processBuilder
            ->create(['crontab', '-'])
            ->getProcess();
    }
}
