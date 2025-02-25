<?php 
$data= findAllClients();
$currentPage = isset($_GET['view']) ? (int) $_GET['view'] : 2;
        $nbrElement = 3;
        $clientListe= lister_par_page($data,$currentPage,$nbrElement);
        $nbrPage= recup_nbrdepage( $data, 3);
?>
<main>
<div class="bg-white p-6 shadow-lg rounded-lg mt-2 h-auto">
        <h2 class="text-xl font-semibold mb-4">recherche par telephone</h2>
        <form action="" method="get">
            <label for="tel">telephone</label>
            <input type="text" name="tel" placeholder="Entrez le numero de telephone" class="py-2 w-96 px-2 border rounded-full" value="">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">OK</button>
        </form>
        <div class="flex justify-end item-center">
            <a href="" class="inline-block px-6 py-3 bg-blue-500 text-white font-medium text-sm leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out ">NOUVEAU</a>
        </div>
    </div>
    <!-- tableau -->
    <div class="container mx-auto mt-10 px-5">
        <!-- Liste des clients -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-10">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4 border-b pb-2">Liste des clients</h2>
            <table class="table-auto w-full border-collapse border border-gray-300 rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-blue-100 text-gray-700">
                        <th class="border px-4 py-3">Nom</th>
                        <th class="border px-4 py-3">Prenom</th>
                        <th class="border px-4 py-3">Téléphone</th>
                        <th class="border px-4 py-3">Action</th>
                    </tr>
                </thead>
                <?php if (!empty($clientListe)) : ?>
    <tbody>
        <?php foreach ($clientListe as $client): ?>
            <?php if (isset($client['nom'], $client['prenom'], $client['telephone'])): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($client['nom']) ?></td>
                    <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($client['prenom']) ?></td>
                    <td class="px-4 py-2 border border-gray-300"><?= htmlspecialchars($client['telephone']) ?></td>
                    <td class="px-4 py-2 border border-gray-300">
                        <a href="<?= WEBROOT ?>?controller=commandes&page=commandes&client_id=<?= $client['id'] ?>" class="px-3 py-1 text-white bg-blue-500 rounded hover:bg-red-600 inline-block">Commande</a>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </tbody>
<?php else: ?>
    <tr>
        <td colspan="4" class="text-center py-4 text-gray-500">Aucun client trouvé pour ce numéro de téléphone !</td>
    </tr>
<?php endif; ?>

                    </table>
                    <div class="flex justify-center text-gray-800 mt-4">
                    <div class="flex items-center gap-1">
                        <?php if ($currentPage > 0): ?>
                            <a href="?page=liste&view=<?= $currentPage - 1 ?>" class="px-3 py-2 self-center rounded  border border-gray-300  hover:bg-gray-100">Précédent</a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $nbrPage; $i++): ?>
                            <a href="?page=liste&view=<?= $i ?>" class="h-10 w-10 rounded-full flex items-center justify-center border border-gray-300  hover:bg-purple-600 hover:text-white <?= $i == $currentPage ? 'bg-purple-500 text-white' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($currentPage < $nbrPage): ?>
                            <a href="?page=liste&view=<?= $currentPage + 1 ?>" class="px-3 py-2 rounded self-center border border-gray-300 hover:bg-gray-100">Suivant</a>
                        <?php endif; ?>
                    </div>
            </div>
               
        </div>
    </div>
</body>
</html>
</main>
 