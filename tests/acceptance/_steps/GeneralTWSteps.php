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
class GeneralTWSteps extends \AcceptanceTester
{
	/**
     * Function to launch to FECase Manager to Create Application
     *
     * @param  array  $data  Data
     *
     * @return  boolean
     */
	public function launchPortal($data)
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

        if ($I->checkElementNotExist(\GeneralXpathLibrary::$createButton))
		{
			$I->skipTestCase($data['NATIONAL_ID']);

			return false;
		}

		$I->click(\GeneralXpathLibrary::$createButton);

		$I->waitForElement(\GeneralXpathLibrary::$TWApplication, 2);
	    $I->click(\GeneralXpathLibrary::$TWApplication);

	    return true;
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
		$faker     = \Faker\Factory::create();
		$firstname = $faker->firstname;
		$lastname  = $faker->lastname;
		$I         = $this;

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

		if (!empty($data['BRAND']))
		{
			// Fill good brand
			$I->click(\GeneralXpathLibrary::$brand);
			$I->wait(2);
			$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$brandJS . "').val('').val('" . $data["BRAND"] . "')");
			$I->wait(2);
			$I->pressKey(\GeneralXpathLibrary::$brand, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowBrand);
			$I->wait(1);

			// Fill asset make
			$I->click(\GeneralXpathLibrary::$assetMake);
			$I->wait(2);
			$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$assetMakeJS . "').val('').val('" . $data["ASSET_MAKE"] . "')");
			$I->wait(2);
			$I->pressKey(\GeneralXpathLibrary::$assetMake, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowAssetMake);
			$I->wait(1);

			// Fill asset model
			$I->click(\GeneralXpathLibrary::$assetModel);
			$I->wait(2);
			$I->executeJS("return jQuery('" . \GeneralXpathLibrary::$assetModelJS . "').val('').val('" . $data["ASSET_MODEL"] . "')");
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
			$I->fillField(\GeneralXpathLibrary::$fbOwnerFirstname, $firstname);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$fbOwnerLastname);
			$I->wait(2);
			$I->fillField(\GeneralXpathLibrary::$fbOwnerLastname, $lastname);
			$I->wait(2);
			$I->selectOption(\GeneralXpathLibrary::$fbOwnerRelationType, array('value' => "O"));
			$I->wait(2);
			$I->fillField(\GeneralXpathLibrary::$fbOwnerNationalId, $nationalId + 1);
			$I->wait(2);
		}

		if ($data['MARITAL_STATUS'] == 'M' || $data['MARITAL_STATUS'] == 'C')
		{
			$I->fillField(\GeneralXpathLibrary::$spouseLastname, $firstname);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$spouseFirstname);
			$I->wait(2);
			$I->fillField(\GeneralXpathLibrary::$spouseFirstname, $lastname);
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
			$I->executeJS('return jQuery(document).find("input#NetAmount1").attr("data-value", "0").val("0").attr("data-value", "' . $data["PERSONAL_INCOME"] . '").val("' . $data["PERSONAL_INCOME"] . '")');
			$I->click(\GeneralXpathLibrary::getTabId('8'));

			// Fill family income
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$rowFamilyIncome);
			$I->wait(2);
			$I->click(\GeneralXpathLibrary::$familyIncome);
			$I->waitForElement(\GeneralXpathLibrary::$familyIncome, 2);
			$I->fillField(\GeneralXpathLibrary::$familyIncome, $data["FAMILY_INCOME"]);
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

		// Check error messages
		$I->dontSeeElement(\GeneralXpathLibrary::$errorMessageTable);
        $I->wait(2);

        return $I->checkError($data['NATIONAL_ID']);
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

		$query = "UPDATE AUTOMATION_TEST_CASE_TW SET " . implode(',', $setQuery) . " WHERE NATIONAL_ID = " . $nationalId;
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
			'SCORE_USER_REJECT_APPS',
			'SCORE_USER_MARITAL_STATUS',
			'SCORE_USER_DPD_EVER',
			'SCORE_USER_TENOR',
			'SCORE_USER_POS_PERFORMANCE',
			'SCORE_USER_POS_ADDRESS',
			'SCORE_USER_PERMANENT_ADDRESS',
			'SCORE_USER_EDUCATION_WORK',
			'SCORE_USER_DOWN_PAYMENT_RATE',
			'SCORE_USER_FB_OWNER_GENDER',
			'SCORE_USER_CUSTOMERAGE',
			'TOTAL_SCORE',
			'SCORE_GROUP',
			'RANDOM_NUMBER'
		);
		$selectCheckQuery = array(
			'SCORE_CHECK_GENDER_AND_AGE'    => "'F'",
			'SCORE_CHECK_REJECT_APPS'       => "'F'",
			'SCORE_CHECK_MARITAL_STATUS'    => "'F'",
			'SCORE_CHECK_DPD_EVER'          => "'F'",
			'SCORE_CHECK_TENOR'             => "'F'",
			'SCORE_CHECK_POS_PERFORMANCE'   => "'F'",
			'SCORE_CHECK_POS_ADDRESS'       => "'F'",
			'SCORE_CHECK_PERMANENT_ADDRESS' => "'F'",
			'SCORE_CHECK_EDUCATION_WORK'    => "'F'",
			'SCORE_CHECK_DOWN_PAYMENT_RATE' => "'F'",
			'SCORE_CHECK_FB_OWNER_GENDER'   => "'F'",
			'SCORE_CHECK_CUSTOMERAGE'       => "'F'",
			'CHECK_TOTAL_SCORE'             => "'F'",
			'CHECK_SCORE_GROUP'             => "'F'",
			'CHECK_RANDOM_NUMBER'           => "'F'"
		);
        $query      = "SELECT " . implode(',', $selectScoreQuery) . " FROM AUTOMATION_TEST_CASE_TW WHERE NATIONAL_ID = " . $data['national_id'];
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
        	elseif ($column == 'SCORE_USER_REJECT_APPS' && $score == $data['score_robot_reject_apps'])
        	{
        		$selectCheckQuery['SCORE_CHECK_REJECT_APPS'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_MARITAL_STATUS' && $score == $data['score_robot_marital_status'])
        	{
        		$selectCheckQuery['SCORE_CHECK_MARITAL_STATUS'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_DPD_EVER' && $score == $data['score_robot_dpd_ever'])
        	{
        		$selectCheckQuery['SCORE_CHECK_DPD_EVER'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_TENOR' && $score == $data['score_robot_tenor'])
        	{
        		$selectCheckQuery['SCORE_CHECK_TENOR'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_POS_PERFORMANCE' && $score == $data['score_robot_pos_performance'])
        	{
        		$selectCheckQuery['SCORE_CHECK_POS_PERFORMANCE'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_POS_ADDRESS' && $score == $data['score_robot_pos_address'])
        	{
        		$selectCheckQuery['SCORE_CHECK_POS_ADDRESS'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_PERMANENT_ADDRESS' && $score == $data['score_robot_permanent_address'])
        	{
        		$selectCheckQuery['SCORE_CHECK_PERMANENT_ADDRESS'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_EDUCATION_WORK' && $score == $data['score_robot_education_work'])
        	{
        		$selectCheckQuery['SCORE_CHECK_EDUCATION_AND_WORK_EXPERIENCE'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_DOWN_PAYMENT_RATE' && $score == $data['score_robot_down_payment_rate'])
        	{
        		$selectCheckQuery['SCORE_CHECK_DOWN_PAYMENT_RATE'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_FB_OWNER_GENDER' && $score == $data['score_robot_fb_owner_gender'])
        	{
        		$selectCheckQuery['SCORE_CHECK_FB_OWNER_GENDER'] = "'P'";
        	}
        	elseif ($column == 'SCORE_USER_CUSTOMERAGE' && $score == $data['score_robot_customerage'])
        	{
        		$selectCheckQuery['SCORE_CHECK_CUSTOMERAGE'] = "'P'";
        	}
        	elseif ($column == 'TOTAL_SCORE' && $score == $data['robot_total_score'])
        	{
        		$selectCheckQuery['CHECK_TOTAL_SCORE'] = "'P'";
        	}
        	elseif ($column == 'SCORE_GROUP' && $score == $data['robot_score_group'])
        	{
        		$selectCheckQuery['CHECK_SCORE_GROUP'] = "'P'";
        	}
        	elseif ($column == 'RANDOM_NUMBER' && $score == $data['robot_random_number'])
        	{
        		$selectCheckQuery['CHECK_RANDOM_NUMBER'] = "'P'";
        	}
        }

        $selectedCheckQuery = array();

        foreach ($selectCheckQuery as $column => $value)
        {
        	$selectedCheckQuery[] = $column . ' = ' . $value;
        }

        $query = "UPDATE AUTOMATION_TEST_CASE_TW SET " . implode(',', $selectedCheckQuery) . " WHERE NATIONAL_ID = " . $data['national_id'];
		$stid  = oci_parse($connection, $query);
        oci_execute($stid);
        oci_commit($connection);

       	return true;
	}
}
