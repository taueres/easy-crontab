<?php

namespace EasyCrontab\Exception;

use EasyCrontab\Job;

class CrontabException extends \RuntimeException
{
    public static function jobAlreadyExists(Job $job)
    {
        return new self();
    }

    public static function jobDoesNotExistById($id)
    {
        return new self();
    }

    public static function jobsNotLoaded()
    {
        return new self();
    }
}
