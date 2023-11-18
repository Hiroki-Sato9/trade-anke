
<x-app-layout>
    <h2>あなたが作成したアンケート</h2>
    <ul>
        @foreach($created_surveys as $survey)
        <li>
            <a href="/surveys/{{ $survey->id }}">{{ $survey->title }}</a>
        </li>
        @endforeach
    </ul>
</x-app-layout>