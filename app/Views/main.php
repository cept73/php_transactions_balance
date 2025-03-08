<?php
/**
 * @var $users array
 */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User transactions information</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>User transactions information</h1>
<form action="/" method="get">
    <label for="user">Select user:</label>
    <select name="user" id="user">
        <?php foreach ($users as $id => $name) : ?>
            <option value="<?= $id ?>"><?= $name ?></option>
        <?php endforeach; ?>
    </select>
    <input id="submit" type="submit" value="Show">
</form>

<div id="data">
    <h2>Transactions of `User name`</h2>
    <table>
        <tr><th>Month</th><th>Amount</th><th>Count</th></tr>
        <tr><td>...</td><td>...</td><td>...</td>
    </table>
</div>

<script src="script.js"></script>
</body>
</html>
