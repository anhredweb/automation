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
		$element = $this->getModule('WebDriver')->_findElements($element);

		print_r($element);

		if (empty($element))
		{
			return true;
		}
        
        return false;
	}
}
