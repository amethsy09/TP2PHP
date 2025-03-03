<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste details Commandes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-gray-100 text-gray-800">
    <div class="text-center mb-10">
        <h1 class="font-bold text-blue-600 text-4xl">Commandes de <?= htmlspecialchars($client['prenom'] . " " . $client['nom']) ?></h1>

    </div>
<main>
<div class="container mx-auto mt-10 px-5">
        <div class="bg-white shadow-lg rounded-lg p-6 mb-10">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Liste details commandes</h2>
            <table class="table-auto w-full border-collapse border border-gray-300 rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-blue-100 text-gray-700">
                        <th class="border px-4 py-3">ID</th>
                        <th class="border px-4 py-3">nom</th>
                        <th class="border px-4 py-3">prix</th>
                        <th class="border px-4 py-3">quantite_stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($articles)) : ?>
                        <?php foreach ($articles as $produit): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($produit['id']) ?></td>
                                <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($produit['nom']) ?></td>
                                <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($produit['prix']) ?> FCFA</td>
                                <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($produit['quantite_stock']) ?></td>
                              
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="3" class="text-center text-red-500 py-3">Aucun details trouvé pour cette commande.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

</main>
   