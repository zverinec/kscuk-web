<?php //netteCache[01]000246a:2:{s:4:"time";s:21:"0.46561400 1366547232";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:91:"/home/jan/Projekty/fi.muni.cz/K-SCUK/web/www/../app/templates/Forms/healthDeclaration.phtml";i:2;i:1365920576;}}}?><?php
// file …/templates/Forms/healthDeclaration.phtml
//

$_cb = LatteMacros::initRuntime($template, true, 'b2584276b8'); unset($_extends);


//
// block content
//
if (!function_exists($_cb->blocks['content'][] = '_cbb664f786014_content')) { function _cbb664f786014_content($_args) { extract($_args)
?>
	<h1>Zdravotní deklarace</h1>
<?php $control->getWidget("healthDeclaration")->render() ;
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
