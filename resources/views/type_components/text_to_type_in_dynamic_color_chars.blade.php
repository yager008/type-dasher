<?php

if(isset($lenOfCompareText)) {
    // выводим чары текста который надо будет напечатать
    for ($i = 0; $i < $lenOfCompareText; $i++) {
        if(isset($textToCompare)) {
            if ($textToCompare[$i] == " ") {
                echo "<div style='float: left; background-color: #ffffff; opacity: .0;'>/</div> ";
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
