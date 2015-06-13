<?php

require_once './vendor/autoload.php';

$job = new EasyCrontab\Job();
$job->setMonth('5');
$job->setCommand('just a command');
$job->setDayOfWeek('*');
$job->setMinute('33');
$job->setHour('*');
$job->setDayOfMonth('22');

$c = EasyCrontab\Crontab::create();
$c->addJob($job);
$c->save();
