<?php //netteCache[01]000233a:2:{s:4:"time";s:21:"0.25786200 1366529681";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:78:"/home/jan/Projekty/fi.muni.cz/K-SCUK/web/www/../app/templates/Org/detail.phtml";i:2;i:1365920576;}}}?><?php
// file …/templates/Org/detail.phtml
//

$_cb = LatteMacros::initRuntime($template, true, '011a9622c3'); unset($_extends);


//
// block content
//
if (!function_exists($_cb->blocks['content'][] = '_cbb67a61dfdbd_content')) { function _cbb67a61dfdbd_content($_args) { extract($_args)
?>

<?php if (!empty($image)): ?>
	<div id="person-image">
		<img src="<?php echo TemplateHelpers::escapeHtml($baseUri) ;echo TemplateHelpers::escapeHtml($image) ?>" alt="Účastníkova fotka"  />
	</div>
<?php endif ?>

<?php foreach ($iterator = $_cb->its[] = new SmartCachingIterator($questions) as $name => $category): ?>
		<h2><?php echo TemplateHelpers::escapeHtml($categories[$name]) ?></h2>
		<table class="answers-in-category">
<?php foreach ($iterator = $_cb->its[] = new SmartCachingIterator($category) as $question): ?>
			<tr<?php if ($iterator->isEven()): ?> class="even"<?php endif ?>>

			<th><?php echo TemplateHelpers::escapeHtml($question->question) ?></th>
			<td>
<?php if (!empty($people[$question->id_question])): ?>
				<?php echo $template->texy($people[$question->id_question]->answer) ?>

<?php endif ?>
			</td>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>
		</table>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ;
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
