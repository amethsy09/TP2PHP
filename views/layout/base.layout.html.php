<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-gray-100 text-gray-800">
    <!-- header -->
    <div class="text-center mb-10">
        <h1 class="font-bold text-blue-600 text-4xl">Gestion des clients </h1>
    </div>
    <nav class="bg-white shadow-md p-4 flex justify-between">
        <h2 class="text-xl font-semibold text-blue-600">Menu</h2>
        <a href="<?= WEBROOT ?>controller=commandes&page=Allcommandes" class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-red-600">
            Commandes
        </a>
    </nav>

    <main>
    <?=$content?>;
</main>


</body>

</html>