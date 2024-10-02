<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout</title>
    @vite('resources/css/app.css')
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
<div id="app" class="bg-white p-8 rounded-lg shadow-lg text-center text-black w-full max-w-sm">
    <h1 class="text-2xl font-semibold mb-4">Zakup plan treningowy</h1>
    <form action="/checkout" method="POST" class="space-y-4">
        @csrf
        <input type="hidden" name="price" value="{{ $price }}">
        <p class="text-lg font-medium">Cena: {{ $price }} PLN</p>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">Przejdź do panelu płatności</button>
    </form>
</div>
@vite('resources/js/app.js')
</body>
</html>
