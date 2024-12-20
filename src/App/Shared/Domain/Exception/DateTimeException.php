<?php

declare(strict_types=1);

namespace App\Shared\Domain\Exception;

class DateTimeException extends \Exception
{
    public function __construct(\Exception $e)
    {
        parent::__construct('Datetime malformed or not valid', 500, $e);
    }
}
