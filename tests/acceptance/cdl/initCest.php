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
            'firstname'      => 'Tu',
            'lastname'       => 'Vuong',
            'gender'         => 'M',
            'national_id'    => date('YmdHi'),
            'date_of_issue'  => date('m/d/Y'),
            'date_of_birth'  => date('m/d/Y', strtotime('11/10/1994')),
            'fb_number'      => '#FB' . date('YmdHi'),
            'phone'          => '01652679144',
            'hometown'        => 'Hồ Chí Minh',
            'asset_type' => 'NEW',
            'collateral' => 'P',
            'good_type' => 'DESKTOP',
            'brand' => 'DELL',
            'asset_make' => 'DELL',
            'asset_model' => 'DELL',
            'good_price' => '20000000',
            'collateral_description' => 'DESKTOP DELL',
            'down_payment' => 5000000,
            'tenor' => 8,
            'is_fb_owner' => 'N',
            'education' => 76,
            'marital_status' => 'M',
            'social_status' => 8,
            'main_income' => '35000000',
            'family_income' => '40000000',
            'phone_reference1' => '01652679145',
            'phone_reference2' => '01652679146',
        );
    }

    /**
     * Connect to Oracle.
     *
     * @return  mixed
     */
    public function connectOracle()
    {
        $db = "(DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP)(HOST = 10.30.11.14)(PORT = 1521)))(CONNECT_DATA =(SERVICE_NAME = finnuat4.fecredit.com.vn)))" ;

        // Create connection to Oracle
        $conn = oci_connect("MULCASTRANS", "ANSF1UAT04itdbaBca", $db);

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
    public function executeQuery()
    {
        $connection = $this->connectOracle();
        $query      = "SELECT * FROM AUTOMATION_TEST_CASE";
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
    public function createCDLApplication(AcceptanceTester $I, $scenario)
    {
        $data = $this->executeQuery();

        foreach ($data as $key => $case)
        {
            $I->amOnUrl(\GeneralXpathLibrary::$url);
            $I = new AcceptanceTester\GeneralSteps($scenario);

            $I->wantTo('Login to PEGA UAT');
            $I->loginPega('nhut.le@fecredit.com.vn', 'rules238');

            $I->wantTo('Launch to FE Manager 7');
            $I->launchPortal();

            $I->wantTo('Init data');
            $I->initData($case);

            $I->wantTo('Entry short data');
            $I->shortApplication($case);
            
            $I->wantTo('Documents Stage');
            $I->shortApplicationDocument();

            $I->wantTo('Entry full data');
            $I->fullDataEntry($case);

            $I->wantTo('Data Check');
            $caseId = $I->dataCheck();

            $I->wantTo('Switch Application');
            $I->switchApplication();

            $I->wantTo('Search Application');
            $I->searchApplication($caseId);
        }
    }
}
