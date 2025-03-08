<?php

namespace App\Core;

class Request
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';

    public const METHODS = [
        self::METHOD_GET,
        self::METHOD_POST,
    ];
}
