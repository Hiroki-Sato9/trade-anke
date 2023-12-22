
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('アンケートに回答') }}
        </h2>
    </x-slot>
    
   <div class="py-12">
       
       
   <form method="post" action="/answers" class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 mb-4">
       @csrf
        @foreach ($survey->questions as $question)
            <div>
                <input type="hidden" name= "answer[{{ $question->id }}][user_id]" value="{{ Auth::id() }}">
                <input type="hidden" name= "answer[{{ $question->id }}][question_id]" value="{{ $question->id }}">
                <x-input-label for="answer{{ $question->id }}" :value="__($question->body)" />
                <x-text-input id="answer{{ $question->id }}" class="block mt-1 w-full" type="text" name="answer[{{ $question->id }}][body]" :value="old('answer' . $question->id)" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('answer' . $question->id)" class="mt-2" />
            </div>
        @endforeach
        <x-primary-button class="ml-4">
            {{ __('回答') }}
        </x-primary-button>
    </form>
    </div>
</x-app-layout>