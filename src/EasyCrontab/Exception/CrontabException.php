<?php

namespace EasyCrontab\Exception;

use EasyCrontab\Job;

class CrontabException extends \RuntimeException
{
    public static function jobAlreadyExists(Job $job)
    {
        return new self(
            'A job with the same characteristics already exists in this crontab. Command: ' . $job->getCommand()
        );
    }

    public static function jobDoesNotExistById($id)
    {
        return new self('Crontab does not contain any job with id ' . $id);
    }

    public static function jobsNotLoaded()
    {
        return new self('No changes were made to this crontab before saving');
    }
}
