<?php 
// require_once "../layout/header.html.php";
?>
<main>
<div class="container mx-auto mt-10 px-5">
        <div class="bg-white shadow-lg rounded-lg p-6 mb-10">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Liste des commandes</h2>
            <table class="table-auto w-full border-collapse border border-gray-300 rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-blue-100 text-gray-700">
                        <th class="border px-4 py-3">Date</th>
                        <th class="border px-4 py-3">Montant</th>
                        <th class="border px-4 py-3">Statut</th>
                        <th class="border px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($commandes)) : ?>
                        <?php foreach ($commandes as $commande): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($commande['date']) ?></td>
                                <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($commande['montant']) ?> FCFA</td>
                                <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($commande['statut']) ?></td>
                                <td class="px-4 py-2 border border-gray-300">
                <a href="<?= WEBROOT ?>?page=detail&client_id=<?= $client['id'] ?>" class="px-3 py-1 text-white bg-blue-500 rounded hover:bg-red-600 inline-block">detail</a>
            </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="3" class="text-center text-red-500 py-3">Aucune commande trouvée pour ce client.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

</main>
    