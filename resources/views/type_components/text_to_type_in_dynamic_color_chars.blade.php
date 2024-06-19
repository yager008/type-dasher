<?php
$bInsertLineBreakOnNextSpace = false;
$numberOfChartsWithoutLineBreak = 0;
$numberOfCurrentLine = 1;
$b0nlyOneLine = true;

if(isset($lenOfCompareText)) {
    // выводим чары текста который надо будет напечатать
    echo "<span class='line' id='line1'>";
    echo "<span class='word'>";

    for ($i = 0; $i < $lenOfCompareText; $i++) {
        $numberOfChartsWithoutLineBreak++;

        if(isset($textToCompare)) {
            if ($textToCompare[$i] == " ") {

                if($numberOfChartsWithoutLineBreak > 92) {
                    $b0nlyOneLine = false;

                    echo "</span>";
                    echo "<br>";
                    echo "<div id='numberOfCharsInLine{$numberOfCurrentLine}' name='line' style='display: none'>{$numberOfChartsWithoutLineBreak}</div>";
                    echo "</span>";

                    $numberOfChartsWithoutLineBreak = 0;
                    $numberOfCurrentLine++;

                    echo "<span class='line' id='line{$numberOfCurrentLine}'>";
                    echo "<span class='word'>";
                }

                else {
                    echo "</span>";
                    echo "<div id='space' style='float: left; background-color: #ffffff; opacity: .0;'>/</div> ";
                    echo "<span class='word'>";

                }


            }
            echo "
                <div id='char{$i}' style='color: blue; float: left'>
                    {$textToCompare[$i]}
                </div>
                ";
        }
        else {
            echo 'variable $textToCompare is not defined in parent file';
        }
    }
//    if ($b0nlyOneLine) {
//        echo "hello world";
//        echo "<div id='numberOfCharsInLine{$numberOfCurrentLine}'>{$numberOfChartsWithoutLineBreak}</div>";
//    }

    echo "</span>";
    echo "<br>";
    echo "</span>";
    echo "<div id='numberOfCharsInLine{$numberOfCurrentLine}' name='lastLine'>{$numberOfChartsWithoutLineBreak}</div>";
}

