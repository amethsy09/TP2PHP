<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Section Commande -->
        <!-- recherche client via telephone -->
        <div class="bg-white p-6 rounded-lg shadow-lg space-y-6">
            <h2 class="text-xl font-bold text-gray-800">Informations Client</h2>
            <form action="" method="get" class="space-y-4">
                <input type="hidden" name="controller" value="commandes">
                <input type="hidden" name="page" value="ajout">
                <div class="flex space-x-4 items-center">
                    <label for="tel" class="block text-sm text-gray-700">Téléphone</label>
                    <input type="text" name="tel" placeholder="Entrez le numéro de téléphone" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= isset($_GET['tel']) ? htmlspecialchars($_GET['tel']) : '' ?>"">
                    <button type=" submit" class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition duration-300">OK</button>
                </div>

            </form>
            <!-- infos du client -->
            <div class="flex space-x-4">
                <div class="flex-1">
                    <label for="nom" class="block text-sm text-gray-700">Nom</label>
                    <input type="text" id="nom" readonly name="nom" placeholder="Entrez le nom" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= $_SESSION['client']["nom"] ?? ""  ?>">
                </div>
                <div class="flex-1">
                    <label for="prenom" class="block text-sm text-gray-700">Prénom</label>
                    <input type="text" id="prenom" readonly name="prenom" placeholder="Entrez le prénom" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= $_SESSION['client']["prenom"] ?? "" ?>">
                </div>
            </div>
            <!-- rechercher article -->
            <form action="" method="get" class="space-y-4">
                <input type="hidden" name="controller" value="commandes">
                <input type="hidden" name="page" value="ajout">
                <div class="flex space-x-4 items-center">
                    <label for="article" class="block text-sm text-gray-700">Nom </label>
                    <input type="text" name="article" placeholder="Entrez le nom de l'article" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="<?= isset($_GET['article']) ? htmlspecialchars($_GET['article']) : '' ?>">
                    <button type="submit" name="rechercher_article" class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition duration-300">Rechercher</button>
                </div>
            </form>
            <h2 class="text-xl font-bold text-gray-800">Ajouter un Article</h2>

            <form action="" method="POST" class="flex space-x-4 mb-6">
                <input type="hidden" name="id" value="<?= $_SESSION['articleModifier']['id'] ?? '' ?>">
                <input type="text" name="article" placeholder="Nom de l'article" class="w-1/3 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="<?= $_SESSION['articleModifier']['nom'] ?? '' ?>" readonly>
                <input type="number" name="prix" placeholder="Prix" class="w-1/4 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="<?= $_SESSION['articleModifier']['prix'] ?? '' ?>" readonly>
                <input type="number" name="quantite" placeholder="Quantité" class="w-1/4 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="<?= $_SESSION['articleModifier']['quantite_stock'] ?? '' ?>" readonly>

                <?php $isArticleFound = isset($_SESSION['articleModifier']); ?>
                <button type="submit" name="<?= $isArticleFound ? 'modifier_article' : 'ajouter' ?>"
                    class="<?= $isArticleFound ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-blue-600 hover:bg-blue-700' ?> text-white px-6 py-3 rounded-full transition duration-300">
                    <?= $isArticleFound ? 'Modifier' : 'Ajouter' ?>
                </button>
            </form>

            <form method="post">
                <div class="flex items-center space-x-4">
                    <div class="w-1/4 mb-4">
                        <label for="quantite" class="block text-sm font-medium text-gray-700">Quantité</label>
                        <input type="number" id="quantite" name="quantite" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <input type="hidden" name="controller" value="commande">
                    <input type="hidden" name="page" value="ajout">

                    <div class="w-1/6 mt-6">
                        <button type="submit" name="ajoutProduit" class="w-full px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            Ajouter produit
                        </button>
                    </div>
                </div>
            </form>
            <!-- Tableau des Articles -->
            <table class="w-full table-auto border-collapse border border-gray-300 shadow-md">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-3">Article</th>
                        <th class="border p-3">Prix</th>
                        <th class="border p-3">Quantité</th>
                        <th class="border p-3">Montant</th>
                        <th class="border p-3">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($_SESSION['articles'] as $k => $art) : ?>
                        <tr>
                            <td class="border p-3"><?= htmlspecialchars($art['article']); ?></td>
                            <td class="border p-3"><?= number_format((float)$art['prix'], 0, ',', ' ') . ' FCFA'; ?></td>
                            <td class="border p-3"><?= htmlspecialchars($art['quantite_stock']); ?></td>
                            <td class="border p-3">
                                <?php
                                $montant = (float)$art['prix'] * (int)$art['quantite_stock'];
                                echo number_format($montant, 0, ',', ' ') . ' FCFA';
                                ?>
                            </td>
                            <td class="border p-3">
                                <a href="<?= WEBROOT ?>?controller=commandes&page=ajout&supprimer=<?php echo $k; ?>" class="text-red-600 hover:text-red-800">🗑</a>
                                <a href="<?= WEBROOT ?>?controller=commandes&page=ajout&modifier=<?php echo $art['id']; ?>" class="text-red-600 hover:text-red-800">⚙</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>
            <!-- Total & Commander -->
            <form action="" method="POST">
                <input type="hidden" name="tel" value="<?= isset($_GET['tel']) ? htmlspecialchars($_GET['tel']) : '' ?>">
                <div class="mt-6 flex justify-between items-center">
                    <span class="text-2xl font-bold text-gray-800">Total :<?php echo $total; ?> FCFA</span>
                    <button type="submit" name="commander" class="bg-green-600 text-white px-6 py-3 rounded-full hover:bg-green-700 transition duration-300">Commander</button>
                </div>
            </form>
        </div>
        <?php if (isset($_GET['success'])): ?>
            <p style="color: green;">Commande enregistrée avec succès !</p>
        <?php endif; ?>
    </div>
</body>

</html>