
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
            @foreach($answers_by_user as $user_id => $answers)
            <tr>
                @foreach($answers as $answer)
                    <td>{{ $answer->body }}</td>
                @endforeach
                <td>
                    <form method="post" action="/interviews/request/{{ $survey->id }}">
                        @csrf
                        <input type="hidden" id="request_user" name="request_user" value="{{ $survey->user->id }}" />
                        <input type="hidden" id="requested_user" name="requested_user" value="{{ $answers->first()->user->id }}" />
                        <input type="submit" value="リクエスト" />
                    </form>
                </td>
                
                <!-- インタビュー結果を表示するボタン -->
                @if ($survey->is_interviewed_user($user_id))
                <td>
                    <form method="get" action="#" id="interview_{{ $user_id }}" class="show_form">
                        @csrf
                        <input type="hidden" id="" name="survey_id" value="{{ $survey->id }}"/>
                        <button type="button" id="btn_{{ $user_id }}" class="show_btn">インタビュー結果を見る</button>
                    </form>
                </td>
                @endif
            </tr>
            @endforeach
        </table>
        @endif
    </div>
    <div id="dialog"></div>
</x-app-layout>

<script src="{{ asset('/js/surveys/show.js') }}"></script>