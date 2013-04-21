<?php //netteCache[01]000240a:2:{s:4:"time";s:21:"0.65387200 1366545467";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:85:"/home/jan/Projekty/fi.muni.cz/K-SCUK/web/www/../app/templates/Default/../layout.phtml";i:2;i:1366545466;}}}?><?php
// file …/templates/Default/../layout.phtml
//

$_cb = LatteMacros::initRuntime($template, NULL, '88852dde42'); unset($_extends);


//
// block header
//
if (!function_exists($_cb->blocks['header'][] = '_cbbe6b01f3bd7_header')) { function _cbbe6b01f3bd7_header($_args) { extract($_args)
;
}}


//
// block body
//
if (!function_exists($_cb->blocks['body'][] = '_cbbe35bc75678_body')) { function _cbbe35bc75678_body($_args) { extract($_args)
;
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (SnippetHelper::$outputAllowed) {
?>
<html>
	<head>
		<title>K-SCUK 2012 | Soustředění korespondečních seminářů</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>css/main.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>css/main-print.css" type="text/css" media="print" />
		<?php if (!$_cb->extends) { call_user_func(reset($_cb->blocks['header']), get_defined_vars()); } ?>

	</head>
	<body>
		<div id="page-name">
			<a href="<?php echo TemplateHelpers::escapeHtml($presenter->link("Default:")) ?>"><img src="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>img/logo.png" alt="Logo K-SCUKu" id="logo" /></a>
			<h1><a href="<?php echo TemplateHelpers::escapeHtml($presenter->link("Default:")) ?>">Soustředění pro řešitele seminářů KEKS a KSI</a></h1>
			<?php $wholeName = $presenter->getName().":".$presenter->getAction() ?>
			<?php extract(array("config" => Environment::getConfig('registration'))) ?>

<?php if ($wholeName != "Default:registration" && $presenter->getName() != "Forms" && new DateTime53() >= DateTime53::from($config['start']) && new DateTime53() <= DateTime53::from($config['end'])): ?>
				<div class="sign-up">
					<a href="<?php echo TemplateHelpers::escapeHtml($presenter->link("Default:registration")) ?>">Přihlásit se</a>
				</div>
<?php endif ?>
		</div>
		<div class="cleaner">&nbsp;</div>
		<div id="container"><div class="container-inner">
				<div id="flashes">
<?php foreach ($iterator = $_cb->its[] = new SmartCachingIterator($flashes) as $flash): ?>
					<div class="flash <?php echo TemplateHelpers::escapeHtml($flash->type) ?>">
						<?php echo $flash->message ?>

					</div>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>
				</div>
				<?php if (!$_cb->extends) { call_user_func(reset($_cb->blocks['body']), get_defined_vars()); } ?>

		</div></div>
	</body>
</html>
<?php
}

if ($_cb->extends) { ob_end_clean(); LatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
