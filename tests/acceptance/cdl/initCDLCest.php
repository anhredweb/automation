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
class initCDLCest
{
    /**
     * @var  string
     */
    private $defaultData = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->defaultData = array(
            'DEALER_CODE'            => '80000000250',
            'POS_CODE'               => '600725',
            'PRODUCT_GROUP'          => '255',
            'PRODUCT_SCHEME'         => '1019',
            'GENDER'                 => 'M',
            'NATIONAL_ID'            => date('YmdHi'),
            'DATE_OF_BIRTH'          => date('m/d/Y', strtotime('11/10/1994')),
            'FB_NUMBER'              => '#FB' . date('YmdHi'),
            'PHONE'                  => '01652679144',
            'HOMETOWN'               => 'Hồ Chí Minh',
            'GOOD_TYPE'              => 'DESKTOP',
            'BRAND'                  => 'DELL',
            'ASSET_MAKE'             => 'DELL',
            'ASSET_MODEL'            => 'DELL',
            'GOOD_PRICE'             => '20000000',
            'COLLATERAL_DESCRIPTION' => 'DESKTOP DELL',
            'DOWNPAYMENT'            => 5000000,
            'TENOR'                  => 8,
            'IS_FB_OWNER'            => 'N',
            'EDUCATION'              => 76,
            'MARITAL_STATUS'         => 'M',
            'SOCIAL_STATUS'          => 8,
            'PERSONAL_INCOME'        => '35000000',
            'FAMILY_INCOME'          => '40000000',
            'PHONE_REFERENCE1'       => '01652679145',
            'PHONE_REFERENCE2'       => '01652679146'
        );
    }

    /**
     * Execute Query.
     *
     * @param   AcceptanceTester  $I  Acceptance Tester case.
     *
     * @return  array
     */
    protected function executeQuery($I)
    {
        $connection = $I->connectOracle();
        $query      = "SELECT a.*, to_char(DATE_OF_BIRTH, 'DD/MM/YYYY') AS DATE_OF_BIRTH FROM AUTOMATION_TEST_CASE_CDL a WHERE a.STATUS = 0";
        $stid       = oci_parse($connection, $query);
        oci_execute($stid);
        oci_fetch_all($stid, $data, NULL, NULL, OCI_FETCHSTATEMENT_BY_ROW);

        return $data;
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
        $data = $this->executeQuery($I);

        if (empty($data))
        {
            return;
        }

        $I->amOnUrl(\GeneralXpathLibrary::$url);
        $I = new AcceptanceTester\GeneralCDLSteps($scenario);

        $I->wantTo('Login to PEGA UAT');
        $I->loginPega('nhut.le@fecredit.com.vn', 'rules238');

/*        $I->wantTo('Switch Application to LOS2');
        $I->switchApplicationToLOS2();

        $I->wantTo('Search Application');
        $responseData = $I->searchApplication('CDL-18146');

        if (!empty($responseData))
        {
            $I->wantTo('Update score');
            $I->updateScore($responseData, $this->connectOracle());   

            $I->wantTo('Check score');
            $I->checkScore($responseData, $this->connectOracle());              
        }

        $I->switchToIFrame();
        $I->click(\GeneralXpathLibrary::$closeButton);

        $I->wantTo('Switch Application to Loan');
        $I->switchApplicationToLoan();*/

        foreach ($data as $key => $case)
        {
            $case['NATIONAL_ID'] = date('YmdHi');
            $case = $I->validationData($case);

            $I->wantTo('Launch to FE Manager 7');

            if (!$I->launchPortal($case))
            {
                continue;
            }

            $I->wantTo('Init data');

            if (!$I->initData($case, 'CDL'))
            {
                continue;
            }

            $I->wantTo('Entry short data');

            if (!$I->shortApplication($case))
            {
                continue;
            }
            
            $I->wantTo('Documents Stage');
            $I->shortApplicationDocument();

            $I->wantTo('Entry full data');

            if (!$I->fullDataEntry($case))
            {
                continue;
            }

            $I->wantTo('Data Check');
            $caseId = $I->dataCheck();

            $I->wantTo('Switch Application to LOS2');
            $I->switchApplicationToLOS2();

            $I->wantTo('Search Application');
            $responseData = $I->searchApplication($caseId, 'CDL', $case);

            if (!empty($responseData))
            {
                $I->wantTo('Update score');
                $I->updateScore($responseData, $I->connectOracle());   

                $I->wantTo('Check score');
                $I->checkScore($responseData, $I->connectOracle());              
            }

            $I->switchToIFrame();
            $I->click(\GeneralXpathLibrary::$closeButton);

            $I->wantTo('Switch Application to Loan');
            $I->switchApplicationToLoan();
        }
    }
}
