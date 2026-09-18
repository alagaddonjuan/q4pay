<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=q4pay_db', 'root', '');
$stmt = $pdo->query('SELECT * FROM merchant_team_members');
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
