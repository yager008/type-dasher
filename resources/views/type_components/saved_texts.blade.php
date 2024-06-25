<ul class="grid-container">
    {{-- Loop through the saved_texts collection --}}
    @foreach ($paginatedSavedTexts as $result)
        {{-- Check if this item is the pseudo item for the create form --}}
{{--        {{dd($result)}}--}}
        @if (isset($result->is_create_form) && $result->is_create_form)
            <li class="grid-item" style="display: none ;" id="create-new-text-item">
            </li>
        @else
            <li class="grid-item" style="height: 225px">
                <span class="flex justify-content-between">
                    <div class="flex">
                    <form method="POST" action="{{route('TypeTestController.openSavedText')}}">
                        @csrf
                        <button class="btn btn-danger" name="saved_text_open_btn_{{ $result['id'] }}" id="saved_text_btn_{{ $result['id'] }}" value="{{ $result['text'] }}">Type</button>
                        <input style="display: none" type="text" value="{{$result['best_speed']}}" name="bestSpeed" id="bestSpeed">
                        <input style="display: none" type="text" value="{{$result['id']}}" name="savedTextID" id="savedTextID">
                        <input style="display: none" type="text" value="{{$result['text']}}" name="savedText" id="savedText">
                        <input style="display: none" type="text" value="{{$result['text_name']}}" name="savedTextName" id="savedText">
                    </form>

{{--                    <button class="btn btn-danger show-text-button">Show--}}
{{--                        <span style="color: #0a58ca " class="tooltip-text">{{ $result['text'] }}</span>--}}
{{--                    </button>--}}

{{--                    <form method="POST" action="">--}}
{{--                        @csrf--}}
{{--                        <button class="btn btn-danger">Post--}}
{{--                        </button>--}}
{{--                    </form>--}}

                    <form class="ml-3" method="POST" action="{{ route('TypeTestController.updateSavedText') }}" >
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-danger">Update
                        </button>
                        <input style="display: none" type="text" value="{{$result['id']}}" name="savedTextID" id="savedTextID">
                        <input style="display: none" type="text" value="{{$result['text']}}" name="savedText" id="savedText">
                        <input style="display: none" type="text" value="" name="updatedText" id="updatedText_{{$result['id']}}">
                    </form>

                    <form class="ml-3" method="POST" action="{{ route('TypeTestController.deleteSavedText') }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" name="saved_text_delete_btn" id="saved_text_delete_btn_{{ $result['id'] }}" value="{{ $result['id'] }}">Delete</button>
                    </form>
                    </div>

                    <p class='' style="color: #FFFFFF"> | {{ $result['text_name'] }} | {{ $result['best_speed'] }}/{{ $result['number_of_mistakes_for_best_type_result'] }} | </p>
                </span>
                <textarea id='updatedTextTextArea_{{$result['id']}}' class="h-75 w-100 mt-1">{{ $result['text'] }}</textarea>

                <script>
                    // Get the elements
                    const updatedTextTextArea_{{$result['id']}} = document.getElementById("updatedTextTextArea_{{$result['id']}}");
                    const inputTextUpdatedText_{{$result['id']}} = document.getElementById('updatedText_{{$result['id']}}');

                    {{--alert(inputTextUpdatedText_{{$result['id']}}.value.replace(/~/g, '\n'));--}}

                    updatedTextTextArea_{{$result['id']}}.value = updatedTextTextArea_{{$result['id']}}.value.replace(/~/g, '\n');

                    // Function to add '~' at the end of each line
                    function processLines(text) {
                        return text.split('\n').map(line => {
                            // Remove all trailing tildes
                            line = line.replace(/~+$/, '');
                            // Add a single tilde if the line is not empty
                            return line.length > 0 ? line + '~' : line;
                        }).join('\n').slice(0, -1);
                    }


                    // Set initial value with tildes added
                    inputTextUpdatedText_{{$result['id']}}.value = processLines(updatedTextTextArea_{{$result['id']}}.value);

                    // Add event listener to update value with tildes added
                    updatedTextTextArea_{{$result['id']}}.addEventListener('input', function () {
                        inputTextUpdatedText_{{$result['id']}}.value = processLines(updatedTextTextArea_{{$result['id']}}.value);

                    });
                </script>
            </li>
        @endif
    @endforeach
    {{-- Check if the current page is the last page --}}

    @if ($paginatedSavedTexts->currentPage() == $paginatedSavedTexts->lastPage())
        <li class="grid-item" style="height: 225px">
            <div class="flex justify-content-between">
                <form autocomplete="off" method="POST" action="{{ route('TypeTestControllerPost.createText') }}">
                    @csrf

                    <input type="text" placeholder='new text name' id="savedTextName" name="savedTextName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <input type="text" name="inputTextBox" id="inputTextBox" style="display: none" value="{{ (isset($textToSetInInputTextBox)) ? $textToSetInInputTextBox : '' }}">
                    <input type="submit" style="display: none" name="submitInputTextBoxButton" id="submitInputTextBoxButton" class="btn btn-primary">
                </form>
                <div class="bible button">
                    <form method="POST" action="{{ route('BibleApiController.index') }}">
                        @csrf
                        <button name="BibleButton" id="BibleButton" class="btn btn-primary">
                            RandomBibleVerse
                        </button>
                    </form>
                </div>
                <div class="lorem button">
                    <form method="POST" action="{{ route('LoremApiController.index') }}">
                        @csrf
                        <button name="LoremButton" id="LoremButton" class="btn btn-primary">
                            LoremButton
                        </button>
                    </form>
                </div>
            </div>

            <textarea id='newTextTextArea' class="h-75 w-100 mt-1" placeholder="new text">{{ (isset($textToSetInInputTextBox)) ? $textToSetInInputTextBox : '' }}</textarea>

            <script>
                //send value to patch form
                newTextTextArea = document.getElementById('newTextTextArea');
                newTextInputTextBox = document.getElementById('inputTextBox');

                newTextTextArea.addEventListener('input', function () {
                    newTextInputTextBox.value = newTextTextArea.value;
                })

            </script>
        </li>
    @endif
</ul>

{{ $paginatedSavedTexts->links() }}

<style>
    .grid-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px; /* Adjust the gap as needed */
        list-style-type: none;
        padding: 30px;
    }
    .grid-item {
        border: 1px solid #ccc; /* Optional: Add border to grid items */
        padding: 10px; /* Optional: Add padding to grid items */
    }
    .button-container {
        display: flex;
        gap: 10px; /* Space between buttons */
        margin-top: 10px; /* Optional: Add some margin */
    }
    .show-text-button {
        position: relative;
        padding: 5px 10px; /* Optional: Add padding to buttons */
    }
    .tooltip-text {
        display: none;
        position: absolute;
        bottom: 100%; /* Position the tooltip above the button */
        left: 0;
        background-color: #fff; /* Background color to match the button */
        padding: 5px;
        border: 1px solid #ccc; /* Optional: Add border */
        z-index: 1; /* Ensure it appears above other elements */
        min-width: 400px; /* Minimum width of the tooltip */
        /*min-height: 400px; !* Minimum height of the tooltip *!*/
        max-width: 400px; /* Maximum width of the tooltip */
        max-height: 1000px; /* Maximum height of the tooltip */
        overflow: auto; /* Add scrollbars if content exceeds the maximum dimensions */
        white-space: normal; /* Allow text to wrap */
        text-align: left; /* Align text to the left */
        word-break: break-word; /* Ensure long words break to the next line */
    }
    .show-text-button:hover .tooltip-text {
        display: block;
    }
</style>
