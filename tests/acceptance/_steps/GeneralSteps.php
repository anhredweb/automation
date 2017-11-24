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
		$I->wait(5);
		$I->click(\GeneralXpathLibrary::$launchButton);
		$I->waitForElement(\GeneralXpathLibrary::$FECaseManager, 2);
        $I->click(\GeneralXpathLibrary::$FECaseManager);
        $I->wait(2);

        $I->switchToNextTab();
        $I->wait(2);

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
		$I->fillField(\GeneralXpathLibrary::$dealerCode, $data['DEALER_CODE']);
		$I->pressKey(\GeneralXpathLibrary::$dealerCode, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
		$I->wait(1);
		$I->click(\GeneralXpathLibrary::$rowDealerCode);
		$I->wait(1);

		// Fill POS code
		$I->fillField(\GeneralXpathLibrary::$posCode, '');
		$I->wait(1);
        $I->fillField(\GeneralXpathLibrary::$posCode, $data['POS_CODE']);
        $I->wait(1);
        $I->pressKey(\GeneralXpathLibrary::$posCode, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
        $I->wait(1);
        $I->click(\GeneralXpathLibrary::$rowPosCode);
        $I->wait(1);

        // Select product group
        $I->selectOption(\GeneralXpathLibrary::$productGroup, array('value' => ''));
        $I->wait(1);
        $I->selectOption(\GeneralXpathLibrary::$productGroup, array('value' => $data['PRODUCT_GROUP']));
        $I->wait(1);

        // Fill product scheme
        $I->fillField(\GeneralXpathLibrary::$productScheme, '');
        $I->wait(1);
        $I->fillField(\GeneralXpathLibrary::$productScheme, $data['PRODUCT_SCHEME']);
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
		$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$firstname . "').val('Firstname')");
		$I->wait(1);

		// Fill lastname
		$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$lastname . "').val('Lastname')");
		$I->wait(1);

		// Select gender
		$I->selectOption(\GeneralXpathLibrary::$gender, array('value' => $data['GENDER']));
		$I->wait(2);

		// Fill national Id
		$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$nationalId . "').val('" . $data['NATIONAL_ID'] . "')");
		$I->wait(1);

		// Fill date of issue
		$I->click(\GeneralXpathLibrary::$dateOfIssue);
		$I->wait(2);
		$I->click(\GeneralXpathLibrary::$todayLink);
		$I->wait(2);

		// Fill date of birth
		$I->fillField(\GeneralXpathLibrary::$dateOfBirth, $data['DATE_OF_BIRTH']);
		$I->wait(2);

		if (empty($data['FB_NUMBER']))
		{
			$data['FB_NUMBER'] = 'FB#' . $$data['NATIONAL_ID'];
		}

		// Fill family book number
		$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$fbNumber . "').val('" . $data['FB_NUMBER'] . "')");
		$I->wait(1);

		// Fill phone
		$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$phone . "').val('" . $data['PHONE'] . "')");
		$I->wait(2);

		// Fill hometown
		if (!empty($data['HOMETOWN']))
		{
			$I->fillField(\GeneralXpathLibrary::$hometown, 'Hồ Chí Minh');
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

		if (!empty($data['GOOD_TYPE']))
		{
			// Fill good type
			$I->fillField(\GeneralXpathLibrary::$goodType, '');
			$I->wait(1);
			$I->fillField(\GeneralXpathLibrary::$goodType, $data['GOOD_TYPE']);
			$I->wait(2);
			$I->pressKey(\GeneralXpathLibrary::$goodType, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowGoodType);
			$I->wait(2);

			// Fill good brand
			$I->fillField(\GeneralXpathLibrary::$brand, '');
			$I->wait(1);
			$I->fillField(\GeneralXpathLibrary::$brand, $data['BRAND']);
			$I->wait(2);
			$I->pressKey(\GeneralXpathLibrary::$brand, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowBrand);
			$I->wait(1);

			// Fill asset make
			$I->fillField(\GeneralXpathLibrary::$assetMake, '');
			$I->wait(1);
			$I->fillField(\GeneralXpathLibrary::$assetMake, $data['ASSET_MAKE']);
			$I->wait(2);
			$I->pressKey(\GeneralXpathLibrary::$assetMake, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowAssetMake);
			$I->wait(1);

			// Fill asset model
			$I->fillField(\GeneralXpathLibrary::$assetModel, '');
			$I->wait(1);
			$I->fillField(\GeneralXpathLibrary::$assetModel, $data['ASSET_MODEL']);
			$I->wait(2);
			$I->pressKey(\GeneralXpathLibrary::$assetModel, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowAssetModel);
			$I->wait(2);
		}

		// Fill good price
		$I->fillField(\GeneralXpathLibrary::$goodPrice, $data['GOOD_PRICE']);
		$I->wait(2);

		// Fill collateral description
		$I->fillField(\GeneralXpathLibrary::$collateralDescription, $data['COLLATERAL_DESCRIPTION']);
		$I->wait(2);
		$I->click(\GeneralXpathLibrary::$collateralDescription);
		$I->wait(2);

		// Click save button
		$I->click(\GeneralXpathLibrary::$saveGoodButton);
		$I->wait(2);

		// Loan Tab
		$I->click(\GeneralXpathLibrary::getTabId('3'));
		$I->wait(2);

		if (!empty($data['DOWNPAYMENT']))
		{
			$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$downPayment . "').val('" . $data["DOWNPAYMENT"] . "')");
		}

		if (!empty($data['TENOR']))
		{
			$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$tenor . "').val('" . $data["TENOR"] . "')");
		}
		
		$I->wait(2);

		//Customer Tab
		$I->click(\GeneralXpathLibrary::getTabId('4'));
		$I->wait(1);

		if ($data['GENDER'] == 'M')
		{
			$I->selectOption(\GeneralXpathLibrary::$title, array('value' => 'Mr.'));
		}
		else
		{
			$I->selectOption(\GeneralXpathLibrary::$title, array('value' => 'Mrs.'));
		}

		// Check/Uncheck FB Owner
		if (!empty($data['IS_FB_OWNER']) && $data['IS_FB_OWNER'] == 'Y')
		{
			$I->wait(1);
			$I->checkOption(\GeneralXpathLibrary::$isFbOwner);	
		}
		else
		{
			$I->wait(1);
			$I->uncheckOption(\GeneralXpathLibrary::$isFbOwner);	
		}

		// Select education
		if (isset($data['EDUCATION']))
		{
			$I->wait(1);
			$I->selectOption(\GeneralXpathLibrary::$education, array('value' => $data['EDUCATION']));
		}

		// Select marital status
		if (isset($data['MARITAL_STATUS']))
		{
			$I->wait(1);
			$I->selectOption(\GeneralXpathLibrary::$maritalStatus, array('value' => $data['MARITAL_STATUS']));
		}

		// Select social status
		if (isset($data['SOCIAL_STATUS']))
		{
			$I->wait(1);
			$I->selectOption(\GeneralXpathLibrary::$socialStatus, array('value' => $data['SOCIAL_STATUS']));
		}
		
		$I->wait(1);

		// Family Tab
		if ((!empty($data['IS_FB_OWNER']) && $data['IS_FB_OWNER'] == 'N') || ($data['MARITAL_STATUS'] == 'M' || $data['MARITAL_STATUS'] == 'C'))
		{
			$I->click(\GeneralXpathLibrary::getTabId('5'));
			$I->wait(2);
			$nationalId = (int) date('YmdHi');
		}

		if (!empty($data['IS_FB_OWNER']) && $data['IS_FB_OWNER'] == 'N')
		{
			$I->fillField(\GeneralXpathLibrary::$fbOwnerFirstname, 'FBFirstname');
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$fbOwnerLastname);
			$I->wait(2);
			$I->fillField(\GeneralXpathLibrary::$fbOwnerLastname, 'FBLastname');
			$I->wait(2);
			$I->selectOption(\GeneralXpathLibrary::$fbOwnerRelationType, array('value' => "O"));
			$I->wait(2);
			$I->fillField(\GeneralXpathLibrary::$fbOwnerNationalId, $nationalId + 1);
			$I->wait(2);
		}

		if ($data['MARITAL_STATUS'] == 'M' || $data['MARITAL_STATUS'] == 'C')
		{
			$I->fillField(\GeneralXpathLibrary::$spouseLastname, 'SpFirstname');
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$spouseFirstname);
			$I->wait(2);
			$I->fillField(\GeneralXpathLibrary::$spouseFirstname, 'SpLastname');
			$I->wait(2);
			$spouseGender = $data['GENDER'] == 'M' ? 'F' : 'M';
			$I->selectOption(\GeneralXpathLibrary::$spouseGender, array('value' => $spouseGender));
			$I->wait(2);
			$I->fillField(\GeneralXpathLibrary::$spouseNationalId, $nationalId + 2);
			$I->wait(2);
			$I->fillField(\GeneralXpathLibrary::$spouseRelationPeriod, 2);
			$I->wait(2);
		}

		// Income Tab

		if (!empty($data['PERSONAL_INCOME']))
		{
			$I->click(\GeneralXpathLibrary::getTabId('8'));
			$I->wait(2);

			// Fill personal income
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowMainIncome);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$personalIncome);
			$I->wait(2);
			$I->executeJS('return jQuery("input#NetAmount1").attr("data-value", "' . $data["PERSONAL_INCOME"] . '")');
			$I->executeJS('return jQuery("input#NetAmount1").val("' . $data["PERSONAL_INCOME"] . '")');
			$I->click(\GeneralXpathLibrary::getTabId('8'));

			if (empty($data["FAMILY_INCOME"]))
			{
				$data['FAMILY_INCOME'] += (float) $data['PERSONAL_INCOME'] + 1000000;
			}

			// Fill family income
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowFamilyIncome);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$familyIncome);
			$I->wait(2);
			$I->executeJS('return jQuery("input#NetAmount2").attr("data-value", "' . $data["FAMILY_INCOME"] . '")');
			$I->executeJS('return jQuery("input#NetAmount2").val("' . $data["FAMILY_INCOME"] . '")');
			$I->click(\GeneralXpathLibrary::getTabId('8'));
		}

		$I->wait(2);

		// Reference Tab
		if (!empty($data['PHONE_REFERENCE1']) || !empty($data['PHONE_REFERENCE2']))
		{
			$I->click(\GeneralXpathLibrary::getTabId('9'));
			$I->wait(2);
		}

		if (!empty($data['PHONE_REFERENCE1']))
		{
			// Fill phone reference 1
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowPhoneReference1);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowMobile1);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$phoneReference1);
			$I->wait(2);
			$I->executeJS('return jQuery("input#CommunicationString1").val("' . $data["PHONE_REFERENCE1"] . '")');
			$I->click(\GeneralXpathLibrary::getTabId('9'));
		}

		if (!empty($data['PHONE_REFERENCE2']))
		{
			// Fill phone reference 2
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowPhoneReference2);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowMobile2);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$phoneReference1);
			$I->wait(2);
			$I->executeJS('return jQuery("input#CommunicationString1").val("' . $data["PHONE_REFERENCE2"] . '")');
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
		$I->wait(1);

		// Click documents tab and demo data
		$I->click(\GeneralXpathLibrary::$documentsTab);
		$I->click(\GeneralXpathLibrary::$demoDataDataCheck);
		$I->wait(1);

		// Click CIC tab and select CIC result
		$I->click(\GeneralXpathLibrary::$cicTab);
		$I->selectOption(\GeneralXpathLibrary::$cicResult, array("value" => "Don't require"));
		$I->wait(1);

		// Click submit data
		$I->click(\GeneralXpathLibrary::$submitDataCheck);
		$I->wait(1);
		$I->click(\GeneralXpathLibrary::$okDataCheck);
		$I->wait(1);

		$caseId = $I->grabTextFrom(\GeneralXpathLibrary::$caseId);
		$caseId = str_replace('(', '', $caseId);
		$caseId = str_replace(')', '', $caseId);

		return $caseId;
	}

	/**
	 * Function to switch Application to LOS2
	 *
	 * @return void
	 */
	public function switchApplicationToLOS2()
	{
		$I = $this;
		$I->switchToPreviousTab();
		$I->wait(2);
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
		$applicationStatus              = $I->grabTextFrom(\GeneralXpathLibrary::$applicationStatus);

		if (trim($applicationStatus) == 'Resolved-Rejected-Hard' || trim($applicationStatus) == 'Resolved-Rejected-Soft')
		{
			return array();
		}

		$I->wait(1);
		$I->scrollTo(\GeneralXpathLibrary::$totalScore);
		$responseData['total_score']                    = $I->grabTextFrom(\GeneralXpathLibrary::$totalScore);
		$responseData['score_group']                    = $I->grabTextFrom(\GeneralXpathLibrary::$scoreGroup);
		$responseData['random_number']                  = $I->grabTextFrom(\GeneralXpathLibrary::$randomNumber);
		$responseData['score_robot_gender_and_age']     = $I->grabTextFrom(\GeneralXpathLibrary::$genderAndAgeScore);
		$responseData['score_robot_marital_status']     = $I->grabTextFrom(\GeneralXpathLibrary::$maritalStatusScore);
		$responseData['score_robot_installment']        = $I->grabTextFrom(\GeneralXpathLibrary::$installmentScore);
		$responseData['score_robot_pos_region']         = $I->grabTextFrom(\GeneralXpathLibrary::$posRegionScore);
		$responseData['score_robot_cc_performance']     = $I->grabTextFrom(\GeneralXpathLibrary::$ccPerformanceScore);
		$responseData['score_robot_fb_owner']           = $I->grabTextFrom(\GeneralXpathLibrary::$fbOwnerScore);
		$responseData['score_robot_down_payment_ratio'] = $I->grabTextFrom(\GeneralXpathLibrary::$downpaymentRatioScore);
		$responseData['score_robot_pos_performance']    = $I->grabTextFrom(\GeneralXpathLibrary::$posPerformanceScore);
		$responseData['score_robot_owner_dpd_ever']     = $I->grabTextFrom(\GeneralXpathLibrary::$ownerDpdEverScore);
		$responseData['score_robot_ref_dpd']            = $I->grabTextFrom(\GeneralXpathLibrary::$refDpdScore);
		$I->scrollTo(\GeneralXpathLibrary::$ownerRejectedScore);
		$responseData['score_robot_owner_rejected']     = $I->grabTextFrom(\GeneralXpathLibrary::$ownerRejectedScore);
		$responseData['score_robot_owner_disbursed']    = $I->grabTextFrom(\GeneralXpathLibrary::$ownerDisbursedScore);
		$responseData['score_robot_asset_brand']        = $I->grabTextFrom(\GeneralXpathLibrary::$assetBrandScore);
		$responseData['score_robot_effective_rate']     = $I->grabTextFrom(\GeneralXpathLibrary::$effectiveRateScore);
		$responseData['score_robot_document_required']  = $I->grabTextFrom(\GeneralXpathLibrary::$documentRequiredScore);

		$I->wait(3);

		return $responseData;
	}

	/**
	 * Function to switch Application to Loan
	 *
	 *
	 * @return void
	 */
	public function switchApplicationToLoan()
	{
		$I = $this;
		$I->switchToPreviousTab();
		$I->wait(1);
		$I->click(\GeneralXpathLibrary::$roleMenu);
		$I->wait(2);
		$I->moveMouseOver(\GeneralXpathLibrary::$switchApplication);
		$I->wait(1);
		$I->click(\GeneralXpathLibrary::$loan);
		$I->wait(2);
	}

	/**
	 * Function to update score to DB
	 *
	 * @param  array   $data        Data to update
	 * @param  string  $connection  Oracle connection
	 *
	 * @return void
	 */
	public function updateScore($data, $connection)
	{
		$nationalId = $data['national_id'];
		unset($data['national_id']);
		$setQuery = array();

		foreach ($data as $column => $value)
		{
			$setQuery[] = $column . " = " . "'" . $value . "'";
		}

		$setQuery[] = "STATUS = '1'";

		$query = "UPDATE AUTOMATION_TEST_CASE SET " . implode(',', $setQuery) . " WHERE NATIONAL_ID = " . $nationalId;
		$stid  = oci_parse($connection, $query);
        oci_execute($stid);
        oci_commit($connection);

        return true;
	}

	/**
	 * Function to check score and update to DB
	 *
	 * @param  array   $data        Data to update
	 * @param  string  $connection  Oracle connection
	 *
	 * @return void
	 */
	public function checkScore($data, $connection)
	{
		$selectScoreQuery = array(
			'SCORE_USER_GENDER_AND_AGE',
			'SCORE_USER_MARITAL_STATUS',
			'SCORE_USER_INSTALLMENT',
			'SCORE_USER_POS_REGION',
			'SCORE_USER_CC_PERFORMANCE',
			'SCORE_USER_FB_OWNER',
			'SCORE_USER_DOWN_PAYMENT_RATIO',
			'SCORE_USER_POS_PERFORMANCE',
			'SCORE_USER_OWNER_DPD_EVER',
			'SCORE_USER_REF_DPD',
			'SCORE_USER_OWNER_REJECTED',
			'SCORE_USER_OWNER_DISBURSED',
			'SCORE_USER_ASSET_BRAND',
			'SCORE_USER_EFFECTIVE_RATE',
			'SCORE_USER_DOCUMENT_REQUIRED'
		);
		$selectCheckQuery = array(
			'SCORE_CHECK_GENDER_AND_AGE'     => "'F'",
			'SCORE_CHECK_MARITAL_STATUS'     => "'F'",
			'SCORE_CHECK_INSTALLMENT'        => "'F'",
			'SCORE_CHECK_POS_REGION'         => "'F'",
			'SCORE_CHECK_CC_PERFORMANCE'     => "'F'",
			'SCORE_CHECK_FB_OWNER'           => "'F'",
			'SCORE_CHECK_DOWN_PAYMENT_RATIO' => "'F'",
			'SCORE_CHECK_POS_PERFORMANCE'    => "'F'",
			'SCORE_CHECK_OWNER_DPD_EVER'     => "'F'",
			'SCORE_CHECK_REF_DPD'            => "'F'",
			'SCORE_CHECK_OWNER_REJECTED'     => "'F'",
			'SCORE_CHECK_OWNER_DISBURSED'    => "'F'",
			'SCORE_CHECK_ASSET_BRAND'        => "'F'",
			'SCORE_CHECK_EFFECTIVE_RATE'     => "'F'",
			'SCORE_CHECK_DOCUMENT_REQUIRED'  => "'F'"
		);
        $query      = "SELECT " . implode(',', $selectScoreQuery) . " FROM AUTOMATION_TEST_CASE WHERE NATIONAL_ID = " . $data['national_id'];
        $stid       = oci_parse($connection, $query);
        oci_execute($stid);
        $rows = oci_fetch_assoc($stid);

        if (empty($rows))
        {
        	return false;
        }

        foreach ($rows as $column => $score)
        {
        	if ($column == 'SCORE_USER_GENDER_AND_AGE' && $score == $data['score_robot_gender_and_age'])
        	{
        		$selectCheckQuery['SCORE_CHECK_GENDER_AND_AGE'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_MARITAL_STATUS' && $score == $data['score_robot_marital_status'])
        	{
        		$selectCheckQuery['SCORE_CHECK_MARITAL_STATUS'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_INSTALLMENT' && $score == $data['score_robot_installment'])
        	{
        		$selectCheckQuery['SCORE_CHECK_INSTALLMENT'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_POS_REGION' && $score == $data['score_robot_pos_region'])
        	{
        		$selectCheckQuery['SCORE_CHECK_POS_REGION'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_CC_PERFORMANCE' && $score == $data['score_robot_cc_performance'])
        	{
        		$selectCheckQuery['SCORE_CHECK_CC_PERFORMANCE'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_FB_OWNER' && $score == $data['score_robot_fb_owner'])
        	{
        		$selectCheckQuery['SCORE_CHECK_FB_OWNER'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_DOWN_PAYMENT_RATIO' && $score == $data['score_robot_down_payment_ratio'])
        	{
        		$selectCheckQuery['SCORE_CHECK_DOWN_PAYMENT_RATIO'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_POS_PERFORMANCE' && $score == $data['score_robot_pos_performance'])
        	{
        		$selectCheckQuery['SCORE_CHECK_POS_PERFORMANCE'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_OWNER_DPD_EVER' && $score == $data['score_robot_owner_dpd_ever'])
        	{
        		$selectCheckQuery['SCORE_CHECK_OWNER_DPD_EVER'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_REF_DPD' && $score == $data['score_robot_ref_dpd'])
        	{
        		$selectCheckQuery['SCORE_CHECK_REF_DPD'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_OWNER_REJECTED' && $score == $data['score_robot_owner_rejected'])
        	{
        		$selectCheckQuery['SCORE_CHECK_OWNER_REJECTED'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_OWNER_DISBURSED' && $score == $data['score_robot_owner_disbursed'])
        	{
        		$selectCheckQuery['SCORE_CHECK_OWNER_DISBURSED'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_ASSET_BRAND' && $score == $data['score_robot_asset_brand'])
        	{
        		$selectCheckQuery['SCORE_CHECK_ASSET_BRAND'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_EFFECTIVE_RATE' && $score == $data['score_robot_effective_rate'])
        	{
        		$selectCheckQuery['SCORE_CHECK_EFFECTIVE_RATE'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_DOCUMENT_REQUIRED' && $score == $data['score_robot_document_required'])
        	{
        		$selectCheckQuery['SCORE_CHECK_DOCUMENT_REQUIRED'] = "'P'";
        	}
        }

        $selectedCheckQuery = array();

        foreach ($selectCheckQuery as $column => $value)
        {
        	$selectedCheckQuery[] = $column . ' = ' . $value;
        }

        $query = "UPDATE AUTOMATION_TEST_CASE SET " . implode(',', $selectedCheckQuery) . " WHERE NATIONAL_ID = " . $data['national_id'];
		$stid  = oci_parse($connection, $query);
        oci_execute($stid);
        oci_commit($connection);

       	return true;
	}

	/**
	 * Function to check error
	 *
	 * @param  string  $imageName  Image name
	 *
	 * @return boolean
	 */
	public function checkError($imageName)
	{
		$I = $this;

		try 
        {
            $I->dontSeeElement(\GeneralXpathLibrary::$errorMessageTable);

            return true;
        } 
        catch (Exception $e) 
        {
            $this->getModule('WebDriver')->_saveScreenshot(codecept_output_dir() . $imageName . '.png');
            $I->wait(2);
            $I->closeTab();
            $I->wait(2);
            $I->reloadPage();
            
            return false;
        }
	}

	/**
	 * Function to check popup
	 *	 *
	 * @return boolean
	 */
	public function checkPopup()
	{
		$I = $this;

		try 
        {
            $I->seeInPopup('Error');
            $I->wait(2);
            $this->getModule('WebDriver')->_saveScreenshot(codecept_output_dir() . $imageName . '.png');
            $I->wait(2);
            $I->closeTab();
            $I->wait(2);
            $I->reloadPage();

            return false;
        } 
        catch (Exception $e) 
        {
            return true;
        }
	}
}
