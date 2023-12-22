
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('アンケート一覧') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
    
    <div class="search-form max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mb-4">
        <h2 class="text-2xl pb-2.5 border-b-2 border-solid border-gray-600">検索フォーム</h2>
        <form method="get" action="/surveys">
            @csrf
            <div class="mt-4">
                <label for="gender_id">性別</label>
                <select class="" id="gender_id" name="gender_id">
                    @foreach ($genders as $gender)
                        <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                    @endforeach
                </select>
            </div>
        
            <div>
                <label for="min_age">min</label>
                <input id="min_age" class="block mt-1 w-full" type="number" name="min_age" value="{{ old('min_age') }}" />
            </div>
            
            <div>
                <label for="max_age">max</label>
                <input id="max_age" class="block mt-1 w-full" type="number" name="max_age" value="{{ old('max_age') }}" />
            </div>
            
            <div>
                <label for="keyword">キーワード</label>
                <input id="keyword" class="block mt-1 w-full" type="text" name="keyword" value="{{ old('keyword') }}" />
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">検索
            </button>
        </form> 
    </div>
    
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mb-4">
        <h1 class="text-2xl pb-2.5 border-b-2 border-solid border-gray-600">作成されたアンケート</h1>
        <div class="contents">
            <table border="2">
                <tr>
                    <th>アンケート名</th>
                    <th>概要</th>
                    <th>対象の性別</th>
                    <th>対象の年代</th>
                    <th>回答人数</th>
                </tr>
                @foreach ($surveys as $survey)
                    <tr>
                        <td><a href="/surveys/{{ $survey->id }}" class="text-xl">{{ $survey['title'] }}</a></td>
                        <td>{{ $survey['description']}}</td>
                        <td>{{ $survey->gender_name() }}</td>
                        <td>{{ $survey->min_age }}~{{ $survey->max_age }}</td>
                        <td>{{ "hello" }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    
    </div>
</x-app-layout>