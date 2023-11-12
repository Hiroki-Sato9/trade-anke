
<x-app-layout>
    <form method="post" action="#">
        @csrf
        <div>
            <x-input-label for="title" :value="__('Title')" />
            <x-text-input id="title" class="block mt-1 w-full" type="text" name="survey[title]" :value="old('survey.title')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('survey.title')" class="mt-2" />
        </div>
        
        <div>
            <x-input-label for="description" :value="__('Description')" />
            <x-text-input id="description" class="block mt-1 w-full" type="text" name="survey[description]" :value="old('survey.title')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('survey.description')" class="mt-2" />
        </div>
        
        <div class="questions">
            <div>
                <x-input-label for="question1" :value="__('Question')" />
                <x-text-input id="question1" class="block mt-1 w-full" type="text" name="question[]" :value="old('survey.title')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('question.body')" class="mt-2" />
            </div>
        </div>
        
        <div class="m-3">
            <button class="add-question-btn rounded-full w-12 h-12 bg-white text-xl font-bold">+</button>
        </div>
    </form>
</x-app-layout>