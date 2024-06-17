<?php

if(isset($lenOfCompareText)) {
    // выводим чары текста который надо будет напечатать
    echo "<span class='line'>";
    echo "<span class='word'>";
    $bInsertLineBreakOnNextSpace = false;
    $numberOfChartsWithoutLineBreak = 0;

    for ($i = 0; $i < $lenOfCompareText; $i++) {
        $numberOfChartsWithoutLineBreak++;

        if(isset($textToCompare)) {
            if ($textToCompare[$i] == " ") {
                if($numberOfChartsWithoutLineBreak > 92) {

                    echo "</span>";
                    echo "<br>";
                    echo "</span>";
                    $numberOfChartsWithoutLineBreak = 0;
                    echo "<span class='line'>";
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
}

?>
