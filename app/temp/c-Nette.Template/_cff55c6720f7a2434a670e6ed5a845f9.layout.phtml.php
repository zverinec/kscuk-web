<?php //netteCache[01]000235a:2:{s:4:"time";s:21:"0.47939700 1366547232";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:80:"/home/jan/Projekty/fi.muni.cz/K-SCUK/web/www/../app/templates/Forms/layout.phtml";i:2;i:1365920576;}}}?><?php
// file …/templates/Forms/layout.phtml
//

$_cb = LatteMacros::initRuntime($template, true, '52fa71100d'); unset($_extends);


//
// block header
//
if (!function_exists($_cb->blocks['header'][] = '_cbb133e9c05a7_header')) { function _cbb133e9c05a7_header($_args) { extract($_args)
?>
	<link rel="stylesheet" href="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>css/frontend2012.css" type="text/css" media="screen" />
<?php
}}


//
// block body
//
if (!function_exists($_cb->blocks['body'][] = '_cbb338ea21a38_body')) { function _cbb338ea21a38_body($_args) { extract($_args)
?>
	<div class="container-inner2" /><div class="container-inner">
		<?php call_user_func(reset($_cb->blocks['content']), get_defined_vars()) ?>

	</div></div>
<?php
}}


//
// block content
//
if (!function_exists($_cb->blocks['content'][] = '_cbbe1f8666949_content')) { function _cbbe1f8666949_content($_args) { extract($_args)
;
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (SnippetHelper::$outputAllowed) {
$_cb->extends = "../layout.phtml" ?>


<?php
}

if ($_cb->extends) { ob_end_clean(); LatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
