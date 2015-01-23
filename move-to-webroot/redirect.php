<?php 
/**
 * This is a Anax frontcontroller.
 *
 */
// Get environment & autoloader.
require __DIR__.'/config_with_app.php';
$app->theme->configure(ANAX_APP_PATH . 'config/theme.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar.php');
$app->session();
$app->theme->setVariable('title', "Skapa redirect");
// setup db
$di->setShared('db', function() {
    $db = new \Mos\Database\CDatabaseBasic();
    $db->setOptions(require ANAX_APP_PATH . 'config/database_mysql.php');
    $db->connect();
    return $db;
});
// setup pdo
$di->setShared('pdo', function() {
		try {
			$mysql = require ANAX_APP_PATH . 'config/database_mysql.php'; // get connection details array
			$pdo = new PDO($mysql['dsn'], $mysql['username'], $mysql['password'], $mysql['driver_options']);
			return $pdo;
		}
		catch(PDOException $ex) {
			echo $e->getMessage();
		}
});

// setup db-model
$di->set('dbmodel', '\Anax\MVC\CDatabaseModel');
// setup form 
$di->set('form', '\Mos\HTMLForm\CForm');
// redirect 
if(isset($_GET["url"])) {
		$cloak = new \Anax\Cloak\CCloak();
		$cloak->initialize($app->form, $app->pdo);
		$url = htmlspecialchars($_GET["url"]);
		$results = $cloak->goToUrl($url);
}
// add routes
$app->router->add('', function() use ($app) {
	$title = 'Skapa redirect';
	// Create the CCloak service
	$cloak = new \Anax\Cloak\CCloak();
	$cloak->initialize($app->form, $app->pdo);
	// Setup if not already done
	$status = $cloak->isSetup();
	if ($status = false) {
		$cloak->setup();
	}
	// check if set url
	if(!isset($_GET["url"])) {
		$linkContent = $cloak->addCloakedLink();
		$content = $linkContent['form'];
		$content .=  $linkContent['text'];
		$content .= '<a href="redirect.php/setup">Setup plugin</a>';
		$app->views->add('default/page', [
			'content' => $content,
			'title' => $title,
		]);
	}
});

$app->router->add('setup', function() use ($app) {
	$cloak = new \Anax\Cloak\CCloak($app->db, $app->form, $app->dbmodel);
	$cloak-setup();
});
$app->router->handle();
$app->theme->render();