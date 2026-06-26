<?php
require_once __DIR__ . '/../app/db.php';

$stmt = $pdo->query("
    SELECT client.id, client.name, client.address, client.phone,
           client.email, client.birthday, city.city AS city_name
    FROM client
    LEFT JOIN city ON client.city_id = city.id
    ORDER BY client.id DESC
");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des clients</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Gestion des clients</h1>
        <a href="ajouter.php" class="btn btn-primary">+ Nouveau client</a>
    </header>

    <div class="container">

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <?php
                $msg = [
                    'ajout'      => 'Client ajouté avec succès.',
                    'modif'      => 'Client modifié avec succès.',
                    'suppression'=> 'Client supprimé avec succès.',
                ];
                echo htmlspecialchars($msg[$_GET['success']] ?? '');
                ?>
            </div>
        <?php endif; ?>

        <h2>Liste des clients</h2>

        <?php if (count($clients) === 0): ?>
            <p>Aucun client pour le moment.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Ville</th>
                        <th>Téléphone</th>
                        <th>Courriel</th>
                        <th>Date de naissance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><?= htmlspecialchars($client['id']) ?></td>
                            <td><?= htmlspecialchars($client['name']) ?></td>
                            <td><?= htmlspecialchars($client['city_name'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($client['phone'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($client['email'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($client['birthday'] ?? '—') ?></td>
                            <td>
                                <div class="actions">
                                    <a href="modifier.php?id=<?= $client['id'] ?>" class="btn btn-warning">Modifier</a>
                                    <a href="supprimer.php?id=<?= $client['id'] ?>"
                                       class="btn btn-danger"
                                       onclick="return confirm('Supprimer ce client ?')">Supprimer</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
