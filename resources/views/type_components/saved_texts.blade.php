<ul class="grid-container">
    {{--  выводим значени таблицы saved_texts --}}
    @foreach ($saved_texts as $result)
        <li class="grid-item">
            <form method="POST" action="{{route('TypeTestController.openSavedText')}}">
                @csrf
                <button class="btn btn-danger" name="saved_text_open_btn_{{ $result['id'] }}" id="saved_text_btn_{{ $result['id'] }}" value="{{ $result['text'] }}">type</button>
                <p>best speed: {{ $result['best_speed'] }}</p>
                <input type="text" value="{{$result['best_speed']}}" name="bestSpeed" id="bestSpeed" >
                <input type="text" value="{{$result['id']}}" name="savedTextID" id="savedTextID">
                <input type="text" value="{{$result['text']}}" name="savedText" id="savedText">
                <input type="text" value="{{$result['text_name']}}" name="savedTextName" id="savedText">

{{--                    <?php--}}
{{--                if (isset($_POST["saved_text_open_btn_" . $result['id']]))--}}
{{--                {--}}
{{--                    ?>--}}
{{--                <script>--}}
{{--                    console.log('console log: {{$result['id']}}');--}}

{{--                    InButtonText = document.getElementById('saved_text_btn_{{ $result['id'] }}').value;--}}
{{--                    document.getElementById('inputTextBox').value = InButtonText;--}}
{{--                    document.getElementById('savedTextId').value = {{ $result['id'] }};--}}
{{--                    document.getElementById('savedTextID').value = {{ $result['id'] }};--}}
{{--                </script>--}}
{{--                    <?php--}}
{{--                }--}}
{{--                    ?>--}}
            </form>

            <div class="button-container">
                <button class="show-text-button">Show
                    <span class="tooltip-text">{{ $result['text'] }}</span>
                </button>

                <form method="POST" action="{{ route('TypeTestControllerPost.deleteSavedText') }}">
                    @csrf
                    <button name="saved_text_delete_btn" id="saved_text_delete_btn_{{ $result['id'] }}" value="{{ $result['id'] }}">Delete</button>
                </form>
            </div>
        </li>
    @endforeach
    <li class="grid-item">
        <div class="container">
            <div class="row">
                <div class="col">
                    <form method="POST" action="{{ route('BibleApiController.index') }}">
                        @csrf
                        <button name="BibleButton" id="BibleButton" class="btn btn-primary">
                            RandomBibleVerse
                        </button>
                    </form>
                </div>
                <div class="col">
                    <form method="POST" action="{{ route('LoremApiController.index') }}">
                        @csrf
                        <button name="LoremButton" id="LoremButton" class="btn btn-primary">
                            LoremButton
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div id="submit new text div">
            <form autocomplete="off" method="POST" action="{{ route('TypeTestControllerPost.createText') }}">
                @csrf
                <div id='textNameDiv' class="container">
                    <div id="alert" class="mt-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" style="visibility: hidden">

                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">You cannot enter more than 15 characters.</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="closeAlert()">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 011.414 1.414l-4.657 4.657 4.657 4.657a1 1 0 01-1.414 1.414l-4.657-4.657-4.657 4.657a1 1 0 01-1.414-1.414l4.657-4.657-4.657-4.657a1 1 0 011.414-1.414l4.657 4.657 4.657-4.657z"/></svg>
                    </span>
                    </div>
                    <br>
                    <label for="savedTextName" class="block text-gray-700 text-sm font-bold mb-2">Enter text (max 15 characters):</label>
                    <input type="text" id="savedTextName" name="savedTextName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

                </div>

                <label>
                    <input type="text" name="inputTextBox" id="inputTextBox"
                           value="{{(isset($textToSetInInputTextBox))?$textToSetInInputTextBox:''}}">
                </label>

                {{--            <label>--}}
                {{--                <input type="text" name="savedTextID" id="savedTextID" style="display: n"--}}
                {{--                       value="{{(isset($savedTextID))?$savedTextID:''}}">--}}
                {{--            </label>--}}

                <label>
                    <input type="submit" name="submitInputTextBoxButton" id="submitInputTextBoxButton" class="btn btn-primary">
                </label>
            </form>
        </div>
    </li>
</ul>

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
