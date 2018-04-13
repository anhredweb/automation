<?php
/**
 * @package     FE Credit
 * @subpackage  Automation Testing
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Class init to create PL Application
 *
 * @since  1.0
 */
class initPLCest
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
            'PRODUCT_GROUP'          => 'NEW TO BANK',
            'PRODUCT_SCHEME'         => 'UP CAT C - 306',
            'DSA_CODE'               => 'BAD00002',
            'GENDER'                 => 'M',
            'NATIONAL_ID'            => date('YmdHi'),
            'DATE_OF_BIRTH'          => date('m/d/Y', strtotime('11/10/1994')),
            'FB_NUMBER'              => '#FB' . date('YmdHi'),
            'PHONE'                  => '01652679144',
            'HOMETOWN'               => 'Hồ Chí Minh',
            'DISBURSEMENT_CHANNEL'   => 'VNPOST',
            'REQUESTED_AMOUNT'       => '19000000',
            'TENOR'                  => 7,
            'LOAN_PURPOSE'           => 'Other',
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
        $query      = "SELECT a.*, to_char(DATE_OF_BIRTH, 'MM/DD/YYYY') AS DATE_OF_BIRTH FROM AUTOMATION_TEST_CASE_PL a WHERE SUB_SEGMENT = 'NTB_S2' AND IS_RUN = 0";
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
    public function createPLApplication(AcceptanceTester $I, $scenario)
    {
        $data = $this->executeQuery($I);

        if (empty($data))
        {
            return;
        }

        $I->amOnUrl(\GeneralXpathLibrary::$url);
        $I = new AcceptanceTester\GeneralPLSteps($scenario);

        $I->wantTo('Login to PEGA UAT');
        $I->loginPega('tu.vuong@fecredit.com.vn', 'rules');

        $I->wantTo('Check session message');
        $I->checkSessionMessage();

        // Only Search Applications and update to DB
/*        $I->wantTo('Switch Application to LOS2');
        $I->switchApplicationToLOS2();

        foreach ($data as $key => $case)
        {
            $I->wantTo('Search Application');
            $responseData = $I->searchApplication($case['CASE_ID'], 'PL', $case);

            if (!empty($responseData))
            {
                $I->wantTo('Update score');
                $I->updateScore($responseData, $I->connectOracle());   

                $I->wantTo('Check score');
                $I->checkScore($responseData, $I->connectOracle());              
            }

            print_r('Update successfull');

            $I->switchToIFrame();
            continue;
        }*/

        // Process flow
        foreach ($data as $key => $case)
        {
            $case = $I->validationData($case);

            $I->wantTo('Launch to FE Manager 7');

            if (!$I->launchPortal($case))
            {
                continue;
            }

            $tempNationalId = (int) date('YmdHi') + (int) $key;

            $case['TEMP_NATIONAL_ID'] = $tempNationalId;
            $I->updateNationalId($case, $I->connectOracle());
            $case['NATIONAL_ID'] = $case['TEMP_NATIONAL_ID'];

            $I->wantTo('Init data');

            if (!$I->initPLData($case, 'TW'))
            {
                continue;
            }

            $I->wantTo('Entry short data');

            if (!$I->shortApplication($case, 'PL'))
            {
                continue;
            }

            $I->wantTo('Update is run');
            $I->updateIsRun($case, $I->connectOracle());
            
            $I->wantTo('Check documents');

            if (!$I->shortApplicationDocumentPL())
            {
                continue;
            }

            $I->wantTo('Entry full data');
            $I->fullDataEntry($case);

            $applicationStatus = $I->grabTextFrom(\GeneralXpathLibrary::$applicationStatus);

            if (trim($applicationStatus) == 'Pending-Rework-AddDoc')
            {
                $I->PendingReworkAddDoc();
            }

            $I->wantTo('Check data');
            $caseId = $I->dataCheck('PL', $case);

            if ($caseId == '')
            {
                continue;
            }

            /*$I->wantTo('Phone Verification');

            if (!$I->phoneVerification($case, 'PL'))
            {
                continue;
            }*/

            $I->wantTo('Switch Application to LOS2');
            $I->switchApplicationToLOS2();

            $I->wantTo('Search Application');
            $responseData = $I->searchApplication($caseId, 'PL', $case);

            if (!empty($responseData))
            {
                $I->wantTo('Update score');
                $I->updateScore($responseData, $I->connectOracle());   

                $I->wantTo('Check score');
                $I->checkScore($responseData, $I->connectOracle());              
            }

            $I->switchToIFrame();
            //$I->click(\GeneralXpathLibrary::$closeButton);

            $I->wantTo('Switch Application to Loan');
            $I->switchApplicationToLoan();
        }
    }
}
