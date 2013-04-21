<?php //netteCache[01]000234a:2:{s:4:"time";s:21:"0.11837900 1366529677";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:79:"/home/jan/Projekty/fi.muni.cz/K-SCUK/web/www/../app/templates/Org/default.phtml";i:2;i:1365920576;}}}?><?php
// file …/templates/Org/default.phtml
//

$_cb = LatteMacros::initRuntime($template, true, '315d7841da'); unset($_extends);


//
// block content
//
if (!function_exists($_cb->blocks['content'][] = '_cbb8623c305e1_content')) { function _cbb8623c305e1_content($_args) { extract($_args)
?>
	<h1>Administrace</h1>
	<h2>Seznam účastníků</h2>
<?php $control->getWidget("people")->render() ;
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
