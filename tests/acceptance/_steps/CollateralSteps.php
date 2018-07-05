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
class CollateralSteps extends \AcceptanceTester
{
	/**
	 * Function to search application
	 *
	 * @param  string  $applicationId  application ID
	 *
	 * @return void
	 */
	public function switchWorkPool()
	{
		$I = $this;
		$I->wait(2);
		$I->click(\CollateralXpathLibrary::$emailOnTop);
		$I->wait(1);
		$I->moveMouseOver(\GeneralXpathLibrary::$switchWorkPool);
		$I->wait(1);
		$I->click(\GeneralXpathLibrary::$defaultWorkPool);
	}

	/**
	 * Function to search application
	 *
	 * @param  string  $applicationId  application ID
	 *
	 * @return array
	 */
	public function searchColaterral($applicationId)
	{
		$I = $this;
		$I->wait(1);
		$I->fillField(\GeneralXpathLibrary::$searchBox, $applicationId);
		$I->wait(1);
		$I->click(\GeneralXpathLibrary::$searchButton);
		$I->wait(1);
		$I->switchToIFrame('_searchPanel_iframe');
		$I->wait(1);
		$cdlType = $I->grabTextFrom(\CollateralXpathLibrary::$cdlType);

		if (trim($cdlType) != 'Consumer Durable')
		{
			return array();
		}

		$I->wait(1);
		$I->click(\CollateralXpathLibrary::$cdl);
		$I->wait(1);
		$I->switchToIFrame();

		// PEGA System use iframe so need to switch to iframe to access input
		$iframeName = $I->grabAttributeFrom(\CollateralXpathLibrary::$infomationFrame, 'name');
		$I->switchToIFrame($iframeName);
		$I->wait(1);
		$I->click(\CollateralXpathLibrary::$information);
		$I->wait(1);

		$collateralDescription = $I->grabTextFrom(\CollateralXpathLibrary::$collateralDescription);
		$applicationIdSearch   = $I->grabTextFrom(\GeneralXpathLibrary::$applicationId);

		$postData = array();
		$postData['application_id']         = $applicationIdSearch;
		$postData['collateral_description'] = $collateralDescription;
		$postData['result'] = 0;

		if (trim((int) $applicationIdSearch) == trim((int) $applicationId))
		{
			$postData['result'] = 1;
		}

		$I->click(\CollateralXpathLibrary::$closeApplication);

		print_r($postData);

		return $postData;
	}
}
