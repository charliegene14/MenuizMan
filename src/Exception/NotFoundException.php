<?php

namespace App\Exception;

use Exception;

class NotFoundException extends Exception
{
    public function __construct() {
        http_response_code(404);
    }
}