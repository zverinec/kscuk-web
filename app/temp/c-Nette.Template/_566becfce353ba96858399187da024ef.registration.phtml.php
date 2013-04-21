<?php //netteCache[01]000240a:2:{s:4:"time";s:21:"0.28490200 1366529595";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:85:"/home/jan/Projekty/fi.muni.cz/K-SCUK/web/www/../app/templates/mail/registration.phtml";i:2;i:1365920576;}}}?><?php
// file …/templates/mail/registration.phtml
//

$_cb = LatteMacros::initRuntime($template, NULL, 'c62b088d15'); unset($_extends);

if (SnippetHelper::$outputAllowed) {
?>
<p>
	Ahoj,
</p>

<p>
	na KSCUK se zaregistroval účastník a bylo by dobré mu poslat nějaké další informace.
</p>

<p>
	S pozdravem,<br/>
	KSCUK web
</p>

<hr />

<?php foreach ($iterator = $_cb->its[] = new SmartCachingIterator($questions) as $question): ?>
	<h3><?php echo TemplateHelpers::escapeHtml($question->question) ?></h3>
<?php if (!empty($answers[$question->id_question])): ?>
		<?php echo $template->texy($answers[$question->id_question]->answer) ?>

<?php endif ;endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ;
}
