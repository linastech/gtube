<?php
$words = array();
$TOTAL_SIZE = 1;
if(file_exists("./sec/dict_words.txt"))
{
$words = file("./sec/dict_words.txt", FILE_IGNORE_NEW_LINES);
$TOTAL_SIZE = count($words) - 1;
}
else die("no salts file");

function newSpecial()
{
    $SPECIALS = array("!", "@", "#", "%", "^", "&", "*", "(", ")");
    return $SPECIALS[rand(0, count($SPECIALS) - 1)];
}

function newUserSalt()
{
    global $words, $TOTAL_SIZE;
    $uSalt = $words[rand(0, $TOTAL_SIZE)] . newSpecial() . date("s");
    return $uSalt;
}
