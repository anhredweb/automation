<?php
/**
 * @package     FE Credit
 * @subpackage  Automation Testing
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace AcceptanceTester;

use Codeception\Module\WebDriver;
/**
 * Class AdminManagerJoomla3Steps
 *
 * @package  AcceptanceTester
 *
 * @since    1.4
 */
class GeneralSteps extends \AcceptanceTester
{
	/**
	 * Function to login to PEGA UAT Page
	 *
	 * @param  string  $username  Username
	 * @param  string  $password  Password
	 *
	 * @return void
	 */
	public function loginPega($username, $password)
	{
		$I = $this;
		$I->fillField(\GeneralXpathLibrary::$username, $username);
        $I->fillField(\GeneralXpathLibrary::$password, $password);
        $I->click(\GeneralXpathLibrary::$loginButton);
        $I->wait(1);
	}

	/**
     * Function to launch to FECase Manager to Create Application
     *
     * @return  void
     */
	public function launchPortal()
	{
		$I = $this;
		$I->click(\GeneralXpathLibrary::$launchButton);
		$I->waitForElement(\GeneralXpathLibrary::$FECaseManager, 2);
        $I->click(\GeneralXpathLibrary::$FECaseManager);
        $I->wait(2);

        $I->switchToNextTab();
        $I->wait(2);

        $I->click(\GeneralXpathLibrary::$createButton);
        $I->waitForElement(\GeneralXpathLibrary::$CDLApplication, 2);
        $I->click(\GeneralXpathLibrary::$CDLApplication);

        $I->click(\GeneralXpathLibrary::$createButton);
        $I->waitForElement(\GeneralXpathLibrary::$CDLApplication, 2);
        $I->click(\GeneralXpathLibrary::$CDLApplication);
        $I->wait(2);
	}

	/**
	 * Function to init data for Application
	 *
	 * @param  array  $data  Data
	 *
	 * @return void
	 */
	public function initData($data)
	{
		$I = $this;
		$iframeName = $I->grabAttributeFrom(\GeneralXpathLibrary::$iframeEnviroment, 'name');
		$I->switchToIFrame($iframeName);
		$I->wait(1);

		$I->click(\GeneralXpathLibrary::$demoDataInitApp);
		$I->wait(1);

		$I->fillField(\GeneralXpathLibrary::$dealerCode, '');
		$I->wait(1);
		$I->fillField(\GeneralXpathLibrary::$dealerCode, $data['dealer_code']);
		$I->pressKey(\GeneralXpathLibrary::$dealerCode, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
		$I->wait(1);
		$I->click(\GeneralXpathLibrary::$rowDealerCode);
		$I->wait(1);

		$I->fillField(\GeneralXpathLibrary::$posCode, '');
		$I->wait(1);
        $I->fillField(\GeneralXpathLibrary::$posCode, $data['pos_code']);
        $I->wait(1);
        $I->pressKey(\GeneralXpathLibrary::$posCode, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
        $I->wait(1);
        $I->click(\GeneralXpathLibrary::$rowPosCode);
        $I->wait(1);

        $I->selectOption(\GeneralXpathLibrary::$productGroup, array('value' => ''));
        $I->wait(1);
        $I->selectOption(\GeneralXpathLibrary::$productGroup, array('value' => $data['product_group']));
        $I->wait(1);

        $I->fillField(\GeneralXpathLibrary::$productScheme, '');
        $I->wait(1);
        $I->fillField(\GeneralXpathLibrary::$productScheme, $data['product_scheme']);
        $I->wait(1);
        $I->pressKey(\GeneralXpathLibrary::$productScheme, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
        $I->wait(1);
        $I->click(\GeneralXpathLibrary::$rowProductScheme);
        $I->wait(1);

        $I->click(\GeneralXpathLibrary::$createDataInitApp);
        $I->dontSeeElement(\GeneralXpathLibrary::$errorMessageTable);
        $I->wait(2);
	}

	/**
	 * Function to entry short data for Application
	 *
	 * @param  array  $data  Data
	 *
	 * @return void
	 */
	public function shortApplication($data)
	{
		$I = $this;
		$I->fillField(\GeneralXpathLibrary::$firstname, $data['firstname']);
		$I->wait(1);
		$I->fillField(\GeneralXpathLibrary::$lastname, $data['lastname']);
		$I->wait(1);
		$I->selectOption(\GeneralXpathLibrary::$gender, array('value' => $data['gender']));
		$I->wait(2);
		$I->fillField(\GeneralXpathLibrary::$nationalId, $data['national_id']);
		$I->wait(2);
		$I->click(\GeneralXpathLibrary::$dateOfIssue);
		$I->wait(1);
		$I->click(\GeneralXpathLibrary::$todayLink);
		// $I->fillField(\GeneralXpathLibrary::$dateOfIssue, $data['date_of_issue']);
		$I->wait(1);
		$I->fillField(\GeneralXpathLibrary::$dateOfBirth, $data['date_of_birth']);
		$I->wait(2);
		$I->fillField(\GeneralXpathLibrary::$fbNumber, $data['fb_number']);
		$I->wait(2);
		$I->fillField(\GeneralXpathLibrary::$phone, $data['phone']);
		$I->wait(2);
		$I->fillField(\GeneralXpathLibrary::$hometown, $data['hometown']);
		$I->wait(1);
		$I->pressKey(\GeneralXpathLibrary::$hometown, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
		$I->wait(1);
		$I->click(\GeneralXpathLibrary::$rowHometown);
		$I->wait(1);
		$I->click(\GeneralXpathLibrary::$submitShortApp);
		$I->wait(2);
	}
}
