<?php
/**
 * @package     FE Credit
 * @subpackage  Automation Testing Helper
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Class Helper
 *
 * @since  1.0
 */
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

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
	 * Function to init data for Application
	 *
	 * @param  array   $data     Data
	 * @param  string  $product  Product name
	 *
	 * @return boolean
	 */
	public function initData($data, $product)
	{
		$I = $this;
		$I->wait(2);

		// PEGA System use iframe so need to switch to iframe to access input
		$iframeName = $I->grabAttributeFrom(\GeneralXpathLibrary::$iframeEnviroment, 'name');
		$I->switchToIFrame($iframeName);
		$I->wait(1);

		// Click demo data
		switch ($product) 
		{
			case 'CDL':
				$I->click(\GeneralXpathLibrary::$demoDataCDLInitApp);
				break;
			case 'TW':
				$I->click(\GeneralXpathLibrary::$demoDataTWInitApp);			
				break;
		}

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

        return $I->checkError($data['NATIONAL_ID']);
	}

	/**
	 * Function to entry short data for Application
	 *
	 * @param  array  $data     Data
	 * @param  array  $product  Product
	 *
	 * @return boolean
	 */
	public function shortApplication($data, $product = NULL)
	{
		$faker     = \Faker\Factory::create();
		$firstname = $faker->firstname;
		$lastname  = $faker->lastname;
		$I         = $this;
		$I->wait(3);

		// Fill firstname
		$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$firstname . "').val('" . $firstname . "')");
		$I->wait(1);

		// Fill lastname
		$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$lastname . "').val('" . $lastname . "')");
		$I->wait(1);

		$genders = array('M', 'F');

		if (!in_array($data['GENDER'], $genders))
		{
			$data['GENDER'] = 'M';
		}

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
			$I->click(\GeneralXpathLibrary::$hometown);
			$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$hometownJS . "').val('Hồ Chí Minh')");
			$I->wait(2);
			$I->pressKey(\GeneralXpathLibrary::$hometown, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
			$I->wait(1);
			$I->click(\GeneralXpathLibrary::$rowHometown);
			$I->wait(2);
		}

		// Select Disbursement Channel
		if ($product == 'PL')
		{
			$I->selectOption(\GeneralXpathLibrary::$disbursementChannel, array('value' => $data['DISBURSEMENT_CHANNEL']));
			$I->wait(2);
		}

		// Click submit data
		$I->click(\GeneralXpathLibrary::$submitShortApp);
		$I->wait(2);

		return $I->checkError($data['NATIONAL_ID']);
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
	 * Function to data check for Application
	 *
	 * @param string  $product  Product
	 *
	 * @return string
	 */
	public function dataCheck($product = NULL)
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

		if ($product == 'PL')
		{
			// Click PCB tab and select PCB result
			$I->click(\GeneralXpathLibrary::$pcbTab);
			$I->selectOption(\GeneralXpathLibrary::$pcbResult, array("value" => "PCB OK"));
			$I->wait(1);
		}

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
	 * @param  string  $caseId   Case ID
	 * @param  string  $product  Product name
	 *
	 * @return void
	 */
	public function searchApplication($caseId, $product)
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

		if (trim($applicationStatus) == 'Resolved-Rejected-Hard' || trim($applicationStatus) == 'Resolved-Rejected-Soft' || trim($applicationStatus) == 'Pending-DC')
		{
			return array();
		}

		$I->wait(1);
		$I->scrollTo(\GeneralXpathLibrary::$totalScore);
		$responseData['robot_total_score']   = $I->grabTextFrom(\GeneralXpathLibrary::$totalScore);
		$responseData['robot_score_group']   = $I->grabTextFrom(\GeneralXpathLibrary::$scoreGroup);

		switch ($product) 
		{
			case 'CDL':
				$responseData['robot_random_number']            = $I->grabTextFrom(\GeneralXpathLibrary::$randomNumber);
				$responseData['score_robot_gender_and_age']     = $I->grabTextFrom(\GeneralXpathLibrary::$CDLgenderAndAgeScore);
				$responseData['score_robot_marital_status']     = $I->grabTextFrom(\GeneralXpathLibrary::$CDLmaritalStatusScore);
				$responseData['score_robot_installment']        = $I->grabTextFrom(\GeneralXpathLibrary::$CDLinstallmentScore);
				$responseData['score_robot_pos_region']         = $I->grabTextFrom(\GeneralXpathLibrary::$CDLposRegionScore);
				$responseData['score_robot_cc_performance']     = $I->grabTextFrom(\GeneralXpathLibrary::$CDLccPerformanceScore);
				$responseData['score_robot_fb_owner']           = $I->grabTextFrom(\GeneralXpathLibrary::$CDLfbOwnerScore);
				$responseData['score_robot_down_payment_ratio'] = $I->grabTextFrom(\GeneralXpathLibrary::$CDLdownpaymentRatioScore);
				$responseData['score_robot_pos_performance']    = $I->grabTextFrom(\GeneralXpathLibrary::$CDLposPerformanceScore);
				$responseData['score_robot_owner_dpd_ever']     = $I->grabTextFrom(\GeneralXpathLibrary::$CDLownerDpdEverScore);
				$responseData['score_robot_ref_dpd']            = $I->grabTextFrom(\GeneralXpathLibrary::$CDLrefDpdScore);
				$I->scrollTo(\GeneralXpathLibrary::$CDLownerRejectedScore);
				$responseData['score_robot_owner_rejected']     = $I->grabTextFrom(\GeneralXpathLibrary::$CDLownerRejectedScore);
				$responseData['score_robot_owner_disbursed']    = $I->grabTextFrom(\GeneralXpathLibrary::$CDLownerDisbursedScore);
				$responseData['score_robot_asset_brand']        = $I->grabTextFrom(\GeneralXpathLibrary::$CDLassetBrandScore);
				$responseData['score_robot_effective_rate']     = $I->grabTextFrom(\GeneralXpathLibrary::$CDLeffectiveRateScore);
				$responseData['score_robot_document_required']  = $I->grabTextFrom(\GeneralXpathLibrary::$CDLdocumentRequiredScore);
				break;
			case 'TW':
				$responseData['robot_random_number']           = $I->grabTextFrom(\GeneralXpathLibrary::$randomNumber);
				$responseData['score_robot_gender_and_age']    = $I->grabTextFrom(\GeneralXpathLibrary::$TWgenderAndAgeScore);
				$responseData['score_robot_reject_apps']       = $I->grabTextFrom(\GeneralXpathLibrary::$TWnoOfRejectedApplicationsScore);
				$responseData['score_robot_marital_status']    = $I->grabTextFrom(\GeneralXpathLibrary::$TWmaritalStatusScore);
				$responseData['score_robot_dpd_ever']          = $I->grabTextFrom(\GeneralXpathLibrary::$TWdpdEverScore);
				$responseData['score_robot_tenor']             = $I->grabTextFrom(\GeneralXpathLibrary::$TWtenorScore);
				$responseData['score_robot_pos_performance']   = $I->grabTextFrom(\GeneralXpathLibrary::$TWposPerformanceScore);
				$responseData['score_robot_pos_address']       = $I->grabTextFrom(\GeneralXpathLibrary::$TWposAddressScore);
				$responseData['score_robot_permanent_address'] = $I->grabTextFrom(\GeneralXpathLibrary::$TWpermanentAddressScore);
				$responseData['score_robot_education_work']    = $I->grabTextFrom(\GeneralXpathLibrary::$TWeducationAndWorkExperienceScore);
				$responseData['score_robot_down_payment_rate'] = $I->grabTextFrom(\GeneralXpathLibrary::$TWdownpaymentRateScore);
				$responseData['score_robot_fb_owner_gender']   = $I->grabTextFrom(\GeneralXpathLibrary::$TWfbOwnerGenderScore);
				$responseData['score_robot_customerage']       = $I->grabTextFrom(\GeneralXpathLibrary::$TWcustomerageScore);
				break;
			case 'PL':
				$responseData['robot_random_number']          = $I->grabTextFrom(\GeneralXpathLibrary::$randomNumberPL);
				$responseData['robot_product_score_group']    = $I->grabTextFrom(\GeneralXpathLibrary::$productScoreGroup);
				$responseData['score_robot_gender']           = $I->grabTextFrom(\GeneralXpathLibrary::$PLgenderScore);
				$responseData['score_robot_work_experience']  = $I->grabTextFrom(\GeneralXpathLibrary::$PLworkExperienceScore);
				$responseData['score_robot_age']              = $I->grabTextFrom(\GeneralXpathLibrary::$PLageScore);
				$responseData['score_robot_interest_rate']    = $I->grabTextFrom(\GeneralXpathLibrary::$PLinterestRateScore);
				$responseData['score_robot_dist_office_add']  = $I->grabTextFrom(\GeneralXpathLibrary::$PLdistrictOfficeAddressScore);
				$responseData['score_robot_province']         = $I->grabTextFrom(\GeneralXpathLibrary::$PLprovinceScore);
				$responseData['score_robot_disburse_date']    = $I->grabTextFrom(\GeneralXpathLibrary::$PLdisburseDateScore);
				$responseData['score_robot_dpd_no_disb_apps'] = $I->grabTextFrom(\GeneralXpathLibrary::$PLdpdAndNumberDisburseApplicationsScore);
				$responseData['score_robot_rejection']        = $I->grabTextFrom(\GeneralXpathLibrary::$PLrejectionScore);
				break;
		}

		$I->wait(3);

		print_r($responseData);

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
	 * Function to check error
	 *
	 * @param  string  $imageName  Image name
	 *
	 * @return boolean
	 */
	public function checkError($imageName)
	{
		$I = $this;
		$errors = array_filter($I->grabMultiple(\GeneralXpathLibrary::$errorMessageTable));

		if (empty($errors))
		{
			return true;
		}
        
       	$I->skipTestCase($imageName);
        
        return false;
	}

	/**
	 * Function to check element is not existed
	 *
	 * @param  string  $element  Element
	 *
	 * @return boolean
	 */
	public function checkElementNotExist($element)
	{
		$I       = $this;
		$element = array_filter($I->grabMultiple($element));

		print_r($element);

		if (empty($element))
		{
			return true;
		}
        
        return false;
	}

	/**
	 * Function to check popup
	 *
	 * @param  array  $imageName  Image name
	 * 
	 * @return void
	 */
	public function skipTestCase($imageName)
	{
		$I = $this;
		$I->makeScreenshot($imageName . '_' . time() . '.png');
        $I->wait(2);
        $I->closeTab();
        $I->wait(2);
        $I->reloadPage();
	}

	/**
	 * Function to check popup
	 *
	 * @param  array  $data  Data
	 * 
	 * @return void
	 */
	public function validationData(&$data)
	{
		$faker           = \Faker\Factory::create();
		$genders         = array('M', 'F');
		$educations      = array('76', '84', '73', '81', '75', '80', '91', '85');
		$maritalStatuses = array('W', 'O', 'C', 'M', 'D', 'S');
		$socialStatuses  = array('8', '10', '3', '9', '1', '5');
		$fbOwners        = array('Y', 'N');

		if (!in_array($data['GENDER'], $genders))
		{
			$data['GENDER'] = 'M';
		}

		if (!in_array($data['EDUCATION'], $educations))
		{
			$data['EDUCATION'] = '76';
		}

		if (!in_array($data['IS_FB_OWNER'], $fbOwners))
		{
			$data['IS_FB_OWNER'] = 'Y';
		}

		if (!in_array($data['MARITAL_STATUS'], $maritalStatuses))
		{
			$data['MARITAL_STATUS'] = 'O';
		}

		if (!in_array($data['SOCIAL_STATUS'], $socialStatuses))
		{
			$data['SOCIAL_STATUS'] = '8';
		}

		if (empty($data["FAMILY_INCOME"]) || $data['PERSONAL_INCOME'] > $data['FAMILY_INCOME'])
		{
			$data['FAMILY_INCOME'] += (float) $data['PERSONAL_INCOME'] + (float) $faker->numberBetween(1000000, 9000000);
		}
	}
}
