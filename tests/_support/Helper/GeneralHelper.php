<?php
/**
 * @package     FE Credit
 * @subpackage  Automation Testing Helper
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Helper;
/**
 * Class Helper
 *
 * @since  1.0
 */
class GeneralHelper extends \Codeception\Module
{
	/**
	 * Function to check element is not existed
	 *
	 * @param  string  $element  Element
	 *
	 * @return boolean
	 */
	public function checkElementNotExist($element)
	{
		$I = $this->getModule('WebDriver');
		// $elementExist = $webDriver->_findElements($element);
		$elementExist = array_filter($I->grabMultiple($element));
		print_r($elementExist);

		if (empty($elementExist))
		{
			return true;
		}
        
        return false;
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
		$I = $this->getModule('WebDriver');
		$errors = array_filter($I->grabMultiple(\GeneralXpathLibrary::$errorMessage));

		if (empty($errors))
		{
			return true;
		}
        
       	$I->skipTestCase($imageName);
        
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
		$I = $this->getModule('WebDriver');
		$I->makeScreenshot($imageName . '_' . time());
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
	 * @return array
	 */
	public function validationData($data)
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

		return $data;
	}
}
