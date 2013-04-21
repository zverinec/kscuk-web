<?php //netteCache[01]000252a:2:{s:4:"time";s:21:"0.53551200 1366547232";s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:5:"Cache";i:1;s:9:"checkFile";}i:1;s:97:"/home/jan/Projekty/fi.muni.cz/K-SCUK/web/app/components/healthDeclaration/healthDeclaration.phtml";i:2;i:1365920576;}}}?><?php
// file /home/jan/Projekty/fi.muni.cz/K-SCUK/web/app/components/healthDeclaration/healthDeclaration.phtml
//

$_cb = LatteMacros::initRuntime($template, NULL, '98198d7180'); unset($_extends);

if (SnippetHelper::$outputAllowed) {
if (!empty($email)): if ($finished): ?>
		<p>Děkujeme za vyplnění zdravotní deklarace. Níže naleznete odkaz na PDF verzi s Vámi vyplněnými odpověďmi. Vytiskněte si ji a podepsanou doneste na soustředění. V případě, že nevlastníte tiskárnu napište nám.</p>
<?php if (!empty($code)): ?>
			<a href="<?php echo TemplateHelpers::escapeHtml($presenter->link("Forms:filledForm", array($email,$code))) ?>">Stáhnout vyplněnou zdravotní deklaraci</a>
<?php endif ;else: ?>
		<p>Během K-scuku se setkáš s řadou obvyklých i měně běžných aktivit z oblasti sportu, her a pohybu (nejen) v přírodě. Pro tvou bezpečnost je proto důležité, abychom znali tvůj zdravotní stav a mohli program přizpůsobit tvé fyzické kondici a případným zdravotním omezením. Informace uvedené ve Zdravotní deklaraci chápeme jako důvěrné a slouží pouze pro vnitřní potřebu.</p>
<?php $control->getWidget("declaration")->render() ;endif ;else: ?>
	<p>Na některé otázky jsem se již ptali předběžně v přihlášce. Pro účast na akci je ale potřeba vyplnit zdravotní dotazník.</p>
<?php $control->getWidget("mailForm")->render() ;endif ;
}
