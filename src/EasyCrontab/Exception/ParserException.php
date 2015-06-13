<?php

namespace EasyCrontab\Exception;

class ParserException extends \RuntimeException
{
    public static function insufficientArgumentsForJob()
    {
        return new self();
    }
}
