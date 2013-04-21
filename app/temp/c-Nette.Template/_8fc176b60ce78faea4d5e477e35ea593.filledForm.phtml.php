<?php //netteCache[01]000233a:2:{s:4:"time";s:21:"0.67505600 1366548631";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:78:"/home/jan/Projekty/fi.muni.cz/K-SCUK/web/www/../app/templates/filledForm.phtml";i:2;i:1365920576;}}}?><?php
// file …/templates/filledForm.phtml
//

$_cb = LatteMacros::initRuntime($template, NULL, 'fd2007e889'); unset($_extends);

if (SnippetHelper::$outputAllowed) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
	<head>
		<meta http-equiv="content-Type" content="text/html; charset=UTF-8"/>
		<meta name="content-language" content="cs" />
		<title>Zdravotní deklarace</title>
		<style>
			body {
				font-family: Arial;
				font-size: 1em;
			}
			.cleaner {
				clear: both;
				width: 100%;
				height: 1px;
				text-indent: -10000px;
				overflow: hidden;
			}
			.smaller {
				font-size: 0.9em; 
			}
			p {
				margin-top: 5px;
				margin-bottom: 5px;
			}
		</style>
	</head>
<body>
	<h1 style="text-align: center;">Zdravotní deklarace</h1>
	<p>Během K-scuku se setkáš s řadou obvyklých i měně běžných aktivit z oblasti sportu, her a
pohybu (nejen) v přírodě. Pro tvou bezpečnost je proto důležité, abychom znali tvůj zdravotní
stav a mohli program přizpůsobit tvé fyzické kondici a případným zdravotním omezením.
Informace uvedené ve Zdravotní deklaraci chápeme jako důvěrné a slouží pouze pro vnitřní
potřebu.</p>
	
<p><strong>Kurz:</strong> <?php echo TemplateHelpers::escapeHtml($v["course"]) ?></p>

<div style="border: 1px solid black; padding: 5px;">
	<div style="height: 50px; float: left; width: 400px"><span class="smaller" style="font-style: italic;">Jméno a příjmení:</span><br /><p><?php echo TemplateHelpers::escapeHtml($v["name"]) ?></p></div>
	<div style="font-style: italic; float: left; width: 200px;"><span class="smaller" style="font-style: italic;">Datum narození:</span><br /><p><?php echo TemplateHelpers::escapeHtml($v["birth_date"]) ?></p></div>
	<div class="cleaner">&nbsp;</div>
</div>

<p><em><span style="text-decoration: underline; font-weight: bold;">Vyplňte prosím každou následující otázku slovy či zaškrtnutím.</span> Vyplněnou deklaraci předejte co nejrychleji vedoucímu instruktorovi či zdravotníkovi kurzu, abychom mohli včas reagovat a položit případné doplňující otázky.</em></p>
<div style="border: 1px solid black; padding: 5px;">
	<div style="font-weight: bold; font-style: italic;"><span class="smaller">Jméno, adresa a telefon Vašeho lékaře</span></div>
	<p><?php echo TemplateHelpers::escapeHtml($v["gp"]) ?></p>
	<div><?php if (!$v["no_gp"]): ?>☐<?php else: ?>☑<?php endif ?> <strong>NEMÁM STÁLÉHO LÉKAŘE</strong></div>
</div>

<div style="border: 1px solid black; padding: 5px; margin-top: 20px;">
	<div><span class="smaller"><em><strong>v případě nutnosti podejte zprávu</strong> (jméno, adresa, telefon):</em></span></div>
	<p><?php echo TemplateHelpers::escapeHtml($v["informing"]) ?></p>
</div>

<p style="font-size: 1em; font-weight: bold; margin-top: 20px">VAŠE SOUČASNÁ POHYBOVÁ AKTIVITA</p>
<div style="border: 1px solid black; padding: 5px;">
	<div style="font-weight: bold; font-style: italic;"><span class="smaller">Aktivita, jak často, přibližná doba (vzdálenost)</span></div>
	<p><?php echo TemplateHelpers::escapeHtml($v["sporting"]) ?></p>
	<div style="float: left;"><?php if (!$v["no_sporting"]): ?>☐<?php else: ?>☑<?php endif ?> <strong>ŽÁDNÁ AKTIVITA</strong></div>
	<div style="float: right;"><strong>UPLAVU BEZPEČNĚ 100m</strong> <?php if (!$v["swimming"]): ?>☐<?php else: ?>☑<?php endif ?> ANO </div>
	<div class="cleaner">&nbsp;</div>
</div>

<p style="font-size: 1em; font-weight: bold; margin-top: 20px; text-decoration: underline;">RIZIKO SRDEČNÍHO ONEMOCNĚNÍ</p>
<div><strong><?php if ($v["heart1"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong> Vysoký krevní tlak (i léčený)</div>
<div><strong><?php if ($v["heart2"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong> Kouřím, kouřil/a jsem v posledním roce</div>
<div><strong><?php if ($v["heart3"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong> Diabetes mellitus (cukrovka)</div>
<div><strong><?php if ($v["heart4"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong> Vysoká hladina cholesterolu nebo tuků v krvi</div>
<div><strong><?php if ($v["heart5"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong> Bolesti na hrudi, obtížné dýchání již při malé námaze</div>
<div><strong><?php if ($v["heart6"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong> Rodinná historie srdečních onemocnění</div>

<p style="margin-top: 20px;"><span style="font-size: 1em; font-weight: bold; text-decoration: underline;">LÉKY</span> (uveďte i ty, které užíváte nepravidelně, včetně “prášků na spaní”)</p>
<div style="border: 1px solid black; padding: 5px;">
	<div style="font-style: italic;"><span class="smaller">Název léku, jak často a kolik, proč, současné vedlejší účinky</span></div>
	<p><?php echo TemplateHelpers::escapeHtml($v["medicine"]) ?></p>
	<div><?php if (!$v["no_medicine"]): ?>☐<?php else: ?>☑<?php endif ?> <strong>NEUŽÍVÁM ŽÁDNÉ LÉKY</strong></div>
</div>

<p style="margin-top: 20px;"><span style="font-size: 1em; font-weight: bold; text-decoration: underline;">ALERGIE</span></p>
<div style="border: 1px solid black; padding: 5px;">
	<div style="font-style: italic;"><span class="smaller">Na jakou látku, jaká reakce, je nutno použít léků? jakých a jak?</span></div>
	<p><?php echo TemplateHelpers::escapeHtml($v["allergy"]) ?></p>
	<div><?php if (!$v["no_allergy"]): ?>☐<?php else: ?>☑<?php endif ?> <strong>NEVÍM O ŽÁDNÉ ALERGII</strong></div>
</div>
<p style="margin-top: 20px;"><span style="font-size: 1em; font-weight: bold; text-decoration: underline;">ZDRAVOTNÍ PROFIL</span></p>
<div><strong><?php if ($v["profile1"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong> 1. Pobyt v nemocnici, návštěva pohotovosti v posledním roce</div>
<div><strong><?php if ($v["profile2"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong> 2. Infarkt myokardu, angina pectoris, operace srdce</div>
<div><strong><?php if ($v["profile3"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong> 3. Jiné srdeční nálezy - vysoký či nízký tlak, porucha rytmu, zánět, šelest‚ …</div>
<div><strong><?php if ($v["profile4"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong> 4. Astma, bronchitidy, zánět plic, TBC a jiná plicní onemocnění</div>
<div><strong><?php if ($v["profile5"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong> 5. Problémy či onemocnění páteře a pohybového aparátu</div>
<div><strong><?php if ($v["profile6"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong> 6. Infekční onemocnění</div>
<div><strong><?php if ($v["profile7"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong> 7. Křečové stavy</div>
<div><strong><?php if ($v["profile8"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong> 8. Psychické obtíže (strach z uzavřeného prostoru, výšek, vody atd., jiné neurózy…)</div>
<div><strong><?php if ($v["profile9"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong> 9. Jste nebo byl/a jste v posledních 2 letech v péči psychologa nebo psychiatra? (kontakt na něj)</div>
<div><strong><?php if ($v["profile10"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong> 10. Prožil/a jste v poslední době nějakou závažnou životní událost?</div>
<div><strong><?php if ($v["profile11"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong> 11. Jiné zdravotní problémy, příznaky, omezení, požadavky</div>
<div><strong><?php if ($v["profile12"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong> 12. Očkování proti tetanu v posledních 7 letech. </div>
<div><strong><?php if ($v["profile13"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong> 13. Těhotenství</div>

<p><span class="smaller"><em>Pokud se Vás některé z těchto kategorií týkají, napište prosím, podrobnější informace (příznaky, omezeni ...).</em></span></p>
<div style="border: 1px solid black; padding: 5px;">
	<p><?php echo TemplateHelpers::escapeHtml($v["profile"]) ?></p>
</div>

<p style="margin-top: 20px;"><span style="font-size: 1em; font-weight: bold; text-decoration: underline;"><p style="margin-top: 20px;"><span style="font-size: 1em; font-weight: bold; text-decoration: underline;">STRAVOVACÍ OMEZENÍ</span></p>
<div><strong><?php if (!$v["no_food_problems"]): ?>☐ NE&nbsp;&nbsp;☑ ANO<?php else: ?>☑ NE&nbsp;&nbsp;☐ ANO<?php endif ?></strong></div>		
<div style="border: 1px solid black; padding: 5px;">
	<p><?php echo TemplateHelpers::escapeHtml($v["food_problems"]) ?></p>
</div>

<p><br /><br /><br /><span class="smaller"><em>Činnosti na kurzu jsou bez výjimky dobrovolné, odevzdání vyplněné a podepsané deklarace je však podmínkou aktivní účasti na jednotlivých programech kurzu. Jestliže se během programu projeví onemocnění, omezení nebo problémy, které jste ve Zdravotní deklaraci neuvedl/a či uvedl/a nepravdivě, organizátoři K-scuku nenesou zodpovědnost za případ­né zdravotní či jiné poškození.</em></p>

<div style="border: 1px solid black; padding: 5px;">
	<div style="font-style: italic; font-weight: bold; text-align: center; height: 25px;"><span>Potvrzuji, že jsem porozuměl všem výše uvedeným skutečnostem včetně zdravotní problematiky.</span></div>
	<div style="float: left;"><strong><em>Datum:</em></strong> <?php echo TemplateHelpers::escapeHtml($template->date($v["date"], "%e. %l. %Y")) ?></div>
	<div style="float: right; height: 40px;"><em><strong>Podpis</strong> (podpis zákonného zástupce):</em>  <?php echo TemplateHelpers::escapeHtml($v["signature"]) ?></div>
	<div class="cleaner">&nbsp;</div>
</div>
		
</body>
</html><?php
}
