<script>
    function StartTimer () {
        let timerCounter = 0;
        window.setInterval(myTimer, 1000);
        document.getElementById('timer').value = 0;

        function myTimer() {
            timerCounter++;
            let fullTextLength = document.getElementById('lenOfFullText').innerText;
            document.getElementById('timer').value = timerCounter.toString();
            document.getElementById('outputSpeed').value = fullTextLength / timerCounter.toString() * 60;
        }
    }
</script>

<?php

    //сетим див с текстом из апи

if (!empty($textToCompare)) {
    echo "<div style='display: none';>";
//    текст с которым сравнивается инпут при каждом напечатанном символе
    echo "textToCompare: <div id='textToCompare'>{$textToCompare}</div><br>";

    $lenOfCompareText = strlen($textToCompare);
    echo "<div style='float: left';> Length of compare text:</div> <div id='lenOfFullText';> {$lenOfCompareText}</div> <br>";
} else {
    echo "text to compare is empty <br>";
}
echo "</div>";

if (isset($bShouldStartTimer) && $bShouldStartTimer) {
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('typeTextInputField').focus();
        StartTimer();
    });
</script>
<?php
}
?>

<x-app-layout>
<dialog id="dialogBox" class="content-around">
    <div class="flex justify-center items-center h-full flex-col">
        <p>Your speed result:</p>
        <p id="dialogMessage" class="inline"></p>
        <p>symbols/second</p>
        <br>
        <button onclick="closeDialog()" class="bg-blue-900 ">Close</button>
    </div>

</dialog>
    <div style="color:#11998e" id="speedForLine">speedForLine</div>

<script>
    if({{$bShowDialogBoxWithResult}}) {
        document.getElementById('dialogMessage').innerText = "{{$dialogBoxContent}}";
        document.getElementById('dialogBox').showModal();
    }
</script>

<div class="container-fluid d-flex flex-column align-items-center vh-100">
    <p>{{$updateInfo}}</p>
    <div style="display: ">
        <form method="POST" action="{{route('TypeTestController.store')}}">
            @csrf
            <input type="text" id="outputSpeed" name="outputSpeed" placeholder="outputSpeed"
                   value="{{ strlen($textToCompare)}}" readonly style="display: n">
            <lable for="timer"></lable>
            <input type="text" id="timer" name="timer" readonly style="">
            <input type="text" id="numberOfMistakes" name="numberOfMistakes" readonly style="">
            <label>
                <input type="text" name="savedTextId" id="savedTextId" value=" {{ (isset($idOfSavedText))?$idOfSavedText:'' }}" style="">
            </label>
            <input type="submit" id="submitTimeButton" name="submitTimeButton" style="">
        </form>
    </div>

    <div id="submit new text div">
        <form autocomplete="off" method="POST" action="{{ route('TypeTestController.storeSavedTextIfCheckBoxIsOn') }}">
            @csrf

            <div id='textNameDiv' class="container mx-auto p-4" style="visibility: hidden">
                    <label for="savedTextName" class="block text-gray-700 text-sm font-bold mb-2">Enter text (max 15 characters):</label>
                    <input type="text" id="savedTextName" name="savedTextName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

                <div id="alert" class="hidden mt-2 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">

                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">You cannot enter more than 15 characters.</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="closeAlert()">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 011.414 1.414l-4.657 4.657 4.657 4.657a1 1 0 01-1.414 1.414l-4.657-4.657-4.657 4.657a1 1 0 01-1.414-1.414l4.657-4.657-4.657-4.657a1 1 0 011.414-1.414l4.657 4.657 4.657-4.657z"/></svg>
            </span>
                </div>
            </div>

            <label>
                <input type="checkbox" title="should save text to saved_texts" name="checkbox" id="checkbox">
            </label>

            <label>
                <input type="text" name="inputTextBox" id="inputTextBox"
                       value="{{(isset($textToSetInInputTextBox))?$textToSetInInputTextBox:''}}">
            </label>

            <label>
                <input type="text" name="savedTextID" id="savedTextID" style="display: n"
                    value="{{(isset($savedTextID))?$savedTextID:''}}">
            </label>

            <label>
                <input type="submit" name="submitInputTextBoxButton" id="submitInputTextBoxButton" class="btn btn-primary">
            </label>
        </form>
    </div>

    <div>

{{--        <div class="form__group field">--}}
{{--            <input type="input" class="form__field" placeholder="Name" name="name" id='name' required />--}}
{{--            <label for="name" class="form__label">Name</label>--}}

{{--            <label for="typeTextInputField"></label>--}}
{{--            <input class="form__field" autocomplete="off" type="text" id="typeTextInputField">--}}
{{--                   oninput="window.typeTextInputFieldUpdated()" style="width: 800px; ">--}}

{{--        </div>--}}
        <label for="typeTextInputField"></label>
        <input class="form__field" autocomplete="off" type="input" id="typeTextInputField"
        oninput="window.typeTextInputFieldUpdated()" style="width: 650px; ">

{{--        <label for="typeTextInputField"></label>--}}
{{--        <input autocomplete="off" type="text" id="typeTextInputField" class="form-control p-3 "--}}
{{--               oninput="window.typeTextInputFieldUpdated()" style="width: 800px; ">--}}
    </div>
{{--    <div>--}}
{{--        <br><br>--}}
{{--        <!-- debug typed text -->--}}
{{--        <p id="debug_typedTextOutputDisplayNone" style="display: none"></p>--}}
{{--    </div>--}}
    <div id="chars wrapper" style="width: 770px;">
        @include('type_components.text_to_type_in_dynamic_color_chars')
    </div>
</div>

<!-- bootstrap scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

<form id="exitSavedTextModeForm" action="{{ route('TypeTestController.exitSavedTextMode') }}" method="POST" style="display: none;">
    @csrf
</form>

<form id="reloadPage" action="{{ route('TypeTestController.type') }}" method="GET" style="display: none;">
    @csrf
</form>

    <div id="numberOfCharsLeft" style="color:#11998e">92</div>

    <div id="numberOfLine" style="color:#11998e">1</div>

    <span id="currentLineSpeed" style="color:#11998e">...</span>
    <span id="numberOfMistakesSpan" style="color:#11998e">...</span>

<script>
    //выходо из сейвд текст мода
    const inputTextBox = document.getElementById('inputTextBox');
    const savedTextID = document.getElementById('savedTextID');
    const exitSavedTextModeForm = document.getElementById('exitSavedTextModeForm');

    inputTextBox.addEventListener('input', function () {
        if(savedTextID.value !== "") {
            savedTextID.value = "";
            exitSavedTextModeForm.submit();
        }
    });

    //сетим таймер если еще не начат и вбивается первая буква
    const typeTextInputField = document.getElementById('typeTextInputField');
    const textToCompare = "{{$textToCompare}}";
    const timer = document.getElementById('timer')
    const submitButton = document.getElementById('submitInputTextBoxButton')
    const textID = document.getElementById('savedTextID')
    const textId = document.getElementById('savedTextId')

    typeTextInputField.addEventListener('input', function () {
        if(typeTextInputField.value.length === 1 && timer.value === "") {
            StartTimer();
        }
        if(textID.value !== "") {
            textId.value = textID.value;
        }
    });

    //hide open saved text name
    const checkbox = document.getElementById('checkbox')
    const savedTextName = document.getElementById('savedTextName')
    const textNameDiv = document.getElementById('textNameDiv')
    const alertDiv = document.getElementById('alert');

    checkbox.addEventListener("click", function () {
        if(checkbox.checked) {
            textNameDiv.style = '';
        }
        else {
            textNameDiv.style = 'visibility: hidden';
        }
    });

    savedTextName.addEventListener('input', function() {
        if (savedTextName.value.length > 15) {
            savedTextName.value = savedTextName.value.slice(0, 15);
            alertDiv.classList.remove('hidden');
        } else {
            alertDiv.classList.add('hidden');
        }
    });

    function closeAlert() {
        alertDiv.classList.add('hidden');
    }

    // const numberOfCharsLeft = document.getElementById('numberOfCharsLeft');
    // const textToCompareFromDiv = document.getElementById('textToCompare');
    // let numberOfLine = 1;
    // let numberOfCharsInCurrentLine = document.getElementById('numberOfCharsInLine' + numberOfLine);

    function Timer(fn, t) {
        let timerObj = setInterval(fn, t);

        this.stop = function() {
            if (timerObj) {
                clearInterval(timerObj);
                timerObj = null;
            }
            return this;
        }

        // start timer using current settings (if it's not already running)
        this.start = function() {
            if (!timerObj) {
                this.stop();
                timerObj = setInterval(fn, t);
            }
            return this;
        }

        // start with new or original interval, stop current interval
        this.reset = function(newT = t) {
            t = newT;
            return this.stop().start();
        }
    }

    let timer1 = new Timer(function() {
        document.getElementById('reloadPage').submit();
    }, 1000);
    timer1.stop();

    typeTextInputField.addEventListener('input', function () {
        //TODO reset time as option in menu
        timer1.reset(5000);
    })

    function restartTimer() {
        document.getElementById('reloadPage').submit();
    }
</script>

</x-app-layout>
