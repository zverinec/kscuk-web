<?php //netteCache[01]000230a:2:{s:4:"time";s:21:"0.20083000 1366529677";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:75:"/home/jan/Projekty/fi.muni.cz/K-SCUK/web/app/components/people/people.phtml";i:2;i:1365920576;}}}?><?php
// file /home/jan/Projekty/fi.muni.cz/K-SCUK/web/app/components/people/people.phtml
//

$_cb = LatteMacros::initRuntime($template, NULL, '2434acaac4'); unset($_extends);

if (SnippetHelper::$outputAllowed) {
if (!empty($people)): ?>
<table id="people" cellspacing="0">
		<tr>
			<th></th>
<?php foreach ($iterator = $_cb->its[] = new SmartCachingIterator($questions) as $question): ?>
			<th>
<?php if (empty($printable)): ?>
					<?php echo TemplateHelpers::escapeHtml(String::truncate($question->question, 15)) ?>

<?php else: ?>
					<?php echo TemplateHelpers::escapeHtml($question->question) ?>

					
<?php endif ?>
			</th>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>
		</tr>
<?php foreach ($iterator = $_cb->its[] = new SmartCachingIterator($people) as $answers): ?>
		<tr<?php if ($iterator->isEven()): ?> class="even"<?php endif ?>>
			<td><a href="<?php echo TemplateHelpers::escapeHtml($presenter->link("Org:detail", array(end($answers)->id_registered))) ?>" class="detail">&nbsp;</a></td>
<?php foreach ($iterator = $_cb->its[] = new SmartCachingIterator($questions) as $question): ?>
				<td>
<?php if (!empty($answers[$question->id_question])): ?>
						<?php echo $template->texy($answers[$question->id_question]->answer) ?>

<?php endif ?>
				</td>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>
		</tr>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>
	</table>
<?php endif ?>

<?php $control->getWidget("questionForm")->render() ;
}
