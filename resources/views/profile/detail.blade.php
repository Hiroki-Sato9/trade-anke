
<x-app-layout>
    <h2>あなたが作成したアンケート</h2>
    <ul>
        @foreach($created_surveys as $survey)
        <li class="flex">
            <a href="/surveys/{{ $survey->id }}">{{ $survey->title }}</a>
            <form method="post" action="/deliver">
                @csrf
                <input type="hidden" name="survey" value="{{ $survey->id }}">
                <input type="number" name="num">
                <input type="submit" value="配布">
            </form>
        </li>
        @endforeach
    </ul>
    
    <h2>あなたが回答したアンケート</h2>
    <ul>
        @foreach($answered_surveys as $survey)
        <li>
            <a href="/surveys/{{ $survey->id }}">{{ $survey->title }}</a>
        </li>
        @endforeach
    </ul>
</x-app-layout>