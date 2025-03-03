<?php 
require_once "../views/layout/base.layout.html.php";
?>
<main>
<div class="flex justify-end item-center">
            <a href="<?= WEBROOT?>?controller=commandes&page=ajout" class="inline-block px-6 py-3 bg-blue-500 text-white font-medium text-sm leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ">NOUVEAU</a>
        </div>
    <div class="container mx-auto mt-10 px-5">
        <div class="bg-white shadow-lg rounded-lg p-6 mb-10">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Liste des commandes</h2>
            <table class="table-auto w-full border-collapse border border-gray-300 rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-blue-100 text-gray-700">
                        <th class="border px-4 py-3">Date</th>
                        <th class="border px-4 py-3">numero_commande</th>
                        <th class="border px-4 py-3">Statut</th>
                        <th class="border px-4 py-3">Montant</th>
                        <th class="border px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($Allcommandes)) : ?>
                            <?php foreach ($Allcommandes as  $commande): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($commande['date']) ?></td>
                                <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($commande['numero_commande']) ?></td>
                                <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($commande['statut']) ?></td>
                                <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($commande['montant']) ?> FCFA</td>
                                <td class="px-4 py-2 border border-gray-300">
                                <a href="<?= WEBROOT ?>?page=detail&client_id=<?= htmlspecialchars($Allcommande['id_client']) ?>" class="px-3 py-1 text-white bg-blue-500 rounded hover:bg-red-600 inline-block">Détail</a>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="3" class="text-center text-red-500 py-3">Aucune commande trouvée .</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

</main>
 