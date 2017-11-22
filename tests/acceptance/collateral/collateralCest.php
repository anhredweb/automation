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
class collateralCest
{
    /**
     * Connect to Oracle.
     *
     * @return  mixed
     */
    protected function connectOracle()
    {
        $db = "(DESCRIPTION =
    (LOAD_BALANCE=YES)
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = ods-scan)(PORT = 1521))
    )
    (CONNECT_DATA =
      (SERVICE_NAME = dwproddc)
    )
  )" ;

        // Create connection to Oracle
        $conn = oci_connect("COMMON", "Common_Risk_0616", $db, 'AL32UTF8');

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
        $query      = "SELECT * FROM MONITOR_PEGA_TEMP_CDL_COLLATERAL WHERE LAC_COLLATERAL_DESC_C IS NULL";
        $stid       = oci_parse($connection, $query);
        oci_execute($stid);
        $rows = oci_fetch_all($stid, $data, NULL, NULL, OCI_FETCHSTATEMENT_BY_ROW);

        return $data;
    }

    /**
     * Function to search collateral description
     *
     * @param   AcceptanceTester  $I         Acceptance Tester case.
     * @param   Scenario          $scenario  Scenario for test.
     *
     * @return  void
     */
    public function searchCollateralDescription(AcceptanceTester $I, $scenario)
    {
        $connection = $this->connectOracle();
        $data       = $this->executeQuery();

        $I->amOnUrl(\CollateralXpathLibrary::$url);
        $I = new AcceptanceTester\GeneralSteps($scenario);

        $I->wantTo('Login to PEGA UAT');
        $I->loginPega('tu.vuong@fecredit.com.vn', 'Th4ts373n');

        $I = new AcceptanceTester\CollateralSteps($scenario);

        $close = $I->grabTextFrom(\CollateralXpathLibrary::$closeButton);

        if ($close == 'Close')
        {
            $I->click(\CollateralXpathLibrary::$closeButton);
        }

        $I->switchWorkPool();

        foreach ($data as $key => $application)
        {
            if ($application['LAC_COLLATERAL_DESC_C'] != '')
            {
                continue;
            }

            $I->wait(2);
            $I->wantTo('Search collateral description');
            $result = $I->searchColaterral($application['PEGA_APPID']);
            $I->wait(2);
            $I->switchToIFrame();

            if ($result['result'] != 1)
            {
                $query = "UPDATE MONITOR_PEGA_TEMP_CDL_COLLATERAL SET LAC_COLLATERAL_DESC_C = 'XXX' WHERE PEGA_APPID = '" . $application['PEGA_APPID'] . "'";
                $stid  = oci_parse($connection, $query);
                oci_execute($stid);
                oci_commit($connection);
                continue;
            }

            $collateralDescription = str_replace("'", '"', $result['collateral_description']);

            $query = "UPDATE MONITOR_PEGA_TEMP_CDL_COLLATERAL SET LAC_COLLATERAL_DESC_C = '" . $collateralDescription . "' WHERE PEGA_APPID = '" . $application['PEGA_APPID'] . "'";
            echo $query;
            $stid  = oci_parse($connection, $query);
            oci_execute($stid);
            oci_commit($connection);
        }
    }
}
