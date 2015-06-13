<?php

namespace EasyCrontab\Exception;

class ParserException extends \RuntimeException
{
    public static function insufficientArgumentsForJob()
    {
        return new self('Error while parsing crontab file: fields number does not match');
    }
}
