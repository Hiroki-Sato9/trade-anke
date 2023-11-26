
<x-app-layout>
    <div class="search-form mb-8">
        <h2>検索フォーム</h2>
        <form method="get" action="#">
            <div class="mt-4">
                <x-input-label for="gender_id" :value="__('Gender')" />
    
                <select class="" id="gender_id" name="search[gender_id]">
                    @foreach ($genders as $gender)
                        <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('search.gender')" class="mt-2" />
            </div>
        
            <div>
                <x-input-label for="min_age" :value="__('min')" />
                <x-text-input id="min_age" class="block mt-1 w-full" type="number" name="search[min_age]" :value="old('search.min_age')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('survey.min_age')" class="mt-2" />
            </div>
            
            <div>
                <x-input-label for="max_age" :value="__('max')" />
                <x-text-input id="max_age" class="block mt-1 w-full" type="number" name="search[max_age]" :value="old('search.max_age')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('search.max_age')" class="mt-2" />
            </div>
            
            <x-primary-button class="ml-4">
                    {{ __('検索') }}
            </x-primary-button>
        </form> 
    </div>
    
    
    <h1 class="text-5xl">作成されたアンケート</h1>
    <div class="contents">
        <ul>
            @foreach ($surveys as $survey)
                <li>
                    <div class="mb-4">
                        <a href="/surveys/{{ $survey->id }}" class="text-xl">{{ $survey['title'] }}</a>
                        <p class="description ml-2">{{ $survey['description']}}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>