<?php
/**
 * @package     FE Credit
 * @subpackage  Automation Testing Helper
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Codeception\Lib\ModuleContainer;
use Codeception\Module\WebDriver;
/**
 * Class Helper
 *
 * @since  1.0
 */
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * Connect to Oracle.
     *
     * @return  mixed
     */
    public function connectOracle()
    {
        $db = "(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.30.110.93)(PORT = 1521)))(CONNECT_DATA = (SERVICE_NAME = finnuat5.fecredit.com.vn)))" ;

        // Create connection to Oracle
        return oci_connect("MULCASTRANS", "ANSF1UAT05", $db, 'AL32UTF8');
    }

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

        if ($I->checkElementNotExist(\GeneralXpathLibrary::$errorDiv))
		{
			return;
		}

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
		$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$dealerCodeJS . "').val('" . $data["DEALER_CODE"] . "')");
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
		$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$posCodeJS . "').val('" . $data["POS_CODE"] . "')");
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
		$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$productSchemeJS . "').val('" . $data["PRODUCT_SCHEME"] . "')");
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
	 * @param  array   $data     Data
	 * @param  string  $product  Product
	 *
	 * @return boolean
	 */
	public function shortApplication($data, $product = NULL)
	{
		$I = $this;
		$I->wait(2);

		// $I->click(\GeneralXpathLibrary::$dataCheck);
		// $I->wait(2);
		
		// Click demo data
        $I->click(\GeneralXpathLibrary::$demoDataShortApp);
        $I->wait(2);
        $I->click(\GeneralXpathLibrary::$demoDataG1ShortApp);
        $I->wait(2);

		// Select gender
		$I->selectOption(\GeneralXpathLibrary::$gender, array('value' => $data['GENDER']));
		$I->wait(2);

		// Fill national Id
		$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$nationalId . "').val('" . $data['NATIONAL_ID'] . "')");
		$I->wait(1);

		// Fill date of birth
		$I->fillField(\GeneralXpathLibrary::$dateOfBirth, $data['DATE_OF_BIRTH']);
		$I->wait(2);

		// Fill phone
		$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$phone . "').val('" . $data['PHONE'] . "')");
		$I->wait(2);

		// Select Disbursement Channel
		if ($product == 'PL')
		{
			if (empty($data['DISBURSEMENT_CHANNEL']))
			{
				$data['DISBURSEMENT_CHANNEL'] = 'VNPOST';
			}

			$I->selectOption(\GeneralXpathLibrary::$disbursementChannel, array('value' => $data['DISBURSEMENT_CHANNEL']));
			$I->wait(2);

			if (!empty($data['REQUESTED_AMOUNT']))
	        {
	            $I->fillField(\GeneralXpathLibrary::$requestedAmount, $data["REQUESTED_AMOUNT"]);
	            $I->wait(1);
	            $I->executeJS("return jQuery('" . \GeneralXpathLibrary::$requestedAmountJS . "').val('" . $data["REQUESTED_AMOUNT"] . "').attr('data-value', '" . $data["REQUESTED_AMOUNT"] . "')");
	            $I->wait(2);
	        }
		}

		// Click submit data
		$I->click(\GeneralXpathLibrary::$submitShortApp);
		$I->wait(2);

		return $I->checkError($data['NATIONAL_ID']);
	}

	/**
	 * Function to check documents for Application
	 *
	 * @return boolean
	 */
	public function shortApplicationDocument()
	{
		$I = $this;

		$applicationStatus = $I->grabTextFrom(\GeneralXpathLibrary::$applicationStatus);

		print_r($applicationStatus);

		if (trim($applicationStatus) == 'Resolved-Rejected-Hard' || trim($applicationStatus) == 'Resolved-Rejected-Soft')
		{
			return false;
		}

		// Click Scan and Attach Documents
		$I->click(\GeneralXpathLibrary::$dataCheck);
		$I->wait(2);

		// Click demo data
		$I->wait(2);
		$I->click(\GeneralXpathLibrary::$demoDataDocument);
		$I->wait(1);

		// Click submit data
		$I->click(\GeneralXpathLibrary::$submitDocument);
		$I->wait(2);

		return true;
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
		$faker      = \Faker\Factory::create();
		$I          = $this;
		$nationalId = (int) date('YmdHi');

		//Customer Tab
        $I->click(\GeneralXpathLibrary::getTabId('4'));
        $I->wait(1);

        // Select title
        $title = $data['GENDER'] == 'M' ? 'Mr.' : 'Mrs.';
        $I->selectOption(\GeneralXpathLibrary::$title, array('value' => $title));

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
        }

        if (!empty($data['IS_FB_OWNER']) && $data['IS_FB_OWNER'] == 'N')
        {
            $I->fillField(\GeneralXpathLibrary::$fbOwnerFirstname, str_replace("'", " ", $faker->firstname));
            $I->wait(2);
            $I->click(\GeneralXpathLibrary::$fbOwnerLastname);
            $I->wait(2);
            $I->fillField(\GeneralXpathLibrary::$fbOwnerLastname, str_replace("'", " ", $faker->lastname));
            $I->wait(2);
            $I->selectOption(\GeneralXpathLibrary::$fbOwnerRelationType, array('value' => "O"));
            $I->wait(2);
            $I->fillField(\GeneralXpathLibrary::$fbOwnerNationalId, $nationalId + 1);
            $I->wait(2);
        }

        if ($data['MARITAL_STATUS'] == 'M' || $data['MARITAL_STATUS'] == 'C')
        {
            $I->fillField(\GeneralXpathLibrary::$spouseLastname, str_replace("'", " ", $faker->firstname));
            $I->wait(2);
            $I->click(\GeneralXpathLibrary::$spouseFirstname);
            $I->wait(2);
            $I->fillField(\GeneralXpathLibrary::$spouseFirstname, str_replace("'", " ", $faker->lastname));
            $I->wait(2);
            $spouseGender = $data['GENDER'] == 'M' ? 'F' : 'M';
            $I->selectOption(\GeneralXpathLibrary::$spouseGender, array('value' => $spouseGender));
            $I->wait(2);
            $I->fillField(\GeneralXpathLibrary::$spouseNationalId, $nationalId + 2);
            $I->wait(2);
        }

        // Contacts Tab
        if (!empty($data['HOMETOWN']))
        {
        	$I->click(\GeneralXpathLibrary::getTabId('6'));
        	$I->wait(2);

            $I->click(\GeneralXpathLibrary::$currentAddressRow);
            $I->wait(2);

        	$I->click(\GeneralXpathLibrary::$province);
			$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$provinceJS . "').val('" . $data['HOMETOWN'] . "')");
			$I->wait(2);
			$I->pressKey(\GeneralXpathLibrary::$province, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
			$I->wait(1);
			$I->click(\GeneralXpathLibrary::$rowProvince);
			$I->wait(2);

			$I->click(\GeneralXpathLibrary::$district);
			$I->wait(2);
			$I->pressKey(\GeneralXpathLibrary::$district, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
			$I->wait(1);
			$I->click(\GeneralXpathLibrary::$rowDistrict);
			$I->wait(2);

			$I->click(\GeneralXpathLibrary::$ward);
			$I->wait(2);
			$I->pressKey(\GeneralXpathLibrary::$ward, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
			$I->wait(1);
			$I->click(\GeneralXpathLibrary::$rowWard);
			$I->wait(2);
        }

        // Work Tab
        if ((isset($data['YEAR_IN_CURR_JOB']) && (int) $data['YEAR_IN_CURR_JOB'] >= 0) || !empty($data['COMP_TAX_CODE']))
        {
        	$I->click(\GeneralXpathLibrary::getTabId('7'));
            $I->wait(2);

            if (!empty($data['COMP_TAX_CODE']) && $data['COMP_TAX_CODE'] != '000-000-111-999')
            {
            	$I->click(\GeneralXpathLibrary::$compTaxCode);
				$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$compTaxCodeJS . "').val('').val('" . $data["COMP_TAX_CODE"] . "')");
				$I->wait(2);
				$I->pressKey(\GeneralXpathLibrary::$compTaxCode, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
				$I->wait(2);
				$I->click(\GeneralXpathLibrary::$rowCompTaxCode);
				$I->wait(1);
            }

            // Fill year in current job
            if (isset($data['YEAR_IN_CURR_JOB']) && (int) $data['YEAR_IN_CURR_JOB'] >= 0)
            {
				$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$yearCurrJob . "').val('" . $data['YEAR_IN_CURR_JOB'] . "')");
				$I->wait(1);
				$I->selectOption(\GeneralXpathLibrary::$monthPrevJob, array('value' => 0));
				$I->wait(1);
            }
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
     * Function to Rework Add Documentations
     *
     * @return void
     */
	public function PendingReworkAddDoc()
	{
		$I = $this;

		// Click Pending Rework AddDoc
		$I->click(\GeneralXpathLibrary::$dataCheck);
		$I->wait(2);

		// Click Demo data
		$I->click(\GeneralXpathLibrary::$reworkDemoData);
        $I->wait(2);

        // Click Submit
        $I->click(\GeneralXpathLibrary::$reworkSubmit);
        $I->wait(2);
	}

	/**
	 * Function to data check for Application
	 *
	 * @param  string  $product  Product
	 * @param  array   $data     Data
	 *
	 * @return string
	 */
	public function dataCheck($product = NULL, $data = array())
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
		$I->selectOption(\GeneralXpathLibrary::$cicResult, array("value" => "Ok"));
		$I->wait(1);

		if ($product == 'PL')
		{
	        $data['CIC_DESCRIPTION'] = empty($data['CIC_DESCRIPTION']) ? $data['CIC_DESCRIPTION'] : 'NULL';
	        $data['PCB_DESCRIPTION'] = empty($data['PCB_DESCRIPTION']) ? $data['PCB_DESCRIPTION'] : 'NULL';

			// Click Add item to add CIC
			$I->click(\GeneralXpathLibrary::$cicAddItem);
			$I->wait(2);

			// Fill field National ID
			$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$cicNationalId . "').val('" . $data["NATIONAL_ID"] . "')");
			$I->wait(2);

			// Fill field Comment
			$I->fillField(\GeneralXpathLibrary::$cicComment, $data['CIC_DESCRIPTION']);
			$I->wait(2);

			// Click Save
			$I->click(\GeneralXpathLibrary::$cicSaveButton);
			$I->wait(2);

			// Click Add item to add PCB
			$I->click(\GeneralXpathLibrary::$cicAddItem);
			$I->wait(2);

			// Fill field National ID
			$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$cicNationalId . "').val('" . $data["NATIONAL_ID"] . "')");
			$I->wait(2);

			// Fill field Comment
			$I->fillField(\GeneralXpathLibrary::$cicComment, $data['PCB_DESCRIPTION']);
			$I->wait(2);

			// Click Save
			$I->click(\GeneralXpathLibrary::$cicSaveButton);
			$I->wait(2);

			// Select Number of relationship from CIC
			if (!empty($data['NUMBER_OF_REL_CIC']))
			{
				$I->selectOption(\GeneralXpathLibrary::$numberOfRelationshipCIC, array("value" => $data['NUMBER_OF_REL_CIC']));
				$I->wait(1);
			}

			// Select Number of relationship from PCB
			if (!empty($data['NUMBER_OF_REL_PCB']))
			{
				$I->selectOption(\GeneralXpathLibrary::$numberOfRelationshipPCB, array("value" => $data['NUMBER_OF_REL_PCB']));
				$I->wait(1);
			}

			// Click PCB tab and select PCB result
			$I->click(\GeneralXpathLibrary::$pcbTab);
			$I->selectOption(\GeneralXpathLibrary::$pcbResult, array("value" => "PCB OK"));
			$I->wait(1);
		}

		// Click submit data
		$I->click(\GeneralXpathLibrary::$submitDataCheck);
		$I->wait(1);
		$I->click(\GeneralXpathLibrary::$okDataCheck);
		$I->wait(5);

		$caseId = $I->grabTextFrom(\GeneralXpathLibrary::$caseId);
		$caseId = str_replace('(', '', $caseId);
		$caseId = str_replace(')', '', $caseId);

		$applicationStatus = $I->grabTextFrom(\GeneralXpathLibrary::$applicationStatus);

		if (trim($applicationStatus) == 'Resolved-Rejected-Hard' || trim($applicationStatus) == 'Resolved-Rejected-Soft')
		{
			return '';
		}

		print_r($applicationStatus);

		return $caseId;
	}

	/**
	 * Function to phone verification
	 *
	 * @param  array   $data     Data
	 * @param  string  $product  Product type
	 *
	 * @return boolean
	 */
	public function phoneVerification($data, $product = NULL)
	{
		$I = $this;
		$checkError = $I->checkError($data['NATIONAL_ID']);

		if (!$checkError)
		{
			return false;
		}

		$applicationStatus = $I->grabTextFrom(\GeneralXpathLibrary::$applicationStatus);

		if (trim($applicationStatus) == 'Resolved-Rejected-Hard' || trim($applicationStatus) == 'Resolved-Rejected-Soft' || trim($applicationStatus) == 'Pending-DC')
		{
			return false;
		}

		// Click Phone verification
		$I->click(\GeneralXpathLibrary::$phoneVerification);
		$I->wait(2);

		// Select call result
		$I->selectOption(\GeneralXpathLibrary::$callResult, array("value" => "Not responding"));
		$I->wait(2);

		// Switch to Edit App tab
		$I->click(\GeneralXpathLibrary::getPhoneTabId('3'));
		$I->wait(2);

		// Click to main income toggle
		$I->click(\GeneralXpathLibrary::$phoneIncomeField);
		$I->wait(2);

		// Click to main income input
		$I->click(\GeneralXpathLibrary::$phoneMainIncome);
		$I->wait(2);
		$I->click(\GeneralXpathLibrary::$phoneMainIncomeInput);
		$I->wait(1);
        $I->fillField(\GeneralXpathLibrary::$phoneMainIncomeInput, $data["PERSONAL_INCOME"]);
        $I->wait(1);
        // $I->executeJS('return jQuery("input#NetAmount3").attr("data-value", "' . $data["PERSONAL_INCOME"] . '").val("' . $data["PERSONAL_INCOME"] . '")');
        $I->click(\GeneralXpathLibrary::getPhoneTabId('3'));
        $I->wait(2);

        // Select Phone result
		$I->selectOption(\GeneralXpathLibrary::$phoneResult, array("value" => "Negative"));
		$I->wait(2);

		// Select Phone reason
		$I->selectOption(\GeneralXpathLibrary::$phoneReason, array("value" => "RJ01"));
		$I->wait(2);

		// Select Phone subreason
		$I->selectOption(\GeneralXpathLibrary::$phoneSubReason, array("value" => "RJ01-01"));
		$I->wait(2);

		// Submit
		$I->click(\GeneralXpathLibrary::$phoneSubmit);
		$I->wait(5);

		$I->click(\GeneralXpathLibrary::$loanCloseButton);
		$I->wait(1);

		return $I->checkError($data['NATIONAL_ID']);
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
	 * @return array
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

		$applicationStatus = $I->grabTextFrom(\GeneralXpathLibrary::$applicationStatus);

		if (trim($applicationStatus) == 'Resolved-Rejected-Hard' || trim($applicationStatus) == 'Resolved-Rejected-Soft' || trim($applicationStatus) == 'Pending-DC')
		{
			return array();
		}

		$responseData = array();
		$caseId = $I->grabTextFrom(\GeneralXpathLibrary::$caseId);
		$caseId = str_replace("(", "", $caseId);
		$caseId = str_replace(")", "", $caseId);
		$responseData['case_id']        = $caseId;
		$responseData['application_id'] = $I->grabTextFrom(\GeneralXpathLibrary::$applicationId);
		$responseData['national_id']    = $I->grabTextFrom(\GeneralXpathLibrary::$nationalIdScoring);

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
				$responseData['robot_sub_segment']               = $I->grabTextFrom(\GeneralXpathLibrary::$subSegment);
				$responseData['robot_lead_black']                = $I->grabTextFrom(\GeneralXpathLibrary::$leadBlack);
				$responseData['robot_product_score_group']       = $I->grabTextFrom(\GeneralXpathLibrary::$productScoreGroup);
				$responseData['score_robot_age']                 = $I->grabTextFrom(\GeneralXpathLibrary::getScore('1'));
				$responseData['score_robot_cic_relationship']    = $I->grabTextFrom(\GeneralXpathLibrary::getScore('2'));
				$responseData['score_robot_company']             = $I->grabTextFrom(\GeneralXpathLibrary::getScore('3'));
				$responseData['score_robot_pre_of_work_exp']     = $I->grabTextFrom(\GeneralXpathLibrary::getScore('4'));
				$responseData['score_robot_cust_social_trust']   = $I->grabTextFrom(\GeneralXpathLibrary::getScore('5'));
				$responseData['score_robot_disb_apps']           = $I->grabTextFrom(\GeneralXpathLibrary::getScore('6'));
				$responseData['score_robot_dsa']                 = $I->grabTextFrom(\GeneralXpathLibrary::getScore('7'));
				$responseData['score_robot_education']           = $I->grabTextFrom(\GeneralXpathLibrary::getScore('8'));
				$responseData['score_robot_gender']              = $I->grabTextFrom(\GeneralXpathLibrary::getScore('9'));
				$responseData['score_robot_marital_status']      = $I->grabTextFrom(\GeneralXpathLibrary::getScore('10'));
				$responseData['score_robot_hometown']            = $I->grabTextFrom(\GeneralXpathLibrary::getScore('11'));
				$responseData['score_robot_rejected_apps']       = $I->grabTextFrom(\GeneralXpathLibrary::getScore('12'));
				$responseData['score_robot_ts_apply_days']       = $I->grabTextFrom(\GeneralXpathLibrary::getScore('13'));
				break;
		}

		$I->wait(3);

		print_r($responseData);

		return $responseData;
	}

	/**
	 * Function to switch Application to Loan
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
