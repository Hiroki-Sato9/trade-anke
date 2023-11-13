
<x-app-layout>
    <form method="post" action="/surveys">
        @csrf
        <div>
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" class="block mt-1 w-full" type="text" name="survey[title]" :value="old('survey.title')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('survey.title')" class="mt-2" />
        </div>
        
        <div>
            <x-input-label for="description" :value="__('Description')" />
            <x-text-input id="description" class="block mt-1 w-full" type="text" name="survey[description]" :value="old('survey.description')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('survey.description')" class="mt-2" />
        </div>
        
        <div>
            <x-input-label for="answer_limit" :value="__('目標回答人数')" />
            <x-text-input id="answer_limit" class="block mt-1 w-full" type="number" name="survey[answer_limit]" :value="old('survey.answer_limit')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('survey.description')" class="mt-2" />
        </div>
        
        <div class="questions">
            @if(empty(old('question')))
                <div>
                    <x-input-label for="question0" :value="__('Question')" />
                    <x-text-input id="question0" class="block mt-1 w-full" type="text" name="question[][body]" :value="old('question.0.body')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('question.body')" class="mt-2" />
                </div>
            @else
                @foreach(old('question', []) as $key => $value)
                    <x-input-label for="question{{ $key }}" :value="__('Question')" />
                    <x-text-input id="question{{ $key }}" class="block mt-1 w-full" type="text" name="question[][body]" :value="old('question.' . $key . '.body')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('question.body.' . $key)" class="mt-2" />
                @endforeach
            @endif
        </div>
        
        <div class="m-3">
            <input type="button" value="+" class="add-question-btn rounded-full w-12 h-12 bg-white text-xl font-bold"></input>
        </div>
        
        <x-primary-button class="ml-4">
                {{ __('作成') }}
        </x-primary-button>
    </form>
</x-app-layout>