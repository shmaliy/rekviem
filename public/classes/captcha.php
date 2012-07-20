<?php
//session_start();
include('../lib/kcaptcha/kcaptcha.php');
$captcha = new KCAPTCHA();

//if($_REQUEST[session_name()]){
    $GLOBALS['captcha_keystring'] = $captcha->getKeyString();
//}
?>
