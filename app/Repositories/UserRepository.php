<?php

namespace App\Repositories;

use App\Core\App;

class UserRepository
{
    public function getAll(): array
    {
        // Get all users list
        $pdoStatement = App::db()->query('SELECT id, name FROM users');
        if ($pdoStatement === false) {
            return [];
        }

        // And map to id => name
        $result = [];
        while ($user = $pdoStatement->fetch(\PDO::FETCH_ASSOC)) {
            $result[$user['id']] = $user['name'];
        }

        return $result;
    }
}
