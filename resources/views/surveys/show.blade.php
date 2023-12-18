
<x-app-layout>
    <div class="py-12">
    <div class="survey max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mb-4">
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
    
     <div class="statistics max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mb-4">
        <ul>
            <li>回答人数：{{ $survey->answer_num }}</li>
        </ul>
        
        @if($answers_by_user)
        <h3>回答一覧</h3>
        <table class="table-auto border-spacing-3">
            <thead>
            <tr>
                @foreach ($survey->questions as $question)
                    <th>{{ $question->body }}</th>
                @endforeach
                <th>リクエスト</th>
                <th>インタビュー</th>
            </tr>
            </thead>
            <tbody>
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
                    <form method="post" action="/interviews/{{ $survey->id }}/show_result" id="interview_{{ $user_id }}" class="show_form">
                        @csrf
                        <input type="hidden" id="" name="survey_id" value="{{ $survey->id }}"/>
                        <input type="hidden" id="" name="user_id" value="{{ $user_id }}"/>
                        <a href="#dialog" id="btn_{{ $user_id }}" class="show_btn">インタビュー結果を見る</button>
                    </form>
                </td>
                @endif
            </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
    
    <!--<a href="#dialog" class="block w-fit">テスト</a>-->
    <div id="dialog" class="hidden target:block">
        <div class="block w-full h-full bg-black/70 absolute top-0 left-0">
            <a href="#" class="block w-full h-full cursor-default"></a>
                <div id="dialog-content" class="w-3/4 mx-auto mt-20 relative -top-full">
                    <table class="text-white">
                    </table>
                </div>
        </div>
    </div>
    
    </div>
</x-app-layout>

<script src="{{ asset('/js/surveys/show.js') }}"></script>