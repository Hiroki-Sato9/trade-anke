
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
        <header class="flex flex-row justify-between bg-blue-100 text-xl py-9">
            <h1>Trade Anke</h1>
            <nav>
                <ul class="flex felx-row">
                    @auth
                    <li class="ml-9"><a href="#">ログアウト</a></li>
                    @endauth
                    @guest
                    <li class="ml-9"><a href="#">ログイン</a></li>
                    @endguest
                    <li class="ml-9"><a href="#">アンケートを探す</a></li>
                    <li class="ml-9"><a href="#"></a></li>
                </ul>
            </nav>
        </header>
        <div class="py-36 bg-gray-100">
        <div class="max-w-7xl mx-auto flex flex-col flex-wrap content-center">
            <h1 class="text-5xl mb-3">Trade-Ankeで、気軽にアンケート調査を実施しよう</h1>
            <p class="text-lg mb-20">このサービスでは、自分が作成したアンケートを配布することができます。</p>
            
            <div class="flex justify-around">
                <div class="flex items-center justify-center flex-col basis-2/5 bg-white shadow-sm p-2">
                    <span>ユーザー登録をしてアンケート調査をはじめましょう</span>
                    <button onclick="location.href='{{ route('register') }}'" class="w-2/5 bg-blue-500 hover:bg-blue-400 text-white rounded px-4 py-2 mb-20">ユーザー登録</button>
                </div>
                <div class="flex items-center justify-center flex-col basis-2/5 bg-white shadow-sm p-2">
                    <span>作成されたアンケートを見る</span>
                    <button onclick="location.href='{{ route('surveys.index') }}'" class="w-2/5 bg-blue-500 hover:bg-blue-400 text-white rounded px-4 py-2 mb-20">アンケート一覧へ</button>
                </div>
            </div>
            <div class="items-center pb-6">
                <span>すでにアカウントを持っている場合</span>
                <a href=" {{ route('login') }}" class="text-blue-900">ログイン</a>
            </div>
            
            <h2 class="text-4xl border-t py-4 mb-4">どんなサービス？</h2>
            <ul class="list-none">
                <li class="bg-white shadow-sm p-6 mb-6 h-80 pt-10">
                    <div class="content">
                        <h3 class="text-3xl mb-3">アンケートを簡単に作成・配布できるサービスです</h3>
                        <p class="text-lg">
                            サイト内のフォームにて簡単に質問フォームを作成できます。
                        </p>
                    </div>
                </li>
                <li class="bg-white shadow-sm p-6 mb-6 h-80 pt-10">
                    <div class="content">
                        <h3 class="text-3xl mb-3">アンケート調査を行うときのハードル</h3>
                        <p class="text-xl">
                            アンケート調査を行うときの最大のハードルとは、「自分が調査のターゲットにしたい人を一定数集めること」です。<br>
                            学生のように周りに同年代の人たちしかいなかったり、時間やお金をかけられない場合、<br>アンケート調査を行うことはとても
                            ハードルが高いものとなります。
                        </p>
                    </div>
                </li>
                <li class="bg-white shadow-sm p-6 mb-6 h-80 pt-10">
                    <div class="content">
                        <h3 class="text-3xl mb-3">アンケートを作りたい人同士が答え合う仕組み</h3>
                        <p class="text-xl">
                            この課題を解決するためにこのサービスは作られました。<br>
                            このサービスでは、自分が作ったアンケートを配るときに「ポイント」を必要とします。<br>
                            このポイントは、配られた誰かのアンケートに答えたり、インタビューを受けたときにのみ獲得することができます。<br>
                            こうすることで、アンケート調査をしたい人たちがお互いにアンケートを答える仕組みができあがりました。
                            
                        </p>
                    </div>
                </li>
                <li class="bg-white shadow-sm p-6 mb-6  h-80 pt-10">
                    <div class="content">
                        <h3 class="text-3xl mb-3">気になった回答者にインタビューができる！</h3>
                        <p class="text-lg">
                            インタビュー調査もまたハードルが高い調査法のひとつです。<br>
                            しかしこのTrade-Ankeでは、自分が出したアンケートの結果を見て、面白いと思った人にインタビューの申し込みができます。<br>
                            顔を合わせず、インタビューができることも、このwebサービスの特徴です。
                        </p>
                    </div>
                </li>
            </ul>
        </div>
        </div>
    </body>
</html>