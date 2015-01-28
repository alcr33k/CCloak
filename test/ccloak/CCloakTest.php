<?php
namespace Anax\Cloak;
class CFlashMessageTest extends \PHPUnit_Framework_TestCase
{
	/**
   * Constructor
   *
  */
	public function __construct() { 
		$form = new \Mos\HTMLForm\CForm();
		$mysql = require ANAX_APP_PATH . 'config/database_mysql.php'; 
		$pdo = new \PDO($mysql['dsn'], $mysql['username'], $mysql['password'], $mysql['driver_options']);
		$this->cloak = new \Anax\Cloak\CCloak($form, $pdo);
	}
/**
 * Test that the object has right class
 *
 * @return void
 *
 */
	public function testClass() {
		$res = get_class($$this->cloak);
		$exp = "Anax\Cloak\CCloak";
		$this->assertEquals($res, $exp, "Wrong class");
	}
/**
 * Test the 
 *
 * @return void AddCloakedLink function
 *
 */	
	public function testAddCloakedLink() {
		$this->cloak->addCloakedLink();
		// Test that the form is not emty
		$this->assertNotEmpty($res['form'], "Result of function addCloakedLink is empty");
		// Test that the returned html contains a form tag
		$this->assertContains('<form>', $res['form'], "Result of function addCloakedLink does not contain a form tag");
	}
/**
 * Test to find a url (add link and try to visit it)
 *
 * @return void
 *
 *	
	public function testGoToUrl() {
	}
/**
 * Test the isSetup function
 *
 * @return void
 *
 */	
	public function testIsSetup() {
		// Test for correct aoutput (true/false)
		$this->cloak->isSetup();
		$this->assertContainsOnly('boolean', $res, "Result of function isSetup is not in a valid type");
	}
}