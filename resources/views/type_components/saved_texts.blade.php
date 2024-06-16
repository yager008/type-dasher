<ul class="grid-container">
    {{--  выводим значени таблицы saved_texts --}}
    @foreach ($saved_texts as $result)
        <li class="grid-item">
            <form method="POST" action="{{route('TypeTestController.openSavedText')}}">
                @csrf
                <button name="saved_text_open_btn_{{ $result['id'] }}" id="saved_text_btn_{{ $result['id'] }}" value="{{ $result['text'] }}">{{ $result['text_name'] }}</button>
                <p>best speed: {{ $result['best_speed'] }}</p>
                <input type="text" value="{{$result['best_speed']}}" name="bestSpeed" id="bestSpeed" >
                <input type="text" value="{{$result['id']}}" name="savedTextID" id="savedTextID">
                <input type="text" value="{{$result['text']}}" name="savedText" id="savedText">

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
