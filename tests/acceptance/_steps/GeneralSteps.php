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
	}

	/**
     * Function to launch to FECase Manager to Create Application
     *
     * @return  void
     */
	public function launchPortal()
	{
		$I = $this;
		$I->wait(1);
		$I->click(\GeneralXpathLibrary::$launchButton);
		$I->waitForElement(\GeneralXpathLibrary::$FECaseManager, 2);
        $I->click(\GeneralXpathLibrary::$FECaseManager);
        $I->wait(2);

        $I->switchToNextTab();
        $I->wait(2);

        /*$I->click(\GeneralXpathLibrary::$createButton);
        $I->waitForElement(\GeneralXpathLibrary::$CDLApplication, 2);
        $I->click(\GeneralXpathLibrary::$CDLApplication);*/

        $I->executeJS('window.scrollTo(0,0)');

        $I->click(\GeneralXpathLibrary::$createButton);
        $I->waitForElement(\GeneralXpathLibrary::$CDLApplication, 2);
        $I->click(\GeneralXpathLibrary::$CDLApplication);
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
		$I->wait(2);

		// PEGA System use iframe so need to switch to iframe to access input
		$iframeName = $I->grabAttributeFrom(\GeneralXpathLibrary::$iframeEnviroment, 'name');
		$I->switchToIFrame($iframeName);
		$I->wait(1);

		// Click demo data
		$I->click(\GeneralXpathLibrary::$demoDataInitApp);
		$I->wait(1);

		// Fill dealer code
		$I->fillField(\GeneralXpathLibrary::$dealerCode, '');
		$I->wait(1);
		$I->fillField(\GeneralXpathLibrary::$dealerCode, $data['dealer_code']);
		$I->pressKey(\GeneralXpathLibrary::$dealerCode, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
		$I->wait(1);
		$I->click(\GeneralXpathLibrary::$rowDealerCode);
		$I->wait(1);

		// Fill POS code
		$I->fillField(\GeneralXpathLibrary::$posCode, '');
		$I->wait(1);
        $I->fillField(\GeneralXpathLibrary::$posCode, $data['pos_code']);
        $I->wait(1);
        $I->pressKey(\GeneralXpathLibrary::$posCode, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
        $I->wait(1);
        $I->click(\GeneralXpathLibrary::$rowPosCode);
        $I->wait(1);

        // Select product group
        $I->selectOption(\GeneralXpathLibrary::$productGroup, array('value' => ''));
        $I->wait(1);
        $I->selectOption(\GeneralXpathLibrary::$productGroup, array('value' => $data['product_group']));
        $I->wait(1);

        // Fill product scheme
        $I->fillField(\GeneralXpathLibrary::$productScheme, '');
        $I->wait(1);
        $I->fillField(\GeneralXpathLibrary::$productScheme, $data['product_scheme']);
        $I->wait(1);
        $I->pressKey(\GeneralXpathLibrary::$productScheme, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
        $I->wait(1);
        $I->click(\GeneralXpathLibrary::$rowProductScheme);
        $I->wait(1);

        // Click create data
        $I->click(\GeneralXpathLibrary::$createDataInitApp);

        // Check error messages
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
		$I->wait(3);

		// Fill firstname
		$I->fillField(\GeneralXpathLibrary::$firstname, 'Firstname');
		$I->wait(2);

		// Fill lastname
		$I->fillField(\GeneralXpathLibrary::$lastname, 'Lastname');
		$I->wait(2);

		// Select gender
		$I->selectOption(\GeneralXpathLibrary::$gender, array('value' => $data['gender']));
		$I->wait(2);

		// Fill national Id
		$I->fillField(\GeneralXpathLibrary::$nationalId, $data['national_id']);
		$I->wait(2);

		// Fill date of issue
		$I->click(\GeneralXpathLibrary::$dateOfIssue);
		$I->wait(2);
		$I->click(\GeneralXpathLibrary::$todayLink);
		// $I->fillField(\GeneralXpathLibrary::$dateOfIssue, $data['date_of_issue']);
		$I->wait(2);

		// Fill date of birth
		$I->fillField(\GeneralXpathLibrary::$dateOfBirth, $data['date_of_birth']);
		$I->wait(2);

		// Fill family book number
		$I->fillField(\GeneralXpathLibrary::$fbNumber, $data['fb_number']);
		$I->wait(2);

		// Fill phone
		$I->fillField(\GeneralXpathLibrary::$phone, $data['phone']);
		$I->wait(2);

		// Fill hometown
		
		if (!empty($data['hometown']))
		{
			$I->fillField(\GeneralXpathLibrary::$hometown, $data['hometown']);
			$I->wait(2);
			$I->pressKey(\GeneralXpathLibrary::$hometown, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
			$I->wait(1);
			$I->click(\GeneralXpathLibrary::$rowHometown);
			$I->wait(2);
		}

		// Click submit data
		$I->click(\GeneralXpathLibrary::$submitShortApp);
		$I->wait(2);
	}

	/**
	 * Function to check documents for Application
	 *
	 * @return void
	 */
	public function shortApplicationDocument()
	{
		$I = $this;

		// Click demo data
		$I->wait(2);
		$I->click(\GeneralXpathLibrary::$demoDataDocument);
		$I->wait(1);

		// Click submit data
		$I->click(\GeneralXpathLibrary::$submitDocument);
		$I->wait(2);
	}

	/**
	 * Function to entry full data for Application
	 *
	 * @param  array  $data  Data
	 *
	 * @return void
	 */
	public function fullDataEntry($data)
	{
		$I = $this;

		// Goods Tab
		$I->wait(2);

		// Click demo data
		$I->click(\GeneralXpathLibrary::$demoDataFullDataEntry);
		$I->wait(2);
		$I->click(\GeneralXpathLibrary::$demoDataG11FullDataEntry);
		$I->wait(2);

		// Click first good row
		$I->click(\GeneralXpathLibrary::$rowGoodData);
		$I->wait(2);

		if (!empty($data['good_type']))
		{
			// Fill good type
			$I->fillField(\GeneralXpathLibrary::$goodType, '');
			$I->wait(1);
			$I->fillField(\GeneralXpathLibrary::$goodType, $data['good_type']);
			$I->wait(2);
			$I->pressKey(\GeneralXpathLibrary::$goodType, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowGoodType);
			$I->wait(2);

			// Fill good brand
			$I->fillField(\GeneralXpathLibrary::$brand, '');
			$I->wait(1);
			$I->fillField(\GeneralXpathLibrary::$brand, $data['brand']);
			$I->wait(2);
			$I->pressKey(\GeneralXpathLibrary::$brand, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowBrand);
			$I->wait(1);

			// Fill asset make
			$I->fillField(\GeneralXpathLibrary::$assetMake, '');
			$I->wait(1);
			$I->fillField(\GeneralXpathLibrary::$assetMake, $data['asset_make']);
			$I->wait(2);
			$I->pressKey(\GeneralXpathLibrary::$assetMake, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowAssetMake);
			$I->wait(1);

			// Fill asset model
			$I->fillField(\GeneralXpathLibrary::$assetModel, '');
			$I->wait(1);
			$I->fillField(\GeneralXpathLibrary::$assetModel, $data['asset_model']);
			$I->wait(2);
			$I->pressKey(\GeneralXpathLibrary::$assetModel, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowAssetModel);
			$I->wait(2);
		}

		// Fill good price
		$I->fillField(\GeneralXpathLibrary::$goodPrice, $data['good_price']);
		$I->wait(2);

		// Fill collateral description
		$I->fillField(\GeneralXpathLibrary::$collateralDescription, $data['collateral_description']);
		$I->wait(2);
		$I->click(\GeneralXpathLibrary::$collateralDescription);
		$I->wait(2);

		// Click save button
		$I->click(\GeneralXpathLibrary::$saveGoodButton);
		$I->wait(2);

		// Loan Tab
		$I->click(\GeneralXpathLibrary::getTabId('3'));
		$I->wait(2);

		if (!empty($data['down_payment']))
		{
			$I->click(\GeneralXpathLibrary::$downPayment);
			$I->wait(2);
			$I->fillField(\GeneralXpathLibrary::$downPayment, '');
			$I->wait(2);
			$I->fillField(\GeneralXpathLibrary::$downPayment, (float) $data['down_payment']);
		}

		if (!empty($data['tenor']))
		{
				$I->click(\GeneralXpathLibrary::$tenor);
				$I->wait(2);
				$I->fillField(\GeneralXpathLibrary::$tenor, '');
				$I->wait(2);
				$I->fillField(\GeneralXpathLibrary::$tenor, (int) $data['tenor']);
		}
		
		$I->wait(2);

		//Customer Tab
		$I->click(\GeneralXpathLibrary::getTabId('4'));
		$I->wait(2);

		// Check/Uncheck FB Owner
		if (!empty($data['is_fb_owner']) && $data['is_fb_owner'] == 'Y')
		{
			$I->wait(2);
			$I->checkOption(\GeneralXpathLibrary::$isFbOwner);	
		}
		else
		{
			$I->wait(2);
			$I->uncheckOption(\GeneralXpathLibrary::$isFbOwner);	
		}

		// Select education
		if (isset($data['education']))
		{
			$I->wait(2);
			$I->selectOption(\GeneralXpathLibrary::$education, array('value' => $data['education']));
		}

		// Select marital status
		if (isset($data['marital_status']))
		{
			$I->wait(2);
			$I->selectOption(\GeneralXpathLibrary::$maritalStatus, array('value' => $data['marital_status']));
		}

		// Select social status
		if (isset($data['social_status']))
		{
			$I->wait(2);
			$I->selectOption(\GeneralXpathLibrary::$socialStatus, array('value' => $data['social_status']));
		}
		
		$I->wait(2);

		// Family Tab
		$I->click(\GeneralXpathLibrary::getTabId('5'));
		$I->wait(2);
		$nationalId = (int) date('YmdHi');

		if (!empty($data['is_fb_owner']) && $data['is_fb_owner'] == 'N')
		{
			$I->fillField(\GeneralXpathLibrary::$fbOwnerFirstname, 'FBFirstname');
			$I->wait(2);
			$I->fillField(\GeneralXpathLibrary::$fbOwnerLastname, 'FBLastname');
			$I->wait(2);
			$I->selectOption(\GeneralXpathLibrary::$fbOwnerRelationType, array('value' => "O"));
			$I->wait(2);
			$I->fillField(\GeneralXpathLibrary::$fbOwnerNationalId, $nationalId + 1);
			$I->wait(2);
		}

		if ($data['marital_status'] == 'M' || $data['marital_status'] == 'C')
		{
			$I->fillField(\GeneralXpathLibrary::$spouseLastname, 'SpFirstname');
			$I->wait(2);
			$I->fillField(\GeneralXpathLibrary::$spouseFirstname, 'SpLastname');
			$I->wait(2);
			$spouseGender = $data['gender'] == 'M' ? 'F' : 'M';
			$I->selectOption(\GeneralXpathLibrary::$spouseGender, array('value' => $spouseGender));
			$I->wait(2);
			$I->fillField(\GeneralXpathLibrary::$spouseNationalId, $nationalId + 2);
			$I->wait(2);
			$I->fillField(\GeneralXpathLibrary::$spouseRelationPeriod, 2);
			$I->wait(2);
		}

		// Income Tab
		$I->click(\GeneralXpathLibrary::getTabId('8'));
		$I->wait(2);

		if (!empty($data['personal_income']))
		{
			// Fill personal income
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowMainIncome);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$personalIncome);
			$I->wait(2);
			$I->executeJS('return jQuery("input#NetAmount1").attr("data-value", "' . $data["personal_income"] . '")');
			$I->executeJS('return jQuery("input#NetAmount1").val("' . $data["personal_income"] . '")');
			$I->click(\GeneralXpathLibrary::getTabId('8'));

			// Fill family income
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowFamilyIncome);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$familyIncome);
			$I->wait(2);
			$I->executeJS('return jQuery("input#NetAmount2").attr("data-value", "' . $data["family_income"] . '")');
			$I->executeJS('return jQuery("input#NetAmount2").val("' . $data["family_income"] . '")');
			$I->click(\GeneralXpathLibrary::getTabId('8'));
		}

		$I->wait(2);

		// Reference Tab
		$I->click(\GeneralXpathLibrary::getTabId('9'));
		$I->wait(2);

		if (!empty($data['phone_reference1']))
		{
			// Fill phone reference 1
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowPhoneReference1);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowMobile1);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$phoneReference1);
			$I->wait(2);
			$I->executeJS('return jQuery("input#CommunicationString1").val("' . $data["phone_reference1"] . '")');
			$I->click(\GeneralXpathLibrary::getTabId('9'));
		}

		if (!empty($data['phone_reference2']))
		{
			// Fill phone reference 2
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowPhoneReference2);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowMobile2);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$phoneReference1);
			$I->wait(2);
			$I->executeJS('return jQuery("input#CommunicationString1").val("' . $data["phone_reference2"] . '")');
			$I->click(\GeneralXpathLibrary::getTabId('9'));
		}

		$I->wait(2);

		// Click submit data
		$I->click(\GeneralXpathLibrary::$submitFullDataEntry);
		$I->wait(2);

		// Check error messages
		$I->dontSeeElement(\GeneralXpathLibrary::$errorMessageTable);
        $I->wait(2);
	}

	/**
	 * Function to data check for Application
	 *
	 * @return string
	 */
	public function dataCheck()
	{
		$I = $this;

		// Click Data check
		$I->click(\GeneralXpathLibrary::$dataCheck);
		$I->wait(2);

		// Select verification result
		$I->selectOption(\GeneralXpathLibrary::$verificationResult, array('value' => 'Positive'));
		$I->wait(2);

		// Click documents tab and demo data
		$I->click(\GeneralXpathLibrary::$documentsTab);
		$I->click(\GeneralXpathLibrary::$demoDataDataCheck);
		$I->wait(2);

		// Click CIC tab and select CIC result
		$I->click(\GeneralXpathLibrary::$cicTab);
		$I->selectOption(\GeneralXpathLibrary::$cicResult, array("value" => "Don't require"));
		$I->wait(2);

		// Click submit data
		$I->click(\GeneralXpathLibrary::$submitDataCheck);
		$I->wait(2);
		$I->click(\GeneralXpathLibrary::$okDataCheck);
		$I->wait(2);

		$caseId = $I->grabTextFrom(\GeneralXpathLibrary::$caseId);
		$caseId = str_replace('(', '', $caseId);
		$caseId = str_replace(')', '', $caseId);

		return $caseId;
	}

	/**
	 * Function to log off Pega
	 *
	 * @return void
	 */
	public function switchApplication()
	{
		$I = $this;
		$I->switchToPreviousTab();
		$I->wait(1);
		$I->click(\GeneralXpathLibrary::$roleMenu);
		$I->wait(2);
		$I->moveMouseOver(\GeneralXpathLibrary::$switchApplication);
		$I->wait(1);
		$I->click(\GeneralXpathLibrary::$riskAdmin);
		$I->wait(2);
		$I->click(\GeneralXpathLibrary::$launchButton);
		$I->wait(2);
        $I->click(\GeneralXpathLibrary::$FECaseManager);
        $I->wait(1);
		$I->switchToNextTab();
		$I->wait(2);
	}

	/**
	 * Function to search application
	 *
	 * @param  string  $caseId  Case ID
	 *
	 * @return void
	 */
	public function searchApplication($caseId)
	{
		$I = $this;
		$I->wait(5);
		$I->click(\GeneralXpathLibrary::$emailOnTop2);
		$I->wait(1);
		$I->moveMouseOver(\GeneralXpathLibrary::$switchWorkPool);
		$I->wait(1);
		$I->click(\GeneralXpathLibrary::$defaultWorkPool);
		$I->wait(2);
		$I->fillField(\GeneralXpathLibrary::$searchBox, $caseId);
		$I->wait(1);
		$I->click(\GeneralXpathLibrary::$searchButton);
		$I->wait(2);

		// PEGA System use iframe so need to switch to iframe to access input
		$iframeName = $I->grabAttributeFrom(\GeneralXpathLibrary::$decisionMakingFrame, 'name');
		$I->switchToIFrame($iframeName);
		$I->wait(1);
		$I->click(\GeneralXpathLibrary::$decisionMaking);
		$I->wait(1);

		$responseData = array();
		$caseId = $I->grabTextFrom(\GeneralXpathLibrary::$caseId);
		$caseId = str_replace("(", "", $caseId);
		$caseId = str_replace(")", "", $caseId);
		$responseData['case_id']        = $caseId;
		$responseData['application_id'] = $I->grabTextFrom(\GeneralXpathLibrary::$applicationId);
		$responseData['national_id']    = $I->grabTextFrom(\GeneralXpathLibrary::$nationalIdScoring);
		$I->wait(1);
		$I->scrollTo(\GeneralXpathLibrary::$totalScore);
		$responseData['total_score']        = $I->grabTextFrom(\GeneralXpathLibrary::$totalScore);
		$responseData['score_group']        = $I->grabTextFrom(\GeneralXpathLibrary::$scoreGroup);
		$responseData['random_number']      = $I->grabTextFrom(\GeneralXpathLibrary::$randomNumber);
		$responseData['gender_and_age']     = $I->grabTextFrom(\GeneralXpathLibrary::$genderAndAgeScore);
		$responseData['marital_status']     = $I->grabTextFrom(\GeneralXpathLibrary::$maritalStatusScore);
		$responseData['installment']        = $I->grabTextFrom(\GeneralXpathLibrary::$installmentScore);
		$responseData['pos_region']         = $I->grabTextFrom(\GeneralXpathLibrary::$posRegionScore);
		$responseData['cc_performance']     = $I->grabTextFrom(\GeneralXpathLibrary::$ccPerformanceScore);
		$responseData['fb_owner']           = $I->grabTextFrom(\GeneralXpathLibrary::$fbOwnerScore);
		$responseData['down_payment_ratio'] = $I->grabTextFrom(\GeneralXpathLibrary::$downpaymentRatioScore);
		$responseData['pos_performance']    = $I->grabTextFrom(\GeneralXpathLibrary::$posPerformanceScore);
		$responseData['owner_dpd_ever']     = $I->grabTextFrom(\GeneralXpathLibrary::$ownerDpdEverScore);
		$responseData['ref_dpd']            = $I->grabTextFrom(\GeneralXpathLibrary::$refDpdScore);
		$I->scrollTo(\GeneralXpathLibrary::$ownerRejectedScore);
		$responseData['owner_rejected']     = $I->grabTextFrom(\GeneralXpathLibrary::$ownerRejectedScore);
		$responseData['owner_disbursed']    = $I->grabTextFrom(\GeneralXpathLibrary::$ownerDisbursedScore);
		$responseData['asset_brand']        = $I->grabTextFrom(\GeneralXpathLibrary::$assetBrandScore);
		$responseData['effective_rate']     = $I->grabTextFrom(\GeneralXpathLibrary::$effectiveRateScore);
		$responseData['document_required']  = $I->grabTextFrom(\GeneralXpathLibrary::$documentRequiredScore);

		print_r($responseData);
	}
}
