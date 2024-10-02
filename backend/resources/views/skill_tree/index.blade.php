<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trenuj z najlepszymi!</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div id="app" class="flex bg-slate-200 min-h-screen">
        <dashboard-component></dashboard-component>

        <div class="flex-grow flex justify-center items-center">
                <skill-tree-component></skill-tree-component>
        </div>
    </div>
    @vite('resources/js/app.js')
</body>
</html>
