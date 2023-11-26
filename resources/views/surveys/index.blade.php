
<x-app-layout>
    <div class="search-form mb-8">
        <h2>検索フォーム</h2>
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
            <input type="submit" class="button primary-button ml-4" value="検索">
            </input>
        </form> 
    </div>
    
    
    <h1 class="text-5xl">作成されたアンケート</h1>
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
</x-app-layout>