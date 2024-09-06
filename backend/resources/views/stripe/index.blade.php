<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout</title>
    @vite('resources/css/app.css')
</head>
<body>
<div id="app">
    <h1>Zakup plan treningowy</h1>
    <form action="/checkout" method="POST">
        @csrf
        <input type="hidden" name="price" value="{{ $price }}">
        <button type="submit">Zaplac</button>
    </form>
    Cena: {{ $price }} PLN
</div>
@vite('resources/js/app.js')
</body>
</html>
