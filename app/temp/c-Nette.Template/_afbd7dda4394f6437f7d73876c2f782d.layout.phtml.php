<?php //netteCache[01]000233a:2:{s:4:"time";s:21:"0.72404100 1366529606";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:78:"/home/jan/Projekty/fi.muni.cz/K-SCUK/web/www/../app/templates/Org/layout.phtml";i:2;i:1365920576;}}}?><?php
// file …/templates/Org/layout.phtml
//

$_cb = LatteMacros::initRuntime($template, true, '4be3b783b1'); unset($_extends);


//
// block header
//
if (!function_exists($_cb->blocks['header'][] = '_cbb64cf1e65be_header')) { function _cbb64cf1e65be_header($_args) { extract($_args)
?>
	<link rel="stylesheet" href="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>css/backend2012.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>css/frontend2012.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>css/backend-print.css" type="text/css" media="print" />
<?php
}}


//
// block body
//
if (!function_exists($_cb->blocks['body'][] = '_cbba2a3935a23_body')) { function _cbba2a3935a23_body($_args) { extract($_args)
;if ($presenter->getAction() != "auth"): ?>
		<ul class="admin-menu">
			<li><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Org:default")) ?>">Seznam účastníků</a></li>
			<li><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Org:reset")) ?>" onclick="return (confirm('Určitě chceš vymazat obsah databáze?'))" >Vymazat databázi</a></li>
			<li class="last"><a href="<?php echo TemplateHelpers::escapeHtml($control->link("Org:logout")) ?>">Odhlásit se</a></li>
		</ul>
<?php endif ?>
	<div class="container-inner2" /><div class="container-inner">
		<?php call_user_func(reset($_cb->blocks['content']), get_defined_vars()) ?>

	</div></div>
<?php
}}


//
// block content
//
if (!function_exists($_cb->blocks['content'][] = '_cbb065f21a772_content')) { function _cbb065f21a772_content($_args) { extract($_args)
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
