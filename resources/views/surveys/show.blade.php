
<x-app-layout>
    <div></div>
    <div class="">
        
    </div>
    <div class="survey">
        <ul>
        @foreach ($survey->questions as $question)
            <li class="mb5">
                {{ $question->body }}
            </li>
        @endforeach
        </ul>
    </div>
</x-app-layout>