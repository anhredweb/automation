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
    private $defaultData;

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
            'GOOD_PRICE'             => '36000000',
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
            'PHONE_REFERENCE2'       => '01652679146',
        );
    }

    /**
     * Connect to Oracle.
     *
     * @return  mixed
     */
    protected function connectOracle()
    {
        $db = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = 10.30.11.14)(PORT = 1521)))(CONNECT_DATA =(SERVICE_NAME = finnuat4.fecredit.com.vn)))" ;

        // Create connection to Oracle
        $conn = oci_connect("MULCASTRANS", "ANSF1UAT04itdbaBca", $db, 'AL32UTF8');

        if (!$conn) 
        {
            $m = oci_error();
            return $m['message'];
        }

        return $conn;
    }

     /**
     * Execute Query.
     *
     * @return  array
     */
    protected function executeQuery()
    {
        $connection = $this->connectOracle();
        $query      = "SELECT a.*, to_char(DATE_OF_BIRTH, 'DD/MM/YYYY') AS DATE_OF_BIRTH, to_char(PHONE, '0000000000') AS PHONE, to_char(PHONE_REFERENCE1, '0000000000') AS PHONE_REFERENCE1, to_char(PHONE_REFERENCE2, '0000000000') AS PHONE_REFERENCE2 FROM AUTOMATION_TEST_CASE_PL a WHERE a.STATUS = 0";
        $stid       = oci_parse($connection, $query);
        oci_execute($stid);
        $rows = oci_fetch_all($stid, $data, NULL, NULL, OCI_FETCHSTATEMENT_BY_ROW);

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
        // $data = $this->executeQuery();
        $data = array($this->defaultData);

        if (empty($data))
        {
            return true;
        }

        $I->amOnUrl(\GeneralXpathLibrary::$url);
        $I = new AcceptanceTester\GeneralPLSteps($scenario);

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
            $I->validationData($case);

            $I->wantTo('Launch to FE Manager 7');

            if (!$I->launchPortal($case))
            {
                continue;
            }

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
            
            $I->wantTo('Documents Stage');
            $I->shortApplicationDocumentPL();

            $I->wantTo('Entry full data');

            if (!$I->fullDataEntryPL($case))
            {
                continue;
            }

            $I->wantTo('Data Check');
            $caseId = $I->dataCheck('PL');

            $I->wantTo('Switch Application to LOS2');
            $I->switchApplicationToLOS2();

            $I->wantTo('Search Application');
            $responseData = $I->searchApplication($caseId, 'TW');

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
            $I->switchApplicationToLoan();
        }
    }
}