
<x-app-layout>
    @if ($auth_url)
    <a href="{{ $auth_url }}">Connect Me</a>
    @endif
</x-app-layout>