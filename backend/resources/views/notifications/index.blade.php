<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trenuj z najlepszymi!</title>
    @vite('resources/css/app.css')
</head>
<body>
<div id="app" class="flex bg-slate-300 min-h-screen">
    <dashboard-component></dashboard-component>

    <div class="flex-grow flex justify-center items-center">
        <notifications-component></notifications-component>
    </div>
</div>
@vite('resources/js/app.js')
</body>
</html>
