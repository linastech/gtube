<?php
/*Please don't ever call this page, you don't want to change the base salt*/
require_once("words.inc.php");
function changeBaseSalt()
{
    global $words, $TOTAL_SIZE;
    $saltBase =  $words[rand(0, $TOTAL_SIZE)] . newSpecial();
    $saltBase .= date("s");
    file_put_contents("./sel", $saltBase);
}

changeBaseSalt();
