<?php

namespace EasyCrontab\Test\Functional;

use EasyCrontab\Crontab;
use EasyCrontab\Crontab\CrontabDumper;
use EasyCrontab\Crontab\CrontabFileManager;
use EasyCrontab\Crontab\CrontabParser;
use EasyCrontab\Job;
use PHPUnit_Framework_TestCase;

class CrontabTest extends PHPUnit_Framework_TestCase
{
    public function testGetJobs()
    {
        $inputData = file_get_contents(dirname(__DIR__) . '/Data/crontabRead.txt');

        $crontab = $this->getCrontabWithMockedProcesses(
            $this->getMockedProcessRead($inputData),
            $this->getStubbedProcess()
        );

        $jobs = $crontab->getJobs();

        $this->assertCount(2, $jobs);

        $this->assertEquals('d5e2346559b424f98dea78a103240b5863951eac', $jobs[0]->getId());
        $this->assertEquals('this is a command > redirect', $jobs[0]->getCommand());
        $this->assertEquals('3', $jobs[0]->getDayOfMonth());

        $this->assertEquals('9ec7b7230c10479c4621d560652872ec076ff87d', $jobs[1]->getId());
        $this->assertEquals('another example', $jobs[1]->getCommand());
        $this->assertEquals('*', $jobs[1]->getDayOfMonth());
        $this->assertEquals('*/3', $jobs[1]->getDayOfWeek());
    }

    public function testSave()
    {
        $inputData = file_get_contents(dirname(__DIR__) . '/Data/crontabRead.txt');
        $outputData = file_get_contents(dirname(__DIR__) . '/Data/crontabWrite.txt');

        $crontab = $this->getCrontabWithMockedProcesses(
            $this->getMockedProcessRead($inputData),
            $this->getMockedProcessWrite($outputData)
        );

        $jobs = $crontab->getJobs();

        $jobs[0]->setCommand('changed command');

        $newJob = new Job();
        $newJob->setCommand('new command');
        $newJob->setHour('5');
        $newJob->setMinute('4');
        $newJob->setDayOfMonth('3');
        $newJob->setDayOfWeek('2');
        $newJob->setMonth('1');

        $crontab->addJob($newJob);
        $crontab->save();
    }

    public function testRemove()
    {
        $inputData = file_get_contents(dirname(__DIR__) . '/Data/crontabRead.txt');
        $outputData = file_get_contents(dirname(__DIR__) . '/Data/crontabRemoved.txt');

        $crontab = $this->getCrontabWithMockedProcesses(
            $this->getMockedProcessRead($inputData),
            $this->getMockedProcessWrite($outputData)
        );

        $jobs = $crontab->getJobs();

        $crontab->removeJob($jobs[0]);

        $crontab->save();
    }

    public function testCreate()
    {
        $crontab = Crontab::create();
        $this->assertTrue($crontab instanceof Crontab);
    }

    /*
     * ------- PRIVATE
     */

    private function getCrontabWithMockedProcesses($inputProcess, $outputProcess)
    {
        $processBuilder = $this->prophesize('EasyCrontab\Crontab\CrontabProcessBuilder');
        $processBuilder->getCrontabListProcess()->willReturn($inputProcess);
        $processBuilder->getCrontabSetContentProcess()->willReturn($outputProcess);

        return new Crontab(
            new CrontabFileManager(
                $processBuilder->reveal(),
                new CrontabParser(),
                new CrontabDumper()
            )
        );
    }

    private function getMockedProcessRead($content)
    {
        $process = $this->prophesize('Symfony\Component\Process\Process');
        $process->run()->shouldBeCalledTimes(1);
        $process->getOutput()->shouldBeCalledTimes(1)->willReturn($content);
        return $process->reveal();
    }

    private function getMockedProcessWrite($content)
    {
        $process = $this->prophesize('Symfony\Component\Process\Process');
        $process->run()->shouldBeCalledTimes(1);
        $process->setInput($content)->shouldBeCalledTimes(1);
        return $process->reveal();
    }

    private function getStubbedProcess()
    {
        $process = $this->prophesize('Symfony\Component\Process\Process');
        return $process->reveal();
    }
}
