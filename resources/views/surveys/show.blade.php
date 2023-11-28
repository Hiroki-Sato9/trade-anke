
<x-app-layout>
    <div></div>
    <div class="survey">
        <h2 class="text-3xl">アンケートの対象人物</h2>
            <ul>
                <li>性別：{{ $gender->name }}</li>
                <li>年齢：{{ $survey->min_age }} ~ {{ $survey->max_age }}</li>
            </ul>
        <h2 class="text-3xl">アンケートの内容</h2>
        <ul class="space-y-1">
        @foreach ($survey->questions as $question)
            <li>
                {{ $question->body }}
            </li>
        @endforeach
        </ul>
    </div>
    
     <div class="statistics mb-4">
        <ul>
            <li>回答人数：{{ $survey->answer_num }}</li>
        </ul>
        
        @if($answers_by_user)
        <h3>回答一覧</h3>
        <table>
            <tr>
                @foreach ($survey->questions as $question)
                    <th>{{ $question->body }}</th>
                @endforeach
            </tr>
                @foreach($answers_by_user as $answers)
                <tr>
                    @foreach($answers as $answer)
                        <td>{{ $answer->body }}</td>
                    @endforeach
                </tr>
                @endforeach
        </table>
        @endif
    </div>
</x-app-layout>