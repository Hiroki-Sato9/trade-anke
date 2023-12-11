
<x-app-layout>
    <div class="py-12">
        <div class="flex flex-col max-w-7xl mx-auto bg-white">
            @foreach ($posts as $post)
                @if ($post->user->is($user))
                <div class="post request_user w-48 self-end mb-4">
                    <span>{{ $post->user->name }}</span>
                    <div>{{ $post->body }}</div>
                </div>
                @else
                <div class="post requested_user w-48 self-start mb-4">
                    <span>{{ $post->user->name }}</span>
                    <div>{{ $post->body }}</div>
                </div>
                @endif
            @endforeach
        </div>
        
        <div class="max-w-7xl mx-auto bg-white">
            <form method="post" action="/interviews/{{ $survey->id }}/select" class="interview_form">
                @csrf
                <label for="question">質問</label>
                <input type="text" name="question" id="question">
                
                <label for="answer">回答</label>
                <input type="text" name="answer" id="answer">
                
                <input type="submit" value="インタビューを記録">
            </form>
        </div>
    </div>
</x-app-layout>

<script src="{{ asset('js/store_interviews.js') }}"></script>