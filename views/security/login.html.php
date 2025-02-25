<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm mt-24 mx-auto ">
        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Se connecter</h2>
        <form id="form" method="POST" action="">
        <input type="hidden" name="controller" value="security">
        <input type="hidden" name="page" value="login">
            <div class="mb-4">
                <label for="email" class="block text-gray-600 text-sm font-medium">Email</label>
                <input id="email" type="email" name="email" placeholder="Entrez votre email" class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p id="email-error" class="text-red-500 text-sm mt-2 hidden text-center"></p>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-600 text-sm font-medium">Mot de passe</label>
                <input id="password" type="password" name="password" placeholder="Entrez votre mot de passe" class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p id="password-error" class="text-red-500 text-sm mt-2 hidden text-center"></p>
            </div>
            <div class="flex justify-between items-center mb-4">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" class="mr-2"> Se souvenir de moi
                </label>
                <a href="#" class="text-sm text-blue-500 hover:underline">Mot de passe oublié ?</a>
            </div>
            <button id="btn-login" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">Se connecter</button>
        </form>
        <p class="text-center text-sm text-gray-600 mt-4">Pas encore de compte ? <a href="#" class="text-blue-500 hover:underline">S'inscrire</a></p>
        <p id="login-error" class="text-red-500 text-sm mt-2 hidden text-center"></p>
    </div>  
</body>
</html>