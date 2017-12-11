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
		$webDriver = $this->getModule('WebDriver');
		// $elementExist = $webDriver->_findElements($element);
		$elementExist = array_filter($webDriver->grabMultiple($element));
		print_r($elementExist);
		// print_r($element1);

		if (empty($elementExist))
		{
			return true;
		}
        
        return false;
	}
}
