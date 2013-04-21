<?php //netteCache[01]000241a:2:{s:4:"time";s:21:"0.01832700 1366528342";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:86:"/home/jan/Projekty/fi.muni.cz/K-SCUK/web/www/../app/templates/Default/layout2012.phtml";i:2;i:1365920576;}}}?><?php
// file …/templates/Default/layout2012.phtml
//

$_cb = LatteMacros::initRuntime($template, true, 'f96c6c0ef1'); unset($_extends);


//
// block header
//
if (!function_exists($_cb->blocks['header'][] = '_cbb3d271c5114_header')) { function _cbb3d271c5114_header($_args) { extract($_args)
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
if (!function_exists($_cb->blocks['body'][] = '_cbbfa17063ae0_body')) { function _cbbfa17063ae0_body($_args) { extract($_args)
?>
	<?php call_user_func(reset($_cb->blocks['content']), get_defined_vars()) ?>

<?php
}}


//
// block content
//
if (!function_exists($_cb->blocks['content'][] = '_cbb165aaec74e_content')) { function _cbb165aaec74e_content($_args) { extract($_args)
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
