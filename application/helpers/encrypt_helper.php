<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


function generateRandomString($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
// function encrypt($param){
// 	$id=$param*39+54;
// 	return $id;
// }
// function decrypt($param){
// 	$id=($param-54)/39;
// 	return $id;
// }

function encrypt($text)
{
    $text = $text * 109312456778;
    $rand = getuniqueChar();
    $out = "";
    $text .= ""; //$text.$dd[1];
    for ($i = 0; $i < strlen($text); $i++) {
        # code...
        $idx = $text[$i];
        $out .= $rand[$idx];
    }
    return $out;
}

function decrypt($text)
{
    $rand = getuniqueChar();
    $out = "";
    for ($i = 0; $i < strlen($text); $i++) {
        # code...
        $idx = $text[$i];
        $tmp = "-1";
        for ($j = 0; $j < count($rand); $j++) {
            # code...
            if ($idx == $rand[$j]) {
                $tmp = $j;
            }
        }
        $out .= $tmp;
        if ($tmp == "-1") {
            $out = "0";
            break;
        }
    }
    if ($out <> "0") {
        $end = strlen($out) - 2;
        //$out=substr($out, 1,$end);
        $out = $out / 109312456778;
        $tmp1 = intval($out);
        if ($out <> $tmp1) {
            $out = 0;
        }
    }
    return $out;
}

function getuniqueChar()
{
    $uniqueChar = array("a", "0", "i", "1", "u", "2", "e", "3", "o", "4");
    return  $uniqueChar;
}
function jsAlert($msg)
{
    echo "<script>alert('$msg')</script>";
}
