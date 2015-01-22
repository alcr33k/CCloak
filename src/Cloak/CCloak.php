<?php
namespace Anax\Cloak;
/**
 * Class for effective link cloaking.
 *
 * @author Alexander Björkenhall, alex.alle@hotmail.com
 * @copyright Alexander Björkenhall 2015
 * @link https://github.com/alcr33k/****
 */
 class CCloak implements \Anax\DI\IInjectionAware {
	use \Anax\DI\TInjectable;
	/**
   * Constructor
   *
   * @param $db is the databse-class set in index.php.
   */
	public function initialize($form, $pdo) { 
		$this->form = $form;
		$this->pdo = $pdo;
	}
	/**
	 * Setup the redirect-table.
	 *
	 * @return void
	 */
	public function setup() {
		$sql = 'DROP TABLE IF EXISTS redirects;
		CREATE TABLE redirects
		(
			cloakUrl varchar(200) NOT NULL PRIMARY KEY,
			actualUrl varchar(200) NOT NULL
		);';
		$this->pdo->exec($sql);
		header("Location: redirect.php");
	}
	/**
	 * Add new cloaked link.
	 *
	 * @return void
	*/
	public function addCloakedLink() {
		$form = $this->form;
		$form = $form->create([], [
			'url' => [
				'type' => 'text',
				'label' => 'Full URL to link: (ex "https://www.google.com") ',
				'required' => true,
				'validation' => ['not_empty'],
			],
			'cloakURL' => [
				'type' => 'text',
				'label' => 'Link on site: (ex "site" creates the url yoursite.com/site) ',
				'required' => true,
				'validation' => ['not_empty'],
			],
			'submit' => [
				'type' => 'submit',
				'callback'  => function($form) {
					$stmt = $this->pdo->prepare("INSERT IGNORE INTO redirects (cloakUrl, actualUrl) VALUES (? ,?)");
					$url = $form->Value('url');
					$cloakUrl = $form->Value('cloakURL');
					$stmt->bindParam(1, $cloakUrl);
					$stmt->bindParam(2, $url);
					$stmt->execute();
					return true;
				}
			],
		]);
		$status = $form->check();
		$text = null;
		if($status === true) { /// sucessfully submitted
			$text .= "The new link was sucessfully submitted.";
		}
		else if ($status === false) {
			$text .= "The link could not be added.";
		}
		$results = array(
			"form" => $form->getHTML(),
			"text" => $text,
		);
		return $results;
	}
	/**
	 * Cloak the link.
	 *
	 * @return the cloaked url
	 */
	public function goToUrl($cloakedURL) {
		$stmt = $this->pdo->prepare("SELECT * FROM redirects WHERE cloakUrl = ?");
		$stmt->bindParam(1, $cloakedURL);
		$stmt->execute();
		$result = $stmt->fetch(\PDO::FETCH_ASSOC);
		if($stmt->rowCount()<0) { 
			header("Location: ../redirect.php");
			exit();
		}
		else {
			header("Location: " .$result['actualUrl']);
			exit();
		}
	}
	public function isSetup() {
		$results = $this->pdo->query("show tables like 'redirect'");
		if($results->rowCount()>0) {
			return true;
		}
		else {
			return false;
		}
	}
 }