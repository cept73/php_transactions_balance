<?php

namespace App\Repositories;

use App\Core\App;

class TransactionsRepository
{
    public function getStatistics(int $userId): array
    {
        // Complex SQL to get overall statistics
        $pdoStatement = App::db()->query(<<<SQL

WITH user_accounts_r AS (
    SELECT id FROM user_accounts WHERE user_id = $userId
),
monthly_stats AS (
    SELECT
        strftime('%Y-%m', trdate) AS month,
        SUM(CASE
                WHEN t.account_to IN (SELECT id FROM user_accounts_r)
                THEN amount
                ELSE 0
            END)
        -
        SUM(CASE
                WHEN t.account_from IN (SELECT id FROM user_accounts_r)
                AND t.account_to NOT IN (SELECT id FROM user_accounts_r)
                THEN amount
                ELSE 0
            END) AS monthly_balance,
        COUNT(t.id) AS transaction_count
    FROM transactions t
    WHERE t.account_from IN (SELECT id FROM user_accounts_r)
       OR t.account_to IN (SELECT id FROM user_accounts_r)
    GROUP BY month
)
SELECT * FROM monthly_stats ORDER BY month DESC;
SQL
        );

        if ($pdoStatement === false) {
            return [];
        }

        $result = [];
        while ($info = $pdoStatement->fetch(\PDO::FETCH_ASSOC)) {
            $result[] = [
                'month' => $info['month'],
                'monthly_balance' => $info['monthly_balance'],
                'transaction_count' => $info['transaction_count'],
            ];
        }

        return $result;
    }
}
