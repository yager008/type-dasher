import {textTyped} from "./textTyped.js";

let numberOfMistakes= 0;
let bTypeTextCorrect= true;
let mistakeAlreadyDetected = false;

export function typeTextInputFieldUpdated() {
    console.log("bTypeTextCorrect: " + bTypeTextCorrect);
    console.log("numberOfMistakes: " + numberOfMistakes);

    let textToCompare = document.getElementById('textToCompare').textContent;
    let typeTextInputFieldValue = document.getElementById('typeTextInputField').value;
    let numberOfMistakesMakeTextInput= document.getElementById('numberOfMistakes');

//    let inputTextChar = typeTextInputFieldValue.toString().charAt(1); ? вроде нигде не юзается
    let typeTextInputFieldValueLength = typeTextInputFieldValue.length;
    let currentMistakeDetected = false;


    // сетим дебаг див
    document.getElementById('debug_typedTextOutputDisplayNone').innerText = typeTextInputFieldValue;

    //каждый текст апдейт красим все чары в синий цвет
    for (let i = 0; i < textToCompare.length; ++i) {
        document.getElementById(('char' + i)).style.color = 'blue'
    }



    //пробегаемся по всем напечатанным буквам
    for (let i = 0; i < typeTextInputFieldValueLength; ++i) {
        console.log("typeTextInputFieldValueLength: " + typeTextInputFieldValue);
        // если буква выбрана правильно
        if (textToCompare.charAt(i) === typeTextInputFieldValue.charAt(i)) {
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
    }

    // Reset mistake detection state if no mistakes are currently detected
    if (!currentMistakeDetected) {
        mistakeAlreadyDetected = false;
    }

    if(textToCompare === typeTextInputFieldValue) {
        //document.getElementById(('debug_bool')).textContent = 'true'

        textTyped();
        numberOfMistakes = 0;
    }
    else {
        //document.getElementById(('debug_bool')).textContent = 'false'
    }
}
