
<x-app-layout>
    <h1 class="text-5xl">作成されたアンケート</h1>
    <div class="contents">
        <ul>
            @foreach ($surveys as $survey)
                <li>
                    <div class="mb-4">
                        <a href="/surveys/{{ $survey->id }}" class="text-xl">{{ $survey['title'] }}</a>
                        <p class="description ml-2">{{ $survey['description']}}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>