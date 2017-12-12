<?php
/**
 * @package     FE Credit
 * @subpackage  Automation Testing Helper
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Codeception\Lib\ModuleContainer;
use Codeception\Module\WebDriver;
use Codeception\Module\GeneralHelper;
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
		$I->click(\GeneralXpathLibrary::$dealerCode);
		$I->wait(1);
		$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$dealerCode . "').val('" . $data["DEALER_CODE"] . "')");
		$I->wait(1);
		$I->pressKey(\GeneralXpathLibrary::$dealerCode, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
		$I->wait(1);

		if ($I->checkElementNotExist(\GeneralXpathLibrary::$rowDealerCode))
		{
			$I->skipTestCase($data['NATIONAL_ID']);

			return false;
		}

		$I->click(\GeneralXpathLibrary::$rowDealerCode);
		$I->wait(1);



		// Fill POS code
		$I->click(\GeneralXpathLibrary::$posCode);
		$I->wait(1);
		$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$posCode . "').val('" . $data["POS_CODE"] . "')");
		$I->wait(1);
        $I->pressKey(\GeneralXpathLibrary::$posCode, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
        $I->wait(1);

        if ($I->checkElementNotExist(\GeneralXpathLibrary::$rowPosCode))
		{
			$I->skipTestCase($data['NATIONAL_ID']);

			return false;
		}

        $I->click(\GeneralXpathLibrary::$rowPosCode);
        $I->wait(1);

        // Select product group
        $I->selectOption(\GeneralXpathLibrary::$productGroup, array('value' => ''));
        $I->wait(1);
        $I->selectOption(\GeneralXpathLibrary::$productGroup, array('value' => $data['PRODUCT_GROUP']));
        $I->wait(1);

        // Fill product scheme
		$I->click(\GeneralXpathLibrary::$productScheme);
		$I->wait(1);
		$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$productScheme . "').val('" . $data["PRODUCT_SCHEME"] . "')");
		$I->wait(1);
        $I->pressKey(\GeneralXpathLibrary::$productScheme, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
        $I->wait(1);
        
        if ($I->checkElementNotExist(\GeneralXpathLibrary::$rowProductScheme))
		{
			$I->skipTestCase($data['NATIONAL_ID']);

			return false;
		}

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
     * Function to entry full data for Application
     *
     * @param  array  $data  Data
     *
     * @return void
     */
	public function generalFullDataEntry($data)
	{
		$faker = \Faker\Factory::create();
		$I     = $this;

		//Customer Tab
        $I->click(\GeneralXpathLibrary::getTabId('4'));
        $I->wait(1);

        // Select title
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
            $I->fillField(\GeneralXpathLibrary::$fbOwnerFirstname, $faker->firstname);
            $I->wait(2);
            $I->click(\GeneralXpathLibrary::$fbOwnerLastname);
            $I->wait(2);
            $I->fillField(\GeneralXpathLibrary::$fbOwnerLastname, $faker->lastname);
            $I->wait(2);
            $I->selectOption(\GeneralXpathLibrary::$fbOwnerRelationType, array('value' => "O"));
            $I->wait(2);
            $I->fillField(\GeneralXpathLibrary::$fbOwnerNationalId, $nationalId + 1);
            $I->wait(2);
        }

        if ($data['MARITAL_STATUS'] == 'M' || $data['MARITAL_STATUS'] == 'C')
        {
            $I->fillField(\GeneralXpathLibrary::$spouseLastname, $faker->firstname);
            $I->wait(2);
            $I->click(\GeneralXpathLibrary::$spouseFirstname);
            $I->wait(2);
            $I->fillField(\GeneralXpathLibrary::$spouseFirstname, $faker->lastname);
            $I->wait(2);
            $spouseGender = $data['GENDER'] == 'M' ? 'F' : 'M';
            $I->selectOption(\GeneralXpathLibrary::$spouseGender, array('value' => $spouseGender));
            $I->wait(2);
            $I->fillField(\GeneralXpathLibrary::$spouseNationalId, $nationalId + 2);
            $I->wait(2);
            $I->fillField(\GeneralXpathLibrary::$spouseRelationPeriod, $faker->numberBetween(1, 9));
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
            $I->waitForElement(\GeneralXpathLibrary::$personalIncome, 2);
            $I->fillField(\GeneralXpathLibrary::$personalIncome, $data["PERSONAL_INCOME"]);
            $I->wait(1);
            $I->executeJS('return jQuery(document).find("input#NetAmount1").attr("data-value", "0").val("0").attr("data-value", "' . $data["PERSONAL_INCOME"] . '").val("' . $data["PERSONAL_INCOME"] . '")');
            $I->click(\GeneralXpathLibrary::getTabId('8'));

            // Fill family income
            $I->wait(2);
            $I->click(\GeneralXpathLibrary::$rowFamilyIncome);
            $I->wait(2);
            $I->click(\GeneralXpathLibrary::$familyIncome);
            $I->waitForElement(\GeneralXpathLibrary::$familyIncome, 2);
            $I->fillField(\GeneralXpathLibrary::$familyIncome, $data["FAMILY_INCOME"]);
            $I->wait(1);
            $I->executeJS('return jQuery(document).find("input#NetAmount2").attr("data-value", "0").val("0").attr("data-value", "' . $data["FAMILY_INCOME"] . '").val("' . $data["FAMILY_INCOME"] . '")');
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
	 * @param  array   $data     Data
	 *
	 * @return void
	 */
	public function searchApplication($caseId, $product, $data)
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
				$responseData['score_robot_gender_and_age']     = $I->grabTextFrom(\GeneralXpathLibrary::getScore('1'));
				$responseData['score_robot_marital_status']     = $I->grabTextFrom(\GeneralXpathLibrary::getScore('2'));
				$responseData['score_robot_installment']        = $I->grabTextFrom(\GeneralXpathLibrary::getScore('3'));
				$responseData['score_robot_pos_region']         = $I->grabTextFrom(\GeneralXpathLibrary::getScore('4'));
				$responseData['score_robot_cc_performance']     = $I->grabTextFrom(\GeneralXpathLibrary::getScore('5'));
				$responseData['score_robot_fb_owner']           = $I->grabTextFrom(\GeneralXpathLibrary::getScore('6'));
				$responseData['score_robot_down_payment_ratio'] = $I->grabTextFrom(\GeneralXpathLibrary::getScore('7'));
				$responseData['score_robot_pos_performance']    = $I->grabTextFrom(\GeneralXpathLibrary::getScore('8'));
				$responseData['score_robot_owner_dpd_ever']     = $I->grabTextFrom(\GeneralXpathLibrary::getScore('9'));
				$responseData['score_robot_ref_dpd']            = $I->grabTextFrom(\GeneralXpathLibrary::getScore('10'));
				$I->scrollTo(\GeneralXpathLibrary::getScore('11'));
				$responseData['score_robot_owner_rejected']     = $I->grabTextFrom(\GeneralXpathLibrary::getScore('11'));
				$responseData['score_robot_owner_disbursed']    = $I->grabTextFrom(\GeneralXpathLibrary::getScore('12'));
				$responseData['score_robot_asset_brand']        = $I->grabTextFrom(\GeneralXpathLibrary::getScore('13'));
				$responseData['score_robot_effective_rate']     = $I->grabTextFrom(\GeneralXpathLibrary::getScore('14'));
				$responseData['score_robot_document_required']  = $I->grabTextFrom(\GeneralXpathLibrary::getScore('15'));
				break;
			case 'TW':
				$responseData['robot_random_number']           = $I->grabTextFrom(\GeneralXpathLibrary::$randomNumber);
				$responseData['score_robot_gender_and_age']    = $I->grabTextFrom(\GeneralXpathLibrary::getScore('1'));
				$responseData['score_robot_reject_apps']       = $I->grabTextFrom(\GeneralXpathLibrary::getScore('2'));
				$responseData['score_robot_marital_status']    = $I->grabTextFrom(\GeneralXpathLibrary::getScore('3'));
				$responseData['score_robot_dpd_ever']          = $I->grabTextFrom(\GeneralXpathLibrary::getScore('4'));
				$responseData['score_robot_tenor']             = $I->grabTextFrom(\GeneralXpathLibrary::getScore('5'));
				$responseData['score_robot_pos_performance']   = $I->grabTextFrom(\GeneralXpathLibrary::getScore('6'));
				$responseData['score_robot_pos_address']       = $I->grabTextFrom(\GeneralXpathLibrary::getScore('7'));
				$responseData['score_robot_permanent_address'] = $I->grabTextFrom(\GeneralXpathLibrary::getScore('8'));
				$responseData['score_robot_education_work']    = $I->grabTextFrom(\GeneralXpathLibrary::getScore('9'));
				$responseData['score_robot_down_payment_rate'] = $I->grabTextFrom(\GeneralXpathLibrary::getScore('10'));
				$responseData['score_robot_fb_owner_gender']   = $I->grabTextFrom(\GeneralXpathLibrary::getScore('11'));
				$responseData['score_robot_customerage']       = $I->grabTextFrom(\GeneralXpathLibrary::getScore('12'));
				break;
			case 'PL':
				$responseData['robot_random_number']          = $I->grabTextFrom(\GeneralXpathLibrary::$randomNumberPL);
				$responseData['robot_product_score_group']    = $I->grabTextFrom(\GeneralXpathLibrary::$productScoreGroup);
				$responseData['score_robot_gender']           = $I->grabTextFrom(\GeneralXpathLibrary::getScore('1'));
				$responseData['score_robot_work_experience']  = $I->grabTextFrom(\GeneralXpathLibrary::getScore('2'));
				$responseData['score_robot_age']              = $I->grabTextFrom(\GeneralXpathLibrary::getScore('3'));
				$responseData['score_robot_interest_rate']    = $I->grabTextFrom(\GeneralXpathLibrary::getScore('4'));
				$responseData['score_robot_dist_office_add']  = $I->grabTextFrom(\GeneralXpathLibrary::getScore('5'));
				$responseData['score_robot_province']         = $I->grabTextFrom(\GeneralXpathLibrary::getScore('6'));
				$responseData['score_robot_disburse_date']    = $I->grabTextFrom(\GeneralXpathLibrary::getScore('7'));
				$responseData['score_robot_dpd_no_disb_apps'] = $I->grabTextFrom(\GeneralXpathLibrary::getScore('8'));
				$responseData['score_robot_rejection']        = $I->grabTextFrom(\GeneralXpathLibrary::getScore('9'));
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
}
