<?php //netteCache[01]000246a:2:{s:4:"time";s:21:"0.00840000 1366548629";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:91:"/home/jan/Projekty/fi.muni.cz/K-SCUK/web/www/../app/templates/mail/health_declaration.phtml";i:2;i:1365920576;}}}?><?php
// file …/templates/mail/health_declaration.phtml
//

$_cb = LatteMacros::initRuntime($template, NULL, '0bbb09802d'); unset($_extends);

if (SnippetHelper::$outputAllowed) {
?>
<p>
	Ahoj,
</p>

<p>
	posíláme Vám odkaz na vyplněnou zdravotní deklaraci. Vytiskněte si jej prosím a podepsaný jej přineste na soutředění.<br />
	<a href="<?php echo TemplateHelpers::escapeHtml($link) ?>">Stáhnout vyplněnou zdravotní deklaraci</a>
</p>

<p>
	Díky,<br/>
	KSCUK web
</p><?php
}
