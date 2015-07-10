<?php
    $file = file_get_contents('v.txt');
    // $words = preg_split("#\r?\n#", $file, -1, PREG_SPLIT_NO_EMPTY);

    #Added to escape metacharacters as mentioned by @ridgerunner

function strpos_r($haystack, $needle)
{
    $seeks = array();
    while($seek = strrpos($haystack, $needle))
    {
        array_push($seeks, $seek);
        $haystack = substr($haystack, 0, $seek);
    }
    return $seeks;
}
echo "<br>'php' :";
var_dump(strpos_r($file, "<?php"));

echo "<br><br><hr>";
echo "<br>'?>' :";
var_dump(strpos_r($file, "?>"));

echo "<br><br><hr>";
echo "<br>'<=?' :";
var_dump(strpos_r($file, "<? "));



?>