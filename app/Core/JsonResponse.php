<?php

namespace App\Core;

class JsonResponse
{
    public function __construct(array $data = [])
    {
        // Pack data to json and return
        print json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        return null;
    }
}
