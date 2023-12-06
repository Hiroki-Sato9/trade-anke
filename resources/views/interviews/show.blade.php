
<x-app-layout>
    <div class="py-12">
        <div class="flex flex-col max-w-7xl mx-auto bg-white">
            @foreach ($posts as $post)
                @if ($post->user->is($user))
                <div class="post w-48 self-start mb-4">
                    <span>{{ $post->user->name }}</span>
                    <div>{{ $post->body }}</div>
                </div>
                @else
                <div class="post w-48 self-end mb-4">
                    <span>{{ $post->user->name }}</span>
                    <div>{{ $post->body }}</div>
                </div>
                @endif
            @endforeach
        </div>
        <div class="max-w-7xl mx-auto bg-white">
            <form method="post" action="/interviews/{{ $survey->id }}">
                @csrf
                <input type="text" name="body" />
                <input type="submit" value="投稿" />
            </form>
        </div>
    </div>
    
    <button>インタビュー終了</button>
</x-app-layout>

<script src="{{ asset('js/posts.js') }}"></script>