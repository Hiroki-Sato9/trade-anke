
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('アンケートに回答') }}
        </h2>
    </x-slot>
    
   <div class="py-12">
   
   <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
        <h1 class="text-5xl mb-4">{{ $survey->title }}</h1>
        <div class="bg-white shadow-sm p-6 mb-32">
            <h2 class="text-3xl">概要</h2>
            <p>{{ $survey->description }}</p>
        </div>
       
       <h2 class="text-3xl">アンケートに回答してください</h2>
       <form method="post" action="{{ route('answers.store', ['survey' => $survey->id]) }}" class="">
            @csrf
            @if (!$survey->is_form_survey())
                @foreach ($survey->questions as $question)
                    <div class="mb-4">
                        <input type="hidden" name= "answer[{{ $question->id }}][user_id]" value="{{ Auth::id() }}">
                        <input type="hidden" name= "answer[{{ $question->id }}][question_id]" value="{{ $question->id }}">
                        <x-input-label for="answer{{ $question->id }}" :value="__($question->body)" />
                        <x-text-input id="answer{{ $question->id }}" class="block mt-1 w-full" type="text" name="answer[{{ $question->id }}][body]" :value="old('answer' . $question->id)" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('answer' . $question->id)" class="mt-2" />
                    </div>
                @endforeach
            @else
                <div id="form_container" data-url="{{ $survey->form_share_url }}"></div>
                <p>回答フォームが表示されない場合は<a href="{{ $survey->form_share_url }}?usp=sf_link">こちら</a></p>
            @endif
            <x-primary-button class="ml-4">
                {{ __('回答') }}
            </x-primary-button>
        </form>
    </div>
    
    </div>
</x-app-layout>

<script src="{{ asset('/js/answers/answer.js') }}"></script>