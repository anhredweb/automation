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
		$I->switchToIFrame(\GeneralXpathLibrary::$iframeEnviroment);

		$I->fillField(\GeneralXpathLibrary::$dealerCode, $data['dealer_code']);
		$I->pressKey(\GeneralXpathLibrary::$dealerCode, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
		$I->wait(2);
		$I->click(\GeneralXpathLibrary::$rowDealerCode);
		$I->wait(2);

        $I->fillField(\GeneralXpathLibrary::$posCode, $data['pos_code']);
        $I->wait(2);
        $I->pressKey(\GeneralXpathLibrary::$posCode, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
        $I->wait(2);
        $I->click(\GeneralXpathLibrary::$rowPosCode);
        $I->wait(2);

        $I->selectOption(\GeneralXpathLibrary::$productGroup, array('value' => $data['product_group']));
        $I->wait(2);

        $I->fillField(\GeneralXpathLibrary::$productScheme, $data['product_scheme']);
        $I->wait(2);
        $I->pressKey(\GeneralXpathLibrary::$productScheme, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
        $I->wait(2);
        $I->click(\GeneralXpathLibrary::$rowProductScheme);
        $I->wait(1);

        $I->click(\GeneralXpathLibrary::$createDataInitApp);
        $I->dontSeeElement(\GeneralXpathLibrary::$errorMessageTable);
        $I->wait(2);
	}
}
