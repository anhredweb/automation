<?php
/**
 * @package     FE Credit
 * @subpackage  Automation Testing
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Class init to create CDL Application
 *
 * @since  1.0
 */
class initCest
{
    /**
     * @var  string
     */
    private $defaultData;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->defaultData = array(
            'dealer_code'    => '80000000250',
            'pos_code'       => '600725',
            'product_group'  => '255',
            'product_scheme' => '1019',
        );
    }

    /**
     * Function to login
     *
     * @param   AcceptanceTester  $I         Acceptance Tester case.
     * @param   Scenario          $scenario  Scenario for test.
     *
     * @return  void
     */
    public function createCDLApplication(AcceptanceTester $I, $scenario)
    {
        $I->amOnUrl(\GeneralXpathLibrary::$url);
        $I = new AcceptanceTester\GeneralSteps($scenario);

        $I->wantTo('Login to PEGA UAT');
        $I->loginPega('nhut.le@fecredit.com.vn', 'rules238');

        $I->wantTo('Launch to FE Manager 7');
        $I->launchPortal();

         $I->wantTo('Init data');
         $I->initData($this->defaultData);
    }
}
