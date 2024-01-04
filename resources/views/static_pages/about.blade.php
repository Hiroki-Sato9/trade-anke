
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
        <div class="py-36 bg-gray-100">
        <div class="max-w-7xl mx-auto flex flex-col flex-wrap content-center">
            <h1 class="text-5xl mb-3">Trade-Ankeで、気軽にアンケート調査を実施しよう</h1>
            <p class="text-lg mb-12">このサービスでは、自分が作成したアンケートを配布することができます。</p>
            
            <div class="flex justify-around">
                <div class="flex items-center justify-center flex-col bg-white shadow-sm p-6">
                    <span>ユーザー登録をしてアンケート調査をはじめましょう</span>
                    <button onclick="location.href='{{ route('register') }}'" class="w-2/5 bg-blue-500 hover:bg-blue-400 text-white rounded px-4 py-2 mb-20">ユーザー登録</button>
                </div>
                <div class="flex items-center justify-center flex-col bg-white shadow-sm p-6">
                    <span>作成されたアンケートを見る</span>
                    <button onclick="location.href='{{ route('surveys.index') }}'" class="w-full bg-blue-500 hover:bg-blue-400 text-white rounded px-4 py-2 mb-20">アンケート一覧へ</button>
                </div>
            </div>
            <div class="items-center pb-6">
                <span>すでにアカウントを持っている場合</span>
                <a href=" {{ route('login') }}" class="text-blue-900">ログイン</a>
            </div>
            
            <h2 class="text-4xl border-t py-4 mb-4">Trade-Ankeで できること</h2>
            <ul class="list-none">
                <li class="bg-white shadow-sm p-6 mb-6 h-80 pt-10">
                    <div class="content">
                        <h3 class="text-3xl mb-3">アンケートを簡単に作成できる！</h3>
                        <p class="text-lg">
                            サイト内のフォームにて簡単に質問フォームを作成できます。
                        </p>
                    </div>
                </li>
                <li class="bg-white shadow-sm p-6 mb-6 h-80 pt-10">
                    <div class="content">
                        <h3 class="text-3xl mb-3">アンケートを答えるたびにポイントをゲット！</h3>
                        <p class="text-lg">
                            ゲットしたポイントは、アンケートの配布やインタビュー調査をするときに必要になります。<br>
                            
                        </p>
                    </div>
                </li>
                <li class="bg-white shadow-sm p-6 mb-6 h-80 pt-10">
                    <div class="content">
                        <h3 class="text-3xl mb-3">性別・年代を指定してアンケートを配布！</h3>
                        <p class="text-lg">アンケートを届けたい人たちに、実際にアンケートを届けることができます。</p>
                    </div>
                </li>
                <li class="bg-white shadow-sm p-6 mb-6  h-80 pt-10">
                    <div class="content">
                        <h3 class="text-3xl mb-3">気になった回答者にインタビューができる！</h3>
                        <p class="text-lg">届いたアンケート回答のうち、気になった回答者にインタビューを申し込むことができます。</p>
                    </div>
                </li>
            </ul>
        </div>
        </div>
    </body>
</html>