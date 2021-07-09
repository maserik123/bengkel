<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// fungsi ini digunakan untuk mengamankan output yang ditampilkan pada data
function secure_echo($str)
{
    echo htmlentities($str, ENT_QUOTES, 'UTF-8');
}
