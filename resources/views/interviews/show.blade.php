
<x-app-layout>
    <div class="py-12">
        <div id="posts" class="flex flex-col max-w-7xl mx-auto bg-white">
        </div>
        <div class="max-w-7xl mx-auto bg-white">
            <form method="post" action="/interviews/{{ $survey->id }}">
                @csrf
                <input type="text" name="body" />
                <button type="submit" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2" value="投稿">投稿</button>
            </form>
        </div>
        <div class="max-w-7xl mx-auto flex mt-4">
            <button onclick="location.href='{{ '/interviews/' . $survey->id . '/select'}}'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">インタビュー終了</button>
        </div>
    </div>
</x-app-layout>

<script async src="{{ asset('js/posts.js') }}"></script>