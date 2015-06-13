# EasyCrontab
Object oriented API for reading and writing to/from crontab.

[![Build Status](https://travis-ci.org/taueres/easy-crontab.svg?branch=master)](https://travis-ci.org/taueres/easy-crontab)

## Examples
EasyCrontab is very easy to grasp.

The following examples will cover common use cases of EasyCrontab.

### Print command of the first job registered
```php
$crontab = EasyCrontab\Crontab::create();
$jobs = $crontab->getJobs();
echo $jobs[0]->getCommand();
```

### Add a new job to crontab
```php
$job = new EasyCrontab\Job();
$job->setMinute('*/5');
$job->setHour('5');
$job->setDayOfMonth('*');
$job->setMonth('*');
$job->setDayOfWeek('*');
$job->setCommand('php --version');

$crontab = EasyCrontab\Crontab::create();
$crontab->addJob($job);
$crontab->save();
```

### Edit job info
```php
$crontab = EasyCrontab\Crontab::create();
$jobs = $crontab->getJobs();
$jobs[0]->setDayOfWeek('3');
$crontab->save();
```

### Remove job from crontab
```php
$crontab = EasyCrontab\Crontab::create();
$jobs = $crontab->getJobs();
$crontab->removeJob($jobs[0]);
$crontab->save();
```
