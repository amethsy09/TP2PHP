<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-3xl bg-white p-8 rounded-lg shadow-lg max-w-sm mt-24 mx-auto  ">
        <header class="border-b pb-4 mb-4">
            <h1 class="text-3xl font-bold text-gray-800">Bienvenue</h1>
               <?=  "Bienvenue sur le dashboard, " .$_SESSION['user']['prenom'] . " " . $_SESSION['user']['nom'] . "!";?>
            <p class="text-gray-600">Vous êtes connecté avec succès.</p>
        </header>

        <main>
            <div class="grid grid-cols-2 gap-4">
                <a href="<?= WEBROOT ?>?controller=clients&page=liste" class="block text-center bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition">Voir la liste</a>
                <a href="<?= WEBROOT ?>?controller=security&page=logout" class="block text-center bg-red-500 text-white py-3 rounded-lg hover:bg-red-600 transition">Déconnexion</a>
            </div>
        </main>
    </div>
</body>
</html>

