
<x-app-layout>
    <div class="py-12">
        <div id="posts" class="flex flex-col max-w-7xl mx-auto bg-white">
        </div>
        <div class="max-w-7xl mx-auto bg-white">
            <form method="post" action="/interviews/{{ $survey->id }}">
                @csrf
                <input type="text" name="body" />
                <input type="submit" value="投稿" />
            </form>
        </div>
    </div>
    
    <button onclick="location.href='{{ '/interviews/' . $survey->id . '/select'}}'">インタビュー終了</button>
</x-app-layout>

<script async src="{{ asset('js/posts.js') }}"></script>