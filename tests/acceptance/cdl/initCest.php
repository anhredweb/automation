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
        $conn = oci_connect('MULCASTRANS', 'ANSF1UAT04itdbaBca', 'FINNUAT4');

echo '<pre>';
print_r($conn);
echo '</pre>';
die;

        if (!$conn) 
        {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        $this->defaultData = array(
            'dealer_code'    => '80000000250',
            'pos_code'       => '600725',
            'product_group'  => '255',
            'product_scheme' => '1019',
            'firstname'      => 'Tu',
            'lastname'       => 'Vuong',
            'gender'         => 'M',
            'national_id'    => date('YmdHi'),
            'date_of_issue'  => date('m/d/Y'),
            'date_of_birth'  => date('m/d/Y', strtotime('11/10/1994')),
            'fb_number'      => '#FB' . date('YmdHi'),
            'phone'          => '01652679144',
            'hometown'        => 'Hồ Chí Minh'
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
        $I->seeInDatabase('MULCASTRANS.LOS_APP_APPLICATIONS', array());

        /*$I->amOnUrl(\GeneralXpathLibrary::$url);
        $I = new AcceptanceTester\GeneralSteps($scenario);

        $I->wantTo('Login to PEGA UAT');
        $I->loginPega('nhut.le@fecredit.com.vn', 'rules238');

        $I->wantTo('Launch to FE Manager 7');
        $I->launchPortal();

        $I->wantTo('Init data');
        $I->initData($this->defaultData);

        $I->wantTo('Entry short data');
        $I->shortApplication($this->defaultData);*/
    }
}
