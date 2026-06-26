<?php
require_once __DIR__ . '/../app/db.php';

$id = intval($_GET['id'] ?? 0);

if ($id === 0) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("DELETE FROM client WHERE id = :id");
$stmt->execute(['id' => $id]);

header('Location: index.php?success=suppression');
exit;
