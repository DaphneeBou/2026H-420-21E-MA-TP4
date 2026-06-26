<?php
require_once __DIR__ . '/../app/db.php';

// Charger les villes pour le select
$villes = $pdo->query("SELECT * FROM city ORDER BY city")->fetchAll(PDO::FETCH_ASSOC);

$erreurs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']     ?? '');
    $address  = trim($_POST['address']  ?? '');
    $phone    = trim($_POST['phone']    ?? '');
    $email    = trim($_POST['email']    ?? '');
    $birthday = trim($_POST['birthday'] ?? '');
    $city_id  = intval($_POST['city_id'] ?? 0);

    if ($name === '') {
        $erreurs[] = 'Le nom est obligatoire.';
    }
    if ($city_id === 0) {
        $erreurs[] = 'La ville est obligatoire.';
    }

    if (empty($erreurs)) {
        $stmt = $pdo->prepare("
            INSERT INTO client (name, address, phone, email, birthday, city_id)
            VALUES (:name, :address, :phone, :email, :birthday, :city_id)
        ");
        $stmt->execute([
            'name'     => $name,
            'address'  => $address ?: null,
            'phone'    => $phone   ?: null,
            'email'    => $email   ?: null,
            'birthday' => $birthday ?: null,
            'city_id'  => $city_id,
        ]);

        header('Location: index.php?success=ajout');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un client</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter un client</h1>

        <?php if (!empty($erreurs)): ?>
            <div class="alert alert-danger">
                <?php foreach ($erreurs as $e): ?>
                    <p><?= htmlspecialchars($e) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="form-card">
            <form method="POST">
                <div class="form-group">
                    <label for="name">Nom *</label>
                    <input type="text" id="name" name="name"
                           value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">Adresse</label>
                    <input type="text" id="address" name="address"
                           value="<?= htmlspecialchars($_POST['address'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="phone">Téléphone</label>
                    <input type="text" id="phone" name="phone"
                           value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="email">Courriel</label>
                    <input type="email" id="email" name="email"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="birthday">Date de naissance</label>
                    <input type="date" id="birthday" name="birthday"
                           value="<?= htmlspecialchars($_POST['birthday'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="city_id">Ville *</label>
                    <select id="city_id" name="city_id" required>
                        <option value="">— Choisir une ville —</option>
                        <?php foreach ($villes as $ville): ?>
                            <option value="<?= $ville['id'] ?>"
                                <?= (isset($_POST['city_id']) && $_POST['city_id'] == $ville['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($ville['city']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                    <a href="index.php" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
