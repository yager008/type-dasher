import {textTyped} from "./textTyped.js";

let numberOfMistakes= 0;
let bTypeTextCorrect= true;
let mistakeAlreadyDetected = false;
let numberOfAlreadyTypedChars = 0;

const numberOfCharsLeft = document.getElementById('numberOfCharsLeft');
const textToCompareFromDiv = document.getElementById('textToCompare');
let numberOfLine = 1;
let numberOfCharsInCurrentLine = document.getElementById('numberOfCharsInLine' + numberOfLine);

let aTimePerLines= [];
let aSpeedPerLines = [];

export function typeTextInputFieldUpdated() {


    // console.log("bTypeTextCorrect: " + bTypeTextCorrect);
    // console.log("numberOfMistakes: " + numberOfMistakes);
    // console.log("numberOfLine: " + numberOfLine);

    let textToCompare = document.getElementById('textToCompare').textContent;
    let typeTextInputFieldValue = document.getElementById('typeTextInputField').value;
    let typeTextInputField = document.getElementById('typeTextInputField');
    let numberOfMistakesMakeTextInput= document.getElementById('numberOfMistakes');

//    let inputTextChar = typeTextInputFieldValue.toString().charAt(1); ? вроде нигде не юзается
    let typeTextInputFieldValueLength = typeTextInputFieldValue.length;
    let currentMistakeDetected = false;

    const numberOfMistakesSpan = document.getElementById('numberOfMistakesSpan');
    const currentLineSpeed = document.getElementById('currentLineSpeed');
    const textId = document.getElementById('savedTextId')

    if(typeTextInputField.value.length === 1 && timer.value === "") {
        StartTimer();
        numberOfMistakesSpan.innerHTML = '0';
        currentLineSpeed.innerText = '---';
    }
    if(textID.value !== "") {
        textId.value = textID.value;
    }

    console.log('number of chars in current line: ' + numberOfCharsInCurrentLine.innerText);
    const numberOfCharsLeftInLine = numberOfCharsInCurrentLine.innerText - typeTextInputField.value.length;

    numberOfCharsLeft.innerText = numberOfCharsLeftInLine.toString();

    //когда допечатали строку
    //fires when line is fully typed

    console.log("number of typed chars:" + numberOfAlreadyTypedChars);

    // сетим дебаг див
    // document.getElementById('debug_typedTextOutputDisplayNone').innerText = typeTextInputFieldValue;

    //каждый текст апдейт красим все чары в синий цвет
    for (let i = numberOfAlreadyTypedChars; i < textToCompare.length; ++i) {
        document.getElementById(('char' + i)).style.color = 'blue';
    }

    //пробегаемся по всем напечатанным буква
    for (let i = numberOfAlreadyTypedChars; i < numberOfAlreadyTypedChars + typeTextInputFieldValueLength; ++i) {
        // console.log("typeTextInputFieldValueLength: " + typeTextInputFieldValue);
        console.log('I: ' + i);
        // если буква выбрана правильно
        if (textToCompare.charAt(i) === typeTextInputFieldValue.charAt(i - numberOfAlreadyTypedChars)) {
            //проверяем не покрашен ли уже чар в красный
            if (document.getElementById(('char' + i )).style.color !== 'red') {
                bTypeTextCorrect = true;
                document.getElementById(('char' + i)).style.color = 'green'
            }
        }
        else if (textToCompare.charAt(i) === "~" && typeTextInputFieldValue.charAt(i - numberOfAlreadyTypedChars) === " ") {
            //проверяем не покрашен ли уже чар в красный
            if (document.getElementById(('char' + i )).style.color !== 'red') {
                bTypeTextCorrect = true;
                document.getElementById(('char' + i)).style.color = 'green'
            }
        }

        else {

            bTypeTextCorrect = false;
            currentMistakeDetected = true;

            console.log("bTypeTextCorrect: " + bTypeTextCorrect);

            //если есть хоть одна неправильно написанная буква то весь оставшийся текст красим в красный
            for (let j = i; j < textToCompare.length; ++j) {
                document.getElementById(('char' + j)).style.color = 'red'
            }
        }
    }

    if (currentMistakeDetected && !mistakeAlreadyDetected) {
        numberOfMistakes++;
        numberOfMistakesMakeTextInput.value = numberOfMistakes;
        mistakeAlreadyDetected = true;
        console.log("Mistake detected, numberOfMistakes: " + numberOfMistakes);
        document.getElementById('numberOfMistakesSpan').innerText = numberOfMistakes;
    }

    // Reset mistake detection state if no mistakes are currently detected
    if (!currentMistakeDetected) {
        mistakeAlreadyDetected = false;
    }

    console.log(currentMistakeDetected);
    // if(textToCompare === typeTextInputFieldValue) {
    //     //document.getElementById(('debug_bool')).textContent = 'true'
    //     alert("hello world")
    //
    //     // textTyped();
    //     numberOfMistakes = 0;
    // }
    // else {
    //     //document.getElementById(('debug_bool')).textContent = 'false'
    // }
    if (numberOfCharsLeftInLine === 0 && !currentMistakeDetected) {
        const time = Number(document.getElementById('timer').value);

        const sumInATimePerLines = aTimePerLines.reduce((partialSum, a) => partialSum + a, 0);

        const timePerThisLine = time - sumInATimePerLines;

        const speedPerThisLine = (Number(numberOfCharsInCurrentLine.innerText)/timePerThisLine*60).toFixed(2);

        aTimePerLines.push(timePerThisLine);

        document.getElementById('currentLineSpeed').innerText = parseInt(speedPerThisLine).toString();

        aSpeedPerLines.push(speedPerThisLine);

        // alert(Number(numberOfCharsInCurrentLine.innerText) + " / " + time + " * 60 = " + Number(numberOfCharsInCurrentLine.innerText)/time*60);

        document.getElementById('line' + numberOfLine).style.display = 'none';

        if(numberOfCharsInCurrentLine.getAttribute('name') === 'lastLine') {
            textTyped();
            numberOfMistakes = 0;
        }

        typeTextInputField.value = '';
        // textToCompareFromDiv.innerText = textToCompareFromDiv.innerText.substring(Number(numberOfCharsInCurrentLine.innerText));

        numberOfAlreadyTypedChars = numberOfAlreadyTypedChars + Number(numberOfCharsInCurrentLine.innerText);

        numberOfLine++;

        numberOfCharsInCurrentLine = document.getElementById('numberOfCharsInLine' + numberOfLine);

        if(numberOfCharsInCurrentLine.getAttribute('name') === 'lastLine') {
            // numberOfCharsInCurrentLine.innerText = (Number(numberOfCharsInCurrentLine.innerText) + 1).toString();
        }
    }

    //когда допечатали строку
    // if (numberOfCharsLeftInLine === 0) {
    //     for (let i = numberOfAlreadyTypedChars; i < textToCompare.length; ++i) {
    //         document.getElementById(('char' + i)).style.color = 'blue';
    //     }
    // }

}
