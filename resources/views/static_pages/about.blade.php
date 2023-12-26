
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-5xl">タイトル</h1>
            <p>概要文</p>
            <button class="bg-blue-500 hover:bg-blue-400 text-white rounded px-4 py-2">ユーザー登録</button>
            <h2 class="text-4xl">Trade-Ankeで できること</h2>
            <ul class="list-none">
                <li>
                    <div class="content">
                        <h3></h3>
                        <p></p>
                    </div>
                </li>
            </ul>
        </div>
        </div>
    </body>
</html>