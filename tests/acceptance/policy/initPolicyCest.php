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
class initPolicyCest
{
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
        $query      = "SELECT d.ITEM_ID, d.SEQ_ID, d.STAGE,
                (SELECT FLD_NM_PEGA FROM TPEGA_AUTO_RUN_FLD_MAPPING where FLD_TYP = 'STAGE' AND FLD_NM = d.STAGE) STAGE_PEGA,
                d.FLD_NM,
                (SELECT FLD_NM_PEGA FROM TPEGA_AUTO_RUN_FLD_MAPPING where FLD_TYP = 'FLD' AND FLD_NM = d.FLD_NM) FLD_NM_PEGA,
                (SELECT FLD_TYP_PEGA FROM TPEGA_AUTO_RUN_FLD_MAPPING where FLD_TYP = 'FLD' AND FLD_NM = d.FLD_NM) FLD_TYP_PEGA,
                (SELECT FLD_TAB FROM TPEGA_AUTO_RUN_FLD_MAPPING where FLD_TYP = 'FLD' AND FLD_NM = d.FLD_NM) FLD_TAB,
                d.FLD_VALU, d.TRXN_DT, m.CASE_ID, m.APP_ID , m.PRODUCT, m.SCHEME_ID, m.ID_NO1, m.ID_NO2, m.CURR_STAGE
                FROM TPEGA_AUTO_RUN_MASTER m
                LEFT JOIN TPEGA_AUTO_RUN_DETAILS d ON m.ITEM_ID = d.ITEM_ID
                WHERE m.CASE_ID IS NULL
                ORDER BY d.ITEM_ID, d.SEQ_ID";
        $stid       = oci_parse($connection, $query);
        oci_execute($stid);
        oci_fetch_all($stid, $data, NULL, NULL, OCI_FETCHSTATEMENT_BY_ROW);

        return $data;
    }

    /**
     * Execute Query.
     *
     * @param   AcceptanceTester  $I  Acceptance Tester case.
     *
     * @return  array
     */
    protected function executeQueryCaseId($I)
    {
        $connection = $I->connectOracle();
        $query      = "SELECT CASE_ID, PRODUCT, APP_ID FROM TPEGA_AUTO_RUN_MASTER WHERE CASE_ID IS NOT NULL AND COMP_DT IS NULL";
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
    public function updateApplication(AcceptanceTester $I, $scenario)
    {
        $data = $this->executeQueryCaseId($I);

        if (empty($data))
        {
            return;
        }

        $I->amOnUrl(\GeneralXpathLibrary::$url);
        $I = new AcceptanceTester\GeneralPolicySteps($scenario);

        $I->wantTo('Login to PEGA UAT');
        $I->loginPega('tu.vuong@fecredit.com.vn', 'rules');

        $I->wantTo('Check session message');
        $I->checkSessionMessage();

        // Only Search Applications and update to DB
        $I->wantTo('Switch Application to LOS2');
        $I->switchApplicationToLOS2();

        foreach ($data as $key => $case)
        {
            $I->wantTo('Search Application');
            $responseData = $I->searchPolicyApplication($case);

            if (!empty($responseData))
            {
                $I->wantTo('Update score');
                $I->updatePreScoring($responseData, $I->connectOracle());          
            }

            print_r('Update successfull');

            $I->switchToIFrame();
            continue;
        }
    }

    /**
     * Function to login
     *
     * @param   AcceptanceTester  $I         Acceptance Tester case.
     * @param   Scenario          $scenario  Scenario for test.
     *
     * @return  void
     */
    protected function createApplication(AcceptanceTester $I, $scenario)
    {
        $originalData = $this->executeQuery($I);

        if (empty($originalData))
        {
            return;
        }

        $data = array();

        foreach ($originalData as $key => $value)
        {
            $data[$value['ITEM_ID']]['PRODUCT']        = $value['PRODUCT'];
            $data[$value['ITEM_ID']]['PRODUCT_SCHEME'] = $value['SCHEME_ID'];
            //$data[$value['ITEM_ID']]['NATIONAL_ID']    = date('YmdHi');

            if (trim($value['STAGE']) == 'SHORT_APP' && trim($value['FLD_NM']) == 'NATIONAL_ID_1')
            {
                $data[$value['ITEM_ID']]['NATIONAL_ID'] = $value['FLD_VALU'];
            }

            if ($value['STAGE'] == 'FULL_DATA_ENTRY')
            {
                $data[$value['ITEM_ID']][$value['STAGE']][$value['FLD_TAB']][$key]['name'] = $value['FLD_NM_PEGA']; 
                $data[$value['ITEM_ID']][$value['STAGE']][$value['FLD_TAB']][$key]['type'] = $value['FLD_TYP_PEGA']; 
                $data[$value['ITEM_ID']][$value['STAGE']][$value['FLD_TAB']][$key]['value'] = $value['FLD_VALU'];
            }
            else
            {
                $data[$value['ITEM_ID']][$value['STAGE']][$key]['name'] = $value['FLD_NM_PEGA'];
                $data[$value['ITEM_ID']][$value['STAGE']][$key]['type'] = $value['FLD_TYP_PEGA']; 
                $data[$value['ITEM_ID']][$value['STAGE']][$key]['value'] = $value['FLD_VALU'];
            }
            
        }

        $I->amOnUrl(\GeneralXpathLibrary::$url);
        $I = new AcceptanceTester\GeneralPolicySteps($scenario);

        $I->wantTo('Login to PEGA UAT');
        $I->loginPega('tu.vuong@fecredit.com.vn', 'rules');

        $I->wantTo('Check session message');
        $I->checkSessionMessage();

        $I->wantTo('Launch to FE Manager 7');
        $I->launchPortal();

        // Process flow
        foreach ($data as $item => $case)
        {
            if (strlen($case['NATIONAL_ID']) == 9 || strlen($case['NATIONAL_ID']) == 12)
            {
                $product = $case['PRODUCT'];
                unset($case['PRODUCT']);

                $I->wantTo('Select product');

                if (!$I->selectedProduct($product))
                {
                    continue;
                }

                $I->wantTo('Init data');

                if (!$I->initDemoData($case, $product))
                {
                    continue;
                }

                $I->wantTo('Entry short data');

                if (!$I->shortApplicationPolicy($case, $product))
                {
                    continue;
                }
                
                $I->wantTo('Check documents');

                if (!$I->shortApplicationDocumentPolicy($product))
                {
                    $I->wantTo('GetData');
                    $caseId = $I->grabTextFrom(\GeneralXpathLibrary::$caseId);
                    $caseId = str_replace('(', '', $caseId);
                    $caseId = str_replace(')', '', $caseId);
                    $responseData = $I->getData($caseId, $product, $item);

                    if (!empty($responseData))
                    {
                        $I->updateData($responseData, $I->connectOracle());
                    }

                    continue;
                }

                $I->wantTo('Entry full data');
                $I->fullDataEntry($case, $product);

                $applicationStatus = $I->grabTextFrom(\GeneralXpathLibrary::$applicationStatus);

                if (trim($applicationStatus) == 'Pending-Rework-AddDoc')
                {
                    $I->PendingReworkAddDoc();
                }

                $I->wantTo('Check data');
                $caseId = $I->dataCheckPolicy($case, $product);

                if ($caseId == '')
                {
                    continue;
                }

                $I->wantTo('GetData');
                $responseData = $I->getData($caseId, $product, $item);

                if (!empty($responseData))
                {
                    $I->updateData($responseData, $I->connectOracle());
                }

                $I->switchToIFrame();
            }

        }
    }
}
