
<x-app-layout>
    <div>あなたのポイント：{{ $user->profile->point }}</div>
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
            <div class="flex">
                <a href="/surveys/{{ $survey->id }}">{{ $survey->title }}</a>
                @if (isset($survey->interview_request) && $survey->interview_request->is_requested_user($user))
                    @if ($survey->interview_request->accepted == true)
                        <a href="/interviews/{{ $survey->id }}">インタビュー部屋へ</a>
                    @else
                        <form method="post" action="{{ route('interviews.accept', ['survey' => $survey->id], false) }}">
                            @method('put')
                            @csrf
                            <input class="button" type="submit" value="インタビューを受け入れる" />
                        </form>
                    @endif
                @endif
            </div>
        </li>
        @endforeach
    </ul>
    
    <h2>あなたに配られたアンケート</h2>
    @foreach($delivered_surveys as $survey)
        <li>
            <a href="/answers/{{ $survey->id }}">{{ $survey->title }}</a>
        </li>
    @endforeach
</x-app-layout>