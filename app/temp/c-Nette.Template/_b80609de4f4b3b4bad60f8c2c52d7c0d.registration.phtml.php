<?php //netteCache[01]000243a:2:{s:4:"time";s:21:"0.67861300 1366545271";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:88:"/home/jan/Projekty/fi.muni.cz/K-SCUK/web/www/../app/templates/Default/registration.phtml";i:2;i:1366545270;}}}?><?php
// file …/templates/Default/registration.phtml
//

$_cb = LatteMacros::initRuntime($template, true, 'cfc09dc1fc'); unset($_extends);


//
// block content
//
if (!function_exists($_cb->blocks['content'][] = '_cbb64cc23357d_content')) { function _cbb64cc23357d_content($_args) { extract($_args)
?>
	<div class="container-inner2" /><div class="container-inner">
		<h2>Registrace</h2>

		<p>Vyplňte dotazník s údaji, které potřebujeme vědět před konáním K-SCUKu. Použijeme je výhradně pro organizaci, abychom ti mohli poslat další (nezbytné) informace.</p>

<?php extract(array("config" => Environment::getConfig('registration'))) ;if (new DateTime53() < DateTime53::from($config['start'])): ?>
			<p><strong>Registrace účastníků ještě nezačala</strong></p>
<?php elseif (new DateTime53() > DateTime53::from($config['end'])): ?>
			<p><strong>Registrace účastníků již skončila</strong></p>
<?php else: $control->getWidget("registration")->render() ;endif ?>
	</div></div>
<?php
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (SnippetHelper::$outputAllowed) {
$_cb->extends = "layout-empty.phtml" ?>

<?php
}

if ($_cb->extends) { ob_end_clean(); LatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
