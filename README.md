# EasyCrontab
Object oriented API for reading and writing to/from crontab.

[![Build Status](https://travis-ci.org/taueres/easy-crontab.svg?branch=master)](https://travis-ci.org/taueres/easy-crontab)

## Installing
### Via Composer
```
composer require taueres/easy-crontab
```

### Otherwise manually
Clone git repository.
```
git clone https://github.com/taueres/easy-crontab.git ./vendor/easy-crontab
```
Add the following PSR-4 rules to your autoload system.
```
"psr-4": {
    "EasyCrontab\\": "vendor/easy-crontab/src/EasyCrontab",
    "EasyCrontab\\Test\\": "vendor/easy-crontab/test"
}
```

## Examples
EasyCrontab is very easy to grasp.

The following examples will cover common use cases of EasyCrontab.

### Print command of the first job registered
```php
$crontab = EasyCrontab\CrontabFactory::getCrontab();
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

$crontab = EasyCrontab\CrontabFactory::getCrontab();
$crontab->addJob($job);
$crontab->save();
```

### Edit job info
```php
$crontab = EasyCrontab\CrontabFactory::getCrontab();
$jobs = $crontab->getJobs();
$jobs[0]->setDayOfWeek('3');
$crontab->save();
```

### Remove job from crontab
```php
$crontab = EasyCrontab\CrontabFactory::getCrontab();
$jobs = $crontab->getJobs();
$crontab->removeJob($jobs[0]);
$crontab->save();
```
