<?php

namespace App\Core;

class ViewResponse
{
    public function __construct(string $viewTemplate, array $params = [])
    {
        // Stop directory traversal attack
        if (strpos($viewTemplate, '/')) {
            return http_response_code(403);
        }

        // Check is template exists
        $viewTemplateFullName = __DIR__ . "/../Views/$viewTemplate.php";
        if (!file_exists($viewTemplateFullName)) {
            return http_response_code(404);
        }

        // Prepare response ..
        ob_start();
        extract($params);
        require($viewTemplateFullName);
        ob_end_flush();

        // .. and return it
        return ob_get_contents();
    }
}
