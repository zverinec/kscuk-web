<?php //netteCache[01]000243a:2:{s:4:"time";s:21:"0.25826800 1366543302";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:88:"/home/jan/Projekty/fi.muni.cz/K-SCUK/web/www/../app/templates/Default/layout-empty.phtml";i:2;i:1365920576;}}}?><?php
// file …/templates/Default/layout-empty.phtml
//

$_cb = LatteMacros::initRuntime($template, true, 'e97734ee74'); unset($_extends);


//
// block header
//
if (!function_exists($_cb->blocks['header'][] = '_cbb21b31c4c18_header')) { function _cbb21b31c4c18_header($_args) { extract($_args)
?>
<script src="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>js/jquery.nivo.slider.pack.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>css/frontend2012.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>css/nivo-slider.css" type="text/css" media="screen" />
<script type="text/javascript">
	$(window).load(function() {
		$('#slider').nivoSlider({
			effect:'fade',
			pauseTime:3000,
			captionOpacity:1,
			directionNav:true,
			controlNav:false
		});
	});
</script>
<?php
}}


//
// block body
//
if (!function_exists($_cb->blocks['body'][] = '_cbbdce7abd8a4_body')) { function _cbbdce7abd8a4_body($_args) { extract($_args)
?>
	<?php call_user_func(reset($_cb->blocks['content']), get_defined_vars()) ?>

<?php
}}


//
// block content
//
if (!function_exists($_cb->blocks['content'][] = '_cbbc0b28ece31_content')) { function _cbbc0b28ece31_content($_args) { extract($_args)
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
