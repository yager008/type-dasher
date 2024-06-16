export function onSubmitInputTextBoxButtonClicked() {
    let timerCounter = 0;
    alert('hello');
    window.setInterval(myTimer, 1000);

    function myTimer() {
        timerCounter++;
        let fullTextLength = document.getElementById('lenOfFullText').innerText;

        document.getElementById('timer').value = timerCounter.toString();
        document.getElementById('outputSpeed').value = fullTextLength / timerCounter.toString() * 60;
    }

    document.getElementById('typeTextInputField').focus();
}
