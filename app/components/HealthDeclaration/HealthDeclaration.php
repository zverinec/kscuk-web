<?php
namespace App\Components;

use App\Model\Person;
use App\Model\HealthDeclaration AS HealthDeclarationModel;
use App\Utils\Helpers;
use App\Utils\Parameters;
use Exception;
use Nette\Application\UI\Form;
use Nette\Mail\IMailer;
use Nette\Mail\Message;
use Nette\Utils\Html;

class HealthDeclaration extends BaseComponent
{
	/** @var Person */
	private $person;
	/** @var HealthDeclarationModel */
	private $healthDeclaration;
	/** @var Parameters */
	private $parameters;
	/** @var IMailer */
	private $mailer;

	/** @persistent */
	public $email;
	/** @persistent */
	public $finished = false;
	/** @persistent */
	public $code = NULL;

	public function __construct(IMailer $mailer, Person $person, HealthDeclarationModel $healthDeclaration, Parameters $parameters)
	{
		$this->mailer = $mailer;
		$this->person = $person;
		$this->healthDeclaration = $healthDeclaration;
		$this->parameters = $parameters;
	}

	public function beforeRender()
	{
		parent::beforeRender();
		$this->getTemplate()->email = $this->email;
		$this->getTemplate()->finished = $this->finished;
		$this->getTemplate()->code = $this->code;
	}


	public function createComponentMailForm($name)
	{
		$form = new Form($this, $name);
		$group = $form->addGroup("Tvá e-mailová adresa");
		Helpers::makeGroupRequired($group);
		$group->setOption("description", "Použij e-mailovou adresu, kterou jsi zadal(a) v přihlášce.");
		$form->addText("email")
			->setRequired("Zadejte, prosím, svoji e-mailovou adresu.")
			->addRule(Form::EMAIL, "Zadej prosím tvou e-mailovou adresu ve tvaru nekdo@nekde.koncovka.");
		$form->addGroup();
		$form->addSubmit("continue", "Pokračovat");
		$form->onSuccess[] = [$this, 'mailFormSubmitted'];
		Helpers::changeRenderer($form);
		return $form;
	}

	public function mailFormSubmitted(Form $form)
	{
		$values = $form->getValues();
		try {
			$person = $this->person->findByEmail(strtolower($values["email"]));
		} catch (Exception $ex) {
			$form->addError("Se zadanou e-mailovou adresou je technický problém, pravděpodobně jste se přihásili dvakrát. Prosím kontaktujte nás.");
			return;
		}
		if (count($person) == 0) {
			$form->addError("Zadaná e-mailová adresa nebyla přihlášena.");
			return;
		}
		$this->email = strtolower($values["email"]);
	}

	public function createComponentDeclaration($name)
	{
		$person = $this->person->findByEmail($this->email);
		$personName = $this->extractName($person);
		$form = new Form($this, $name);

		$group = $form->addGroup("Kurz");
		$form->addText("course")
			->setDisabled()
			->setValue("K-SCUK");

		$group = $form->addGroup("Jméno a příjmení");
		$form->addText("name")
			->setDisabled()
			->setValue($personName);

		$group = $form->addGroup("Datum narození");
		Helpers::makeGroupRequired($group);
		$form->addText("birth_date")
			->addRule(Form::FILLED, "Vyplň, prosím, své datum narození.");

		$group = $form->addGroup("Praktický lékař");
		Helpers::makeGroupRequired($group);
		$no_gp = $form->addCheckbox("no_gp", "Nemám stálého lékaře");
		$group->setOption("description", Html::el("strong")->setText("Jméno, adresa a telefon tvého lékaře"));
		$gp = $form->addTextArea("gp", NULL, 40, 4);
		$gp->addConditionOn($no_gp, Form::EQUAL, false)
			->addRule(Form::FILLED, "Vyplň, prosím, informace o svém praktickém lékaři.");

		$group = $form->addGroup("Krizový kontakt");
		Helpers::makeGroupRequired($group);
		$group->setOption("description", Html::el("")->setHtml("Koho informovat, kdyby se ti na akci něco stalo (jméno, adresa, telefon)"));
		$form->addTextArea("informing", NULL, 40, 4)
			->setRequired("Vyplň, prosím, informace o podávání zpráv.");

		$group = $form->addGroup("Tvá současná pohybová aktivita");
		Helpers::makeGroupRequired($group);
		$group->setOption("description", Html::el("")->setHtml("Aktivita, jak často, přibližná doba (vzdálenost)"));
		$no_sporting = $form->addCheckbox("no_sporting", "Žádná pohybová aktivita");
		$sporting = $form->addTextArea("sporting", NULL, 40, 4);
		$form->addCheckbox("swimming", "Uplavu bezpečně 100 metrů");
		$sporting->addConditionOn($no_sporting, Form::EQUAL, false)
			->addRule(Form::FILLED, "Vyplň, prosím, informace o své pohybové aktivitě.");

		$group = $form->addGroup("Riziko srdečního onemocnění");
		Helpers::makeGroupRequired($group);
		$questionList[] = "Vysoký krevní tlak (i léčený)";
		$questionList[] = "Kouřím, kouřil/a jsem v posledním roce";
		$questionList[] = "Diabetes mellitus (cukrovka)";
		$questionList[] = "Vysoká hladina cholesterolu nebo tuků v krvi";
		$questionList[] = "Bolesti na hrudi, obtížné dýchání již při malé námaze";
		$questionList[] = "Rodinná historie srdečních onemocnění";
		Helpers::addRadioLists($questionList, $form, "heart");

		$group = $form->addGroup("Léky");
		Helpers::makeGroupRequired($group);
		$group->setOption("description", Html::el("")->setHtml("Uveď i ty, které užíváš nepravidelně, včetně “prášků na spaní”<br />Název léku, jak často a kolik, proč, současné vedlejší účinky"));
		$no_medicine = $form->addCheckbox("no_medicine", "Neužívám žádné léky");
		$medicine = $form->addTextArea("medicine", NULL, 40, 4);
		$medicine->addConditionOn($no_medicine, Form::EQUAL, false)
			->addRule(Form::FILLED, "Vyplň, prosím, informace o používaných lécích.");

		$group = $form->addGroup("Alergie");
		Helpers::makeGroupRequired($group);
		$group->setOption("description", Html::el("")->setHtml("Na jakou látku, jaká reakce, je nutno použít léků? Jakých a jak?"));
		$no_allergy = $form->addCheckbox("no_allergy", "Nevím o žádné alergii");
		$allergy = $form->addTextArea("allergy", NULL, 40, 4);
		$allergy->addConditionOn($no_allergy, Form::EQUAL, false)
			->addRule(Form::FILLED, "Vyplň, prosím, informace o alergiích.");

		$group = $form->addGroup("Zdravotní profil");
		$group->setOption("description", "Pokud se tě některé z těchto kategorií týkají, napiš prosím, podrobnější informace do volného pole níže (příznaky, omezeni ...).");
		Helpers::makeGroupRequired($group);
		$questionList = array();
		$questionList[] = "1. Pobyt v nemocnici, návštěva pohotovosti v posledním roce";
		$questionList[] = "2. Infarkt myokardu, angina pectoris, operace srdce";
		$questionList[] = "3. Jiné srdeční nálezy - vysoký či nízký tlak, porucha rytmu, zánět, šelest‚ …";
		$questionList[] = "4. Astma, bronchitidy, zánět plic, TBC a jiná plicní onemocnění";
		$questionList[] = "5. Problémy či onemocnění páteře a pohybového aparátu";
		$questionList[] = "6. Infekční onemocnění";
		$questionList[] = "7. Křečové stavy";
		$questionList[] = "8. Psychické obtíže (strach z uzavřeného prostoru, výšek, vody atd., jiné neurózy…)";
		$questionList[] = "9. Jste nebo byl/a jste v posledních 2 letech v péči psychologa nebo psychiatra? (kontakt na něj)";
		$questionList[] = "10. Prožil/a jsi v poslední době nějakou závažnou životní událost?";
		$questionList[] = "11. Jiné zdravotní problémy, příznaky, omezení, požadavky";
		$questionList[] = "12. Očkování proti tetanu v posledních 7 letech. ";
		$questionList[] = "13. Těhotenství";
		Helpers::addRadioLists($questionList, $form, "profile");
		$form->addTextArea("profile", NULL, 40, 6);

		/* Food declaration moved to registration in 2018 event.
		$group = $form->addGroup("Stravovací omezení");
		$no_food_problems = $form->addCheckbox("no_food_problems", "Žádná stravovací omezení");
		Helpers::makeGroupRequired($group);
		$food_problems = $form->addTextArea("food_problems", NULL, 40, 4);
		$food_problems->addConditionOn($no_food_problems, Form::EQUAL, false)
			->addRule(Form::FILLED, "Vyplň, prosím, informace o stravovacích omezeních.");
		*/

		$group = $form->addGroup();
		$group->setOption("description", Html::el()->setHtml("Činnosti na kurzu jsou bez výjimky dobrovolné, odevzdání vyplněné a podepsané deklarace je však podmínkou aktivní účasti na jednotlivých programech kurzu. Jestliže se během programu projeví onemocnění, omezení nebo problémy, které jsi ve Zdravotní deklaraci neuvedl/a či uvedl/a nepravdivě, organizátoři K-SCUKu nenesou zodpovědnost za případné zdravotní či jiné poškození.<br /><br /><strong>Potvrzuji, že jsem porozuměl všem výše uvedeným skutečnostem včetně zdravotní problematiky.</strong><br /><br />"));
		$form->addText("signature", "Jméno zákonného zástupce")
			->setOption("description", "Jméno zákonného zástupce vyplň pouze v případě, že je ti méně než 18 let.");
		$group = $form->addGroup();
		$form->addText("date", "Datum")
			->setDisabled()
			->setValue(date("j. n. Y"));
		$form->addGroup();
		$form->addSubmit("submitted", "Potvrzuji a souhlasím");
		$form->onSubmit[] = array($this, "declarationSubmitted");

		Helpers::changeRenderer($form);
		return $form;
	}

	public function extractName($person)
	{
		foreach ($person as $key => $item) {
			if (mb_strpos(mb_strtolower($key), 'jméno a příjmení') !== FALSE) {
				return $item;
			}
		}
	}

	public function declarationSubmitted(Form $form)
	{
		$person = $this->person->findByEmail(strtolower($this->email));
		$personName = $this->extractName($person);
		if (count($person) == 0) {
			$form->addError("Tato e-mailová adresa nenáleží žádné přihlášce.");
			return;
		}
		$hd = $this->healthDeclaration->findByEmail(strtolower($this->email));
		if (count($hd) == 1) {
			$form->addError("Pro tuto e-mailovou adresu již byla vyplněna zdravotní deklarace.");
			return;
		}
		$values = $form->getValues();
		$values["course"] = "K-SCUK";
		$values["email"] = strtolower($this->email);
		$values["name"] = $personName;
		$values["date"] = date("Y-m-d");
		$values["code"] = sha1(rand(10000, 99999999) . time() . "oiekd68J2");
		$hd = $this->healthDeclaration;
		$hd->save($values);
		$this->finished = true;
		$this->code = $values["code"];
		// Send e-mail
		$config = $this->parameters->getAdmin();
		$mail = new Message();
		$mail->setFrom($config->mail);
		$mail->setSubject('KSCUK - zdravotní deklarace k tisku');
		$mail->setEncoding('UTF-8');
		$mail->addTo($config->mail);
		$mail->addTo($values["email"]);
		$template = $this->createTemplate();
		$template->setFile(__DIR__ . '/../../templates/mail/health_declaration.latte');
		$template->link = $this->getPresenter()->link("//Forms:filledForm", $values["email"], $values["code"]);
		$template->getLatte()->addFilter('texy', Helpers::getHelper('texy'));
		$mail->setHtmlBody($template);
		$this->mailer->send($mail);
		// End up
		$this->getPresenter()->flashMessage("Zdravotní deklarace byla úspěšně vyplněna.");
		$this->redirect("this");
	}

}
