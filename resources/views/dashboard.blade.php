<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
            <div class="bg-white shadow-sm p-6 my-4">
                <h1 class="text-5xl py-5 mb-3">ようこそ</h1>
                <p class="text-lg mb-12">このサービスの使い方を説明します</p>
            </div>
            <ul class="list-none">
                <li class="mb-6 bg-white shadow-sm p-6">
                    <h2 class="text-4xl border-b py-4 mb-4">手順１：配られたアンケートに答えてみよう</h2>
                    <p><a href="{{ route('profile.detail') }}#delivered_surveys" class="text-blue-700">ここ</a>で、あなたのプロフィールと合致したアンケートが配られます。</p>
                </li>
                <li class="mb-6 bg-white shadow-sm p-6">
                    <h2 class="text-4xl border-b py-4 mb-4">手順２：アンケートを作ってみよう</h2>
                    <p><a href="{{ route('surveys.create') }}" class="text-blue-700">ここ</a>で、アンケートを作成することができます。</p>
                </li>
                <li class="mb-6 bg-white shadow-sm p-6">
                    <h2 class="text-4xl border-b py-4 mb-4">手順３：アンケートを配ってみよう</h2>
                    <p>作成したアンケートは、自分が持っているポイントと引き換えに誰かに届けることができます。</p>
                </li>
            </ul>
        </div>
    </div>
</x-app-layout>
