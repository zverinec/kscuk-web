<?php //netteCache[01]000231a:2:{s:4:"time";s:21:"0.70444400 1366529606";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:76:"/home/jan/Projekty/fi.muni.cz/K-SCUK/web/www/../app/templates/Org/auth.phtml";i:2;i:1365920576;}}}?><?php
// file …/templates/Org/auth.phtml
//

$_cb = LatteMacros::initRuntime($template, true, '9a075112c0'); unset($_extends);


//
// block content
//
if (!function_exists($_cb->blocks['content'][] = '_cbbc2bdebb623_content')) { function _cbbc2bdebb623_content($_args) { extract($_args)
;$control->getWidget("authForm")->render() ;
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (SnippetHelper::$outputAllowed) {
$_cb->extends = "layout.phtml" ?>

<?php
}

if ($_cb->extends) { ob_end_clean(); LatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
