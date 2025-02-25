<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-gray-800">Bienvenue, <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></h1>
        <p class="text-gray-600 mt-2">Vous êtes connecté avec succès.</p>

        <div class="mt-4 flex space-x-4">
            <a href="?page=liste" class="text-blue-600 hover:underline">Voir la liste</a>
            <a href="logout.php" class="text-red-600 hover:underline">Déconnexion</a>
        </div>
    </div>
</body>
</html>
