<nav class="flex flex-row justify-between text-xl py-9 bg-white border-b border-gray-100">
    <h1>Trade Anke</h1>
        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                {{ __('ログイン') }}
            </x-nav-link>
            <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                {{ __('ユーザ登録') }}
            </x-nav-link>
            <x-nav-link :href="route('surveys.index')" :active="request()->routeIs('surveys.index')">
                {{ __('アンケートを探す') }}
            </x-nav-link>
        </div>
</nav>