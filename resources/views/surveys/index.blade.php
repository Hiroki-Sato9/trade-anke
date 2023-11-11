
<x-app-layout>
    <h1 class="mb4">作成されたアンケート</h1>
    <div class="contents">
        <ul>
            @foreach ($surveys as $survey)
                <li>
                    <strong>{{ $survey['description'] }}</strong>
                </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>