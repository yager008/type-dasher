<x-app-layout>
    @include('type_components.saved_texts')


    <form method="POST" action="{{ route('BibleApiController.index') }}">
        @csrf
        <label>
            <button name="BibleButton" id="BibleButton" class="btn btn-primary">
                RandomBibleVerse
            </button>
        </label>
    </form>

    <form method="POST" action="{{ route('LoremApiController.index') }}">
        @csrf
        <label>
            <button name="LoremButton" id="LoremButton" class="btn btn-primary">
                LoremButton
            </button>
        </label>
    </form>

</x-app-layout>
