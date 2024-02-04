
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('アンケートの作成') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
    <form method="post" action="/surveys" class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mb-4">
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
        
        <div class="">
            <div class="google-forms"></div>
            <div class="questions">
                @if(empty(old('question')))
                <div class="question">
                        <x-input-label for="question0" :value="__('Question')" />
                        <x-text-input id="question0" class="block mt-1 w-full" type="text" name="question[][body]" :value="old('question.0.body')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('question.0.body')" class="mt-2" />
                </div>
                @else
                    @foreach(old('question', []) as $key => $value)
                        <div class="question">
                            <x-input-label for="question{{ $key }}" :value="__('Question')" />
                            <x-text-input id="question{{ $key }}" class="block mt-1 w-full" type="text" name="question[][body]" :value="old('question.' . $key . '.body')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('question.' . $key . '.body')" class="mt-2" />
                        </div>
                    @endforeach
                    
                @endif
        </div>
        </div>
        
        <div class="m-3">
            <input type="button" value="+" class="add-question-btn rounded-full w-12 h-12 bg-white text-xl font-bold"></input>
        </div>
        
        <h3 class="text-xl pb-2.5 border-b-2 border-solid border-gray-600">アンケートを配りたい人</h3>
        <div class="mt-4">
            <x-input-label for="gender_id" :value="__('Gender')" />

            <select class="" id="gender_id" name="survey[gender_id]">
                @foreach ($genders as $gender)
                    <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('survey.gender')" class="mt-2" />
        </div>
        
        <div>
            <x-input-label for="min_age" :value="__('min')" />
            <x-text-input id="min_age" class="block mt-1 w-full" type="number" name="survey[min_age]" :value="old('survey.min_age')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('survey.min_age')" class="mt-2" />
        </div>
        
        <div>
            <x-input-label for="max_age" :value="__('max')" />
            <x-text-input id="max_age" class="block mt-1 w-full" type="number" name="survey[max_age]" :value="old('survey.max_age')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('survey.max_age')" class="mt-2" />
        </div>
        
        <x-primary-button class="ml-4">
                {{ __('作成') }}
        </x-primary-button>
    </form>
    </div>
</x-app-layout>

<script src="{{ asset('/js/surveys/create.js') }}"></script>