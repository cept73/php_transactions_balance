<?php

namespace App\Repositories;

use App\Core\App;

class UserRepository
{
    public function getAllActive(): array
    {
        // Get all users list
        $pdoStatement = App::db()->query(<<<SQL
SELECT u.id, u.name FROM users u
INNER JOIN user_accounts ua ON ua.user_id = u.id
INNER JOIN transactions t ON t.account_from = ua.id OR t.account_to = ua.id;
SQL
        );
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
