<?php //netteCache[01]000238a:2:{s:4:"time";s:21:"0.14554400 1366544906";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:83:"/home/jan/Projekty/fi.muni.cz/K-SCUK/web/www/../app/templates/Default/default.phtml";i:2;i:1366544904;}}}?><?php
// file …/templates/Default/default.phtml
//

$_cb = LatteMacros::initRuntime($template, true, '47679fdeae'); unset($_extends);


//
// block content
//
if (!function_exists($_cb->blocks['content'][] = '_cbb7cf6e38697_content')) { function _cbb7cf6e38697_content($_args) { extract($_args)
?>
<link rel="stylesheet" type="text/css" href="/css/jqcloud.css" />
<script type="text/javascript" src="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>js/jqcloud-1.0.3.min.js"></script>
    <script type="text/javascript">
      var word_list = [
        { text: "adrenalin", weight: 1},
	{ text: "běhání", weight: 1},
	{ text: "bláto", weight: 1},
	{ text: "budíček", weight: 2},
	{ text: "déšť", weight: 1},
	{ text: "dílny", weight: 4},
	{ text: "dobrodružství", weight: 5},
	{ text: "ekologové", weight: 6},
	{ text: "frisbee", weight: 3},
	{ text: "hry", weight: 6},
	{ text: "chata", weight: 2},
	{ text: "informatici", weight: 4},
	{ text: "kamarádi", weight: 4},
	{ text: "KEKS", weight: 9},
	{ text: "klid", weight: 1},
	{ text: "korespondenční", weight: 3},
	{ text: "K-SCUK", weight: 10},
	{ text: "KSI", weight: 8},
	{ text: "les", weight: 1},
	{ text: "mlsník", weight: 1},
	{ text: "myšlení", weight: 2},
	{ text: "nadšení", weight: 4},
	{ text: "nápad", weight: 5},
	{ text: "noční", weight: 1},
	{ text: "objevování", weight: 3},
	{ text: "odměna", weight: 1},
	{ text: "odpočinek", weight: 1},
	{ text: "orgové", weight: 1},
	{ text: "polední", weight: 1},
	{ text: "poučení", weight: 2},
	{ text: "program", weight: 4},
	{ text: "přání", weight: 1},
	{ text: "přátelé", weight: 6},
	{ text: "přednášky", weight: 3},
	{ text: "přemýšlení", weight: 2},
	{ text: "příroda", weight: 7},
	{ text: "rozcvičky", weight: 2},
	{ text: "samota", weight: 1},
	{ text: "semináře", weight: 5},
	{ text: "seznámení", weight: 2},
	{ text: "sluníčko", weight: 1},
	{ text: "soutěžení", weight: 2},
	{ text: "strategie", weight: 3},
	{ text: "šerm", weight: 1},
	{ text: "táborák", weight: 2},
	{ text: "taškařice", weight: 2},
	{ text: "teplo", weight: 1},
	{ text: "účastníci", weight: 1},
	{ text: "večerka", weight: 1},
	{ text: "večerníček", weight: 1},
	{ text: "vzdělání", weight: 4},
	{ text: "workshop", weight: 2},
	{ text: "zábava", weight: 3},
	{ text: "závody", weight: 2},
	{ text: "zážitek", weight: 3},
	{ text: "zima", weight: 1},
	{ text: "zkušenost", weight: 1},
	{ text: "zpěv", weight: 2},
	{ text: "zpívání", weight: 1}
      ];
      $(function() {
        $("#tags").jQCloud(word_list);
      });
    </script>
	<div id="about"><div class="inner">
		<h2>O co jde?</h2>

		<p>K-SCUK je společné soustředění pro řešitele seminářů <a href="http://keks.math.muni.cz/">KEKS</a> a <a href="http://ksi.fi.muni.cz/">KSI</a> <a href="http://www.muni.cz">Masarykovy univerzity</a>.
		Na soustředění bude probíhat nejen zajímavý odborný program, ale i nabitý program doprovodný. Odborný program bude částečně dělený mezi informatiku a ekologii, částečně společný. Bude se skládat z přednášek, dílen, diskuzí a alternativních vzdělávacích bloků.</p>

			<p>Pojeďte s námi zažít týden plný dobrodružství, kamarádství a poznání a třeba zjistíte, že všechny žluté kytky nejsou stejné a že informatika je o počítačích asi jako astronomie o dalekohledech a že ekologie není založena na přivazování se řetězy k branám elektráren a že informatik nemusí vždycky nosit prestižky a že ...</p>
	</div></div>
	<div id="showcase-right">
<?php call_user_func(reset($_cb->blocks['wrappertop']), get_defined_vars()) ?>
	</div>
	<div class="cleaner">&nbsp;</div>
	<div id="info"><div class="inner">
		<h2>Základní informace</h2>
		<ul>
			<li><span class="prolog">Termín:</span><span class="answer">7. - 14. září 2012</span></li>
			<li><span class="prolog">Místo:</span><span class="answer"><a href="http://mapy.cz/#x=16.189892&y=49.103284&z=17&t=s&d=user_16.189296%2C49.103268%2CMohelno%2C%20okres%20Třebíč~_1">Mohelenský mlýn</a></span></li>
			<li><span class="prolog">Ubytování:</span><span class="answer">v pevné budově, spaní ve vlastním spacáku na postelích</span></li>
			<li><span class="prolog">Cena:</span><span class="answer">0 Kč</span></li>
			<li><span class="prolog">Kontakt:</span><span class="answer"><a href="mailto:kscuk@fi.muni.cz">kscuk@fi.muni.cz</a><br /></span></li>
		</ul>
		<div class="cleaner">&nbsp;</div>
	</div></div>
	<div id="showcase-left">
		    <div id="tags"></div>		
	</div>
	<div class="cleaner">&nbsp;</div>
<?php
}}


//
// block wrappertop
//
if (!function_exists($_cb->blocks['wrappertop'][] = '_cbb9fde60a00e_wrappertop')) { function _cbb9fde60a00e_wrappertop($_args) { extract($_args)
?>
		<div id="slider">
			<img src="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>img/I.jpg" alt="" title="Láká tě tajemná atmosféra?"/>
			<img src="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>img/A.jpg" alt="" title="Hledáš výzvu?" />
			<img src="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>img/B.jpg" alt="" title="Jsi ale občas na pochybách?" />
			<img src="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>img/C.jpg" alt="" title="Nás se bát nemusíš." />
			<img src="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>img/M.jpg" alt="" title="Místy nasadíme zběsilé tempo, ..." />
			<img src="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>img/E.jpg" alt="" title="..., ale poté se o tebe dobře postaráme." />
			<img src="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>img/K.jpg" alt="" title="Někdy to bude chtít sílu..." />
			<img src="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>img/O.jpg" alt="" title="...a někdy se neobejdeš bez dobrého nápadu." />
			<img src="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>img/G.jpg" alt="" title="Potkáš lidi, které baví život..." />
			<img src="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>img/J.jpg" alt="" title="...a na které se můžeš spolehnout." />
			<img src="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>img/L.jpg" alt="" title="Vysvětlíme ti spoustu zajímavých věcí." />
			<img src="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>img/D.jpg" alt="" title="Necháme tě všechno si pořádně vyzkoušet." />
			<img src="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>img/F.jpg" alt="" title="Možná se u toho pořádně zašpiníš." />
			<img src="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>img/N.jpg" alt="" title="Připoj se k nám!" />
			<img src="<?php echo TemplateHelpers::escapeHtml($baseUri) ?>img/H.jpg" alt="" title="Už se na tebe těšíme..." />
		</div>
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
