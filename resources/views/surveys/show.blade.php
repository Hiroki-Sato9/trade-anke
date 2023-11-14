
<x-app-layout>
    <div></div>
    <div class="statistics mb-4">
        <ul>
            <li>回答人数：{{ $survey->answer_num }}</li>
        </ul>
    </div>
    <div class="survey">
        <h2>アンケートの対象人物</h2>
            <ul>
                <li>性別：{{ $gender->name }}</li>
                <li>年齢：{{ $survey->min_age }} ~ {{ $survey->max_age }}</li>
            </ul>
        <h2>アンケートの内容</h2>
        <ul class="space-y-1">
        @foreach ($survey->questions as $question)
            <li>
                {{ $question->body }}
            </li>
        @endforeach
        </ul>
    </div>
</x-app-layout>