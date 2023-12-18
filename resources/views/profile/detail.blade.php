
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('あなたのアンケート情報') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mb-4">
        <div>あなたのポイント：{{ $user->profile->point }}</div>
        <h2>あなたが作成したアンケート</h2>
            <table>
                <tr>
                    <th>アンケート</th>
                    <th>配布フォーム</th>
                    <th>インタビュー</th>
                </tr>
                @foreach($created_surveys as $survey)
                    <tr>
                        <td><a href="/surveys/{{ $survey->id }}">{{ $survey->title }}</a></td>
                        <td>
                             <form method="post" action="/deliver">
                                @csrf
                                <input type="hidden" name="survey" value="{{ $survey->id }}">
                                <input type="number" name="num">
                                <input type="submit" value="配布">
                            </form>
                        </td>
                        <td>
                            @if (isset($survey->interview_request))
                                @if ($survey->interview_request->accepted == true)
                                    <a href="/interviews/{{ $survey->id }}">インタビュー部屋へ</a>
                                @else
                                    <div>リクエスト中</div>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mb-4">
        <h2>あなたが回答したアンケート</h2>
        <ul>
            @foreach($answered_surveys as $survey)
            <li>
                <div class="flex">
                    <a href="/surveys/{{ $survey->id }}">{{ $survey->title }}</a>
                    @if (isset($survey->interview_request) && $survey->interview_request->is_request_user($user))
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
    </div>
    
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mb-4">
        <h2>あなたに配られたアンケート</h2>
        @foreach($delivered_surveys as $survey)
            <li>
                <a href="/answers/{{ $survey->id }}">{{ $survey->title }}</a>
            </li>
        @endforeach
    </div>
    
    </div>
</x-app-layout>