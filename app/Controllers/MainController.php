<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Controller;
use App\Core\JsonResponse;
use App\Core\ViewResponse;
use App\Repositories\UserRepository;
use App\Repositories\TransactionsRepository;

class MainController extends Controller
{
    /**
     * Main page
     *
     * @return ViewResponse
     */
    public function index(): ViewResponse
    {
        $users = (new UserRepository())->getAll();

        // Return HTML
        return new ViewResponse('main', [
            'users' => $users
        ]);
    }

    /**
     * Get statistics by months
     *
     * @param array $request
     * @return JsonResponse
     * @noinspection PhpUnused
     */
    public function getStatistics(array $request): JsonResponse
    {
        $user_id = $request['user'] ?? null;

        if ($user_id !== null) {
            // Get username
            $statement = App::db()->prepare('SELECT name FROM users WHERE id=:id');
            $statement->execute(['id' => $user_id]);
            $userName = $statement->fetchColumn();
            $title = "Transactions of $userName";

            // Get transactions balances
            $statistics = (new TransactionsRepository())->getStatistics($user_id);
        } else {
            $title = 'User is not specified';
            $statistics = [];
        }

        // Return as JSON
        return new JsonResponse([
            'statistics' => $statistics,
            'title' => $title,
        ]);
    }
}
