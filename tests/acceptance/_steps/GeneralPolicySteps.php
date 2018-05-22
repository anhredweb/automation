<?php
/**
 * @package     FE Credit
 * @subpackage  Automation Testing
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace AcceptanceTester;

use Codeception\Module\WebDriver;

/**
 * Class AdminManagerJoomla3Steps
 *
 * @package  AcceptanceTester
 *
 * @since    1.4
 */
class GeneralPolicySteps extends \AcceptanceTester
{
    /**
     * Function to launch to FECase Manager to Create Application
     *
     * @return  boolean
     */
    public function launchPortal()
    {
        $I = $this;
        $I->wait(2);

        if (!$I->checkElementNotExist(\GeneralXpathLibrary::$closeSession))
        {
            $I->click(\GeneralXpathLibrary::$closeSession);
        }
        
        $I->click(\GeneralXpathLibrary::$launchButton);
        $I->waitForElement(\GeneralXpathLibrary::$FECaseManager, 2);
        $I->click(\GeneralXpathLibrary::$FECaseManager);
        $I->wait(2);

        $I->switchToNextTab();
        $I->wait(2);

        $I->executeJS('window.scrollTo(0,0)');

        if ($I->checkElementNotExist(\GeneralXpathLibrary::$createButton))
        {
            $I->skipTestCase($data['NATIONAL_ID']);

            return false;
        }

        return true;
    }

    /**
     * Function to launch to FECase Manager to Create Application
     *
     * @param  string  $product  Product name
     *
     * @return  boolean
     */
    public function selectedProduct($product)
    {
        $I = $this;
        $I->wait(2);

        $I->click(\GeneralXpathLibrary::$createButton);

        // Click choose product
        switch ($product) 
        {
            case 'CDL':
                $I->waitForElement(\GeneralXpathLibrary::$CDLApplication, 2);
                $I->click(\GeneralXpathLibrary::$CDLApplication);
                break;
            case 'TW':
                $I->waitForElement(\GeneralXpathLibrary::$TWApplication, 2);
                $I->click(\GeneralXpathLibrary::$TWApplication);        
                break;
            case 'PL':
                $I->waitForElement(\GeneralXpathLibrary::$PLApplication, 2);
                $I->click(\GeneralXpathLibrary::$PLApplication);
            break;
        }

        return true;
    }

    /**
     * Function to init data for Application
     *
     * @param  array   $data     Data
     * @param  string  $product  Product name
     *
     * @return boolean
     */
    public function initDemoData($data, $product)
    {
        $I = $this;
        $I->wait(2);

        // PEGA System use iframe so need to switch to iframe to access input
        $iframeName = $I->grabAttributeFrom(\GeneralXpathLibrary::$iframeEnviroment, 'name');
        $I->switchToIFrame($iframeName);
        $I->wait(1);

        // Click demo data
        switch ($product) 
        {
            case 'CDL':
                $I->click(\GeneralXpathLibrary::$demoDataCDLInitApp);
                $I->wait(2); 
                // Click create data
                $I->click(\GeneralXpathLibrary::$createDataInitApp);
                break;
            case 'TW':
                $I->click(\GeneralXpathLibrary::$demoDataTWInitApp);   
                $I->wait(2); 
                // Click create data
                $I->click(\GeneralXpathLibrary::$createDataInitApp);        
                break;
            case 'PL':
                // Fill product group
                $I->click(\GeneralXpathLibrary::$productPLGroup);
                $I->wait(1);
                $I->executeJS("return jQuery('" . \GeneralXpathLibrary::$productPLGroupJS . "').val('NEW TO BANK')");
                $I->wait(1);
                $I->pressKey(\GeneralXpathLibrary::$productPLGroup, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
                $I->wait(1);
                $I->click(\GeneralXpathLibrary::$rowProductPLGroup);
                $I->wait(1);

                // Fill product scheme
                $I->click(\GeneralXpathLibrary::$productScheme);
                $I->wait(1);
                $I->executeJS("return jQuery('" . \GeneralXpathLibrary::$productSchemeJS . "').val('FC UP CAT C - 306')");
                $I->wait(1);
                $I->pressKey(\GeneralXpathLibrary::$productScheme, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
                $I->wait(1);
                $I->click(\GeneralXpathLibrary::$rowProductScheme);
                $I->wait(1);

                // Fill DSA code
                $I->click(\GeneralXpathLibrary::$DSACode);
                $I->wait(1);
                $I->executeJS("return jQuery('" . \GeneralXpathLibrary::$DSACodeJS . "').val('BAD00002')");
                $I->wait(1);
                $I->pressKey(\GeneralXpathLibrary::$DSACode, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
                $I->wait(1);
                $I->click(\GeneralXpathLibrary::$rowDSACode);
                $I->wait(1);

                // Fill national Id
                $I->executeJS("return jQuery('" . \GeneralXpathLibrary::$nationalId . "').val('" . $data['NATIONAL_ID'] . "')");

                $I->wait(1);
                $I->click(\GeneralXpathLibrary::$createPLDataInitApp);
                break;
        }

        /*$I->wait(2);

        if (!empty($data['NEW_APP']))
        {
            // Fill fields
            foreach ($data['NEW_APP'] as $key => $value)
            {
                $I->fillData($value['name'], $value['type'], $value['value']);
            }

            $I->wait(2);
        }*/

        return $I->checkError($data['NATIONAL_ID']);
    }

    /**
     * Function to entry short data for Application
     *
     * @param  array   $data     Data
     * @param  string  $product  Product
     *
     * @return boolean
     */
    public function shortApplicationPolicy($data, $product = NULL)
    {
        $I = $this;
        $I->wait(5);

        // $I->click(\GeneralXpathLibrary::$dataCheck);
        // $I->wait(2);
        
        // Click demo data
        $I->click(\GeneralXpathLibrary::$demoDataShortApp);
        $I->wait(2);
        $I->click(\GeneralXpathLibrary::$demoDataG1ShortApp);
        $I->wait(2);

        // Fill fields
        foreach ($data['SHORT_APP'] as $key => $value)
        {
            $I->fillData($value['name'], $value['type'], $value['value']);
        }

        // Select Disbursement Channel
        if ($product == 'PL')
        {
            $I->fillField(\GeneralXpathLibrary::$requestedAmount, 1);
            $I->wait(1);
            $I->executeJS("return jQuery('" . \GeneralXpathLibrary::$requestedAmountJS . "').val('1').attr('data-value', '1')");
            $I->wait(2);
        }

        // Click submit data
        $I->click(\GeneralXpathLibrary::$submitShortApp);
        $I->wait(2);

        return $I->checkError($data['NATIONAL_ID']);
    }

    /**
     * Function to check documents for PL Application
     *
     * @param  string  $product  Product
     *
     * @return boolean
     */
    public function shortApplicationDocumentPolicy($product)
    {
        $I = $this;

        $applicationStatus = $I->grabTextFrom(\GeneralXpathLibrary::$applicationStatus);

        if (trim($applicationStatus) == 'Resolved-Rejected-Hard' || trim($applicationStatus) == 'Resolved-Rejected-Soft')
        {
            return false;
        }

        switch ($product) 
        {
            case 'CDL':
            case 'TW':
                // Click Scan and Attach Documents
                // $I->click(\GeneralXpathLibrary::$dataCheck);
                // $I->wait(2);

                // Click demo data
                $I->wait(2);
                $I->click(\GeneralXpathLibrary::$demoDataDocument);
                $I->wait(1);

                // Click submit data
                $I->click(\GeneralXpathLibrary::$submitDocument);
                $I->wait(2);
                break;
            
            case 'PL':
                // Click demo data
                $I->wait(2);
                $I->click(\GeneralXpathLibrary::$demoPLDataDocument);
                $I->wait(1);

                // Click submit data
                $I->click(\GeneralXpathLibrary::$submitPLDocument);
                $I->wait(2);
                break;
        }

        return true;
    }

    /**
     * Function to entry full data for Application
     *
     * @param  array   $data     Data
     * @param  string  $product  Product
     *
     * @return void
     */
    public function fullDataEntry($data, $product)
    {
        $I = $this;

        // Goods Tab
        $I->wait(2);

        // Click demo data
        $I->click(\GeneralXpathLibrary::$demoDataFullDataEntry);
        $I->wait(2);
        $I->click(\GeneralXpathLibrary::$demoDataG11FullDataEntry);
        $I->wait(2);

        if (!empty($data['FULL_DATA_ENTRY']))
        {
            // Fill fields
            foreach ($data['FULL_DATA_ENTRY'] as $tab => $values)
            {
                $I->click(\GeneralXpathLibrary::getTabId($tab));
                $I->wait(1);

                foreach ($values as $key => $value)
                {
                    $I->fillData($value['name'], $value['type'], $value['value']);
                }
            }
        }

        $I->wait(2);

        // Click submit data
        $I->click(\GeneralXpathLibrary::$submitFullDataEntry);
        $I->wait(2);

        return $I->checkError($data['NATIONAL_ID']);
    }

    /**
     * Function to data check for Application
     *
     * @param  array   $data     Data
     * @param  string  $product  Product
     *
     * @return string
     */
    public function dataCheckPolicy($data = array(), $product = NULL)
    {
        $I = $this;
        $I->wait(3);

        // Click Data check
        $I->click(\GeneralXpathLibrary::$dataCheck);
        $I->wait(2);

        // Select verification result
        $I->selectOption(\GeneralXpathLibrary::$verificationResult, array('value' => 'Positive'));
        $I->wait(1);

        // Click documents tab and demo data
        $I->click(\GeneralXpathLibrary::$documentsTab);
        $I->click(\GeneralXpathLibrary::$demoDataDataCheck);
        $I->wait(1);

        // Click CIC tab and select CIC result
        $I->click(\GeneralXpathLibrary::$cicTab);
        $I->selectOption(\GeneralXpathLibrary::$cicResult, array("value" => "Don't require"));
        $I->wait(2);

        if ($product == 'PL')
        {
            // Click PCB tab and select PCB result
            $I->click(\GeneralXpathLibrary::$pcbTab);
            $I->selectOption(\GeneralXpathLibrary::$pcbResult, array("value" => "PCB OK"));
            $I->wait(1);
        }
        else
        {
            $I->selectOption(\GeneralXpathLibrary::$cicReason, array("value" => "CICDR"));
            $I->wait(1);
        }

        // Click submit data
        $I->click(\GeneralXpathLibrary::$submitDataCheck);
        $I->wait(1);
        $I->click(\GeneralXpathLibrary::$okDataCheck);
        $I->wait(5);

        $caseId = $I->grabTextFrom(\GeneralXpathLibrary::$caseId);
        $caseId = str_replace('(', '', $caseId);
        $caseId = str_replace(')', '', $caseId);

        $applicationStatus = $I->grabTextFrom(\GeneralXpathLibrary::$applicationStatus);

        if (trim($applicationStatus) == 'Resolved-Rejected-Hard' || trim($applicationStatus) == 'Resolved-Rejected-Soft')
        {
            return '';
        }

        print_r($applicationStatus);

        return $caseId;
    }

    /**
     * Function to get Data
     *
     * @param  string  $caseId   Case ID
     * @param  string  $product  Product name
     * @param  array   $data     Data
     *
     * @return array
     */
    public function getData($caseId, $product, $itemId)
    {
        $I = $this;

        $responseData = array();
        $caseId = $I->grabTextFrom(\GeneralXpathLibrary::$caseId);
        $caseId = str_replace("(", "", $caseId);
        $caseId = str_replace(")", "", $caseId);
        $responseData['case_id']    = $caseId;
        $responseData['app_id']     = $I->grabTextFrom(\GeneralXpathLibrary::$applicationId);
        $responseData['id_no1']     = $I->grabTextFrom(\GeneralXpathLibrary::$nationalIdScoring);
        $responseData['scheme_id']  = $I->grabTextFrom(\GeneralXpathLibrary::$productSchemeName);
        $responseData['curr_stage'] = $I->grabTextFrom(\GeneralXpathLibrary::$currentStage);
        $responseData['remark']     = $I->grabTextFrom(\GeneralXpathLibrary::$applicationStatus);
        $responseData['item_id']    = $itemId;

        $I->wait(3);

        print_r($responseData);

        return $responseData;
    }

    /**
     * Function to update data to DB
     *
     * @param  array     $data        Data to update
     * @param  resource  $connection  Oracle connection
     *
     * @return void
     */
    public function updateData($data, $connection)
    {
        $itemId = $data['item_id'];
        unset($data['item_id']);
        unset($data['scheme_id']);
        $setQuery = array();

        foreach ($data as $column => $value)
        {
            $setQuery[] = $column . " = " . "'" . $value . "'";
        }

        $query = "UPDATE TPEGA_AUTO_RUN_MASTER SET " . implode(',', $setQuery) . " WHERE ITEM_ID = " . $itemId;
        $stid  = oci_parse($connection, $query);
        oci_execute($stid);
        oci_commit($connection);

        return;
    }

    /**
     * Function to search application

     * @param  array  $data  Data
     *
     * @return array
     */
    public function searchPolicyApplication($data)
    {
        $I = $this;
        $I->wait(5);
        $I->click(\GeneralXpathLibrary::$emailOnTop2);
        $I->wait(1);
        $I->moveMouseOver(\GeneralXpathLibrary::$switchWorkPool);
        $I->wait(1);
        $I->click(\GeneralXpathLibrary::$defaultWorkPool);
        $I->wait(2);
        $I->fillField(\GeneralXpathLibrary::$searchBox, $data['CASE_ID']);
        $I->wait(1);
        $I->click(\GeneralXpathLibrary::$searchButton);
        $I->wait(2);

        // PEGA System use iframe so need to switch to iframe to access input
        $iframeName = $I->grabAttributeFrom(\GeneralXpathLibrary::$decisionMakingFrame, 'name');
        $I->switchToIFrame($iframeName);
        $I->wait(1);
        $I->click(\GeneralXpathLibrary::$decisionMaking);
        $I->wait(1);

        $applicationStatus = $I->grabTextFrom(\GeneralXpathLibrary::$applicationStatus);

        $responseData                           = array();
        $responseData['1']['APP_ID']            = "'" . $data['APP_ID'] . "'";
        $responseData['1']['CASE_ID']           = "'" . $data['CASE_ID'] . "'";
        $responseData['1']['USER_ID']           = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getProcessedUser('1')) . "'";
        $responseData['1']['TRXN_DT']           = "TO_DATE('" . $I->grabTextFrom(\GeneralXpathLibrary::getTransactionDate('1')) . "', 'DD/MM/YYYY HH24:MI:SS')";
        $responseData['1']['TYPE']              = "'" . 'PreScoring1' . "'";
        $responseData['1']['FINAL_RESULT']      = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPrescoringResult('1', '5')) . "'";
        $responseData['1']['CD_XSELL_ELIGIBLE'] = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPrescoringResult('1', '3')) . "'";
        $responseData['1']['HARD_CNT']          = (int) $I->grabTextFrom(\GeneralXpathLibrary::getPrescoringResult('1', '2'));
        $responseData['1']['SOFT_CNT']          = (int) $I->grabTextFrom(\GeneralXpathLibrary::getPrescoringResult('1', '4'));
        $responseData['1']['WAIVE_CNT']         = (int) $I->grabTextFrom(\GeneralXpathLibrary::getPrescoringResult('1', '6'));
        $responseData['1']['ROUND']             = 0;
        $responseData['1']['RULES'][1]['RULE_DESC']   = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyPrescoring('1', '1')) . "'";
        $responseData['1']['RULES'][1]['SCACTION']    = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCAction('1', '1')) . "'";
        $responseData['1']['RULES'][1]['RESULT']      = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyScoreResult('1', '1')) . "'";
        $responseData['1']['RULES'][1]['RESULT_INFO'] = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCResultInfo('1', '1')) . "'";
        $responseData['1']['RULES'][2]['RULE_DESC']   = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyPrescoring('1', '2')) . "'";
        $responseData['1']['RULES'][2]['SCACTION']    = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCAction('1', '2')) . "'";
        $responseData['1']['RULES'][2]['RESULT']      = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyScoreResult('1', '2')) . "'";
        $responseData['1']['RULES'][2]['RESULT_INFO'] = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCResultInfo('1', '2')) . "'";
        $responseData['1']['RULES'][3]['RULE_DESC']   = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyPrescoring('1', '3')) . "'";
        $responseData['1']['RULES'][3]['SCACTION']    = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCAction('1', '3')) . "'";
        $responseData['1']['RULES'][3]['RESULT']      = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyScoreResult('1', '3')) . "'";
        $responseData['1']['RULES'][3]['RESULT_INFO'] = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCResultInfo('1', '3')) . "'";
        $responseData['1']['RULES'][4]['RULE_DESC']   = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyPrescoring('1', '4')) . "'";
        $responseData['1']['RULES'][4]['SCACTION']    = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCAction('1', '4')) . "'";
        $responseData['1']['RULES'][4]['RESULT']      = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyScoreResult('1', '4')) . "'";
        $responseData['1']['RULES'][4]['RESULT_INFO'] = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCResultInfo('1', '4')) . "'";

        if ($data['PRODUCT'] != 'PL')
        {
            $responseData['1']['RULES'][5]['RULE_DESC']   = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyPrescoring('1', '5')) . "'";
            $responseData['1']['RULES'][5]['SCACTION']    = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCAction('1', '5')) . "'";
            $responseData['1']['RULES'][5]['RESULT']      = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyScoreResult('1', '5')) . "'";
            $responseData['1']['RULES'][5]['RESULT_INFO'] = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCResultInfo('1', '5')) . "'";
        }

        $I->wait(1);
        $elementExist = array_filter($I->grabMultiple(\GeneralXpathLibrary::getTransactionDate('2')));

        if (!empty($elementExist))
        {
            $responseData['2']['APP_ID']            = "'" . $data['APP_ID'] . "'";
            $responseData['2']['CASE_ID']           = "'" . $data['CASE_ID'] . "'";
            $responseData['2']['USER_ID']           = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getProcessedUser('2')) . "'";
            $responseData['2']['TRXN_DT']           = "TO_DATE('" . $I->grabTextFrom(\GeneralXpathLibrary::getTransactionDate('2')) . "', 'DD/MM/YYYY HH24:MI:SS')";
            $responseData['2']['TYPE']              = "'" . 'PreScoring2' . "'";
            $responseData['2']['FINAL_RESULT']      = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPrescoringResult('2', '5')) . "'";
            $responseData['2']['CD_XSELL_ELIGIBLE'] = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPrescoringResult('2', '3')) . "'";
            $responseData['2']['HARD_CNT']          = (int) $I->grabTextFrom(\GeneralXpathLibrary::getPrescoringResult('2', '2'));
            $responseData['2']['SOFT_CNT']          = (int) $I->grabTextFrom(\GeneralXpathLibrary::getPrescoringResult('2', '4'));
            $responseData['2']['WAIVE_CNT']         = (int) $I->grabTextFrom(\GeneralXpathLibrary::getPrescoringResult('2', '6'));
            $responseData['2']['ROUND']             = 0;
            $responseData['2']['RULES'][1]['RULE_DESC']   = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyPrescoring('2', '1')) . "'";
            $responseData['2']['RULES'][1]['SCACTION']    = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCAction('2', '1')) . "'";
            $responseData['2']['RULES'][1]['RESULT']      = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyScoreResult('2', '1')) . "'";
            $responseData['2']['RULES'][1]['RESULT_INFO'] = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCResultInfo('2', '1')) . "'";
            $responseData['2']['RULES'][2]['RULE_DESC']   = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyPrescoring('2', '2')) . "'";
            $responseData['2']['RULES'][2]['SCACTION']    = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCAction('2', '2')) . "'";
            $responseData['2']['RULES'][2]['RESULT']      = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyScoreResult('2', '2')) . "'";
            $responseData['2']['RULES'][2]['RESULT_INFO'] = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCResultInfo('2', '2')) . "'";
            $responseData['2']['RULES'][3]['RULE_DESC']   = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyPrescoring('2', '3')) . "'";
            $responseData['2']['RULES'][3]['SCACTION']    = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCAction('2', '3')) . "'";
            $responseData['2']['RULES'][3]['RESULT']      = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyScoreResult('2', '3')) . "'";
            $responseData['2']['RULES'][3]['RESULT_INFO'] = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCResultInfo('2', '3')) . "'";
            $responseData['2']['RULES'][4]['RULE_DESC']   = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyPrescoring('2', '4')) . "'";
            $responseData['2']['RULES'][4]['SCACTION']    = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCAction('2', '4')) . "'";
            $responseData['2']['RULES'][4]['RESULT']      = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyScoreResult('2', '4')) . "'";
            $responseData['2']['RULES'][4]['RESULT_INFO'] = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCResultInfo('2', '4')) . "'";
            $responseData['2']['RULES'][5]['RULE_DESC']   = "'" . str_replace("'", '`', $I->grabTextFrom(\GeneralXpathLibrary::getPolicyPrescoring('2', '5'))) . "'";
            $responseData['2']['RULES'][5]['SCACTION']    = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCAction('2', '5')) . "'";
            $responseData['2']['RULES'][5]['RESULT']      = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyScoreResult('2', '5')) . "'";
            $responseData['2']['RULES'][5]['RESULT_INFO'] = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCResultInfo('2', '5')) . "'";
            $responseData['2']['RULES'][6]['RULE_DESC']   = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyPrescoring('2', '6')) . "'";
            $responseData['2']['RULES'][6]['SCACTION']    = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCAction('2', '6')) . "'";
            $responseData['2']['RULES'][6]['RESULT']      = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyScoreResult('2', '6')) . "'";
            $responseData['2']['RULES'][6]['RESULT_INFO'] = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCResultInfo('2', '6')) . "'";
            $responseData['2']['RULES'][7]['RULE_DESC']   = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyPrescoring('2', '7')) . "'";
            $responseData['2']['RULES'][7]['SCACTION']    = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCAction('2', '7')) . "'";
            $responseData['2']['RULES'][7]['RESULT']      = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyScoreResult('2', '7')) . "'";
            $responseData['2']['RULES'][7]['RESULT_INFO'] = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCResultInfo('2', '7')) . "'";
            $responseData['2']['RULES'][8]['RULE_DESC']   = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyPrescoring('2', '8')) . "'";
            $responseData['2']['RULES'][8]['SCACTION']    = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCAction('2', '8')) . "'";
            $responseData['2']['RULES'][8]['RESULT']      = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyScoreResult('2', '8')) . "'";
            $responseData['2']['RULES'][8]['RESULT_INFO'] = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCResultInfo('2', '8')) . "'";
            $responseData['2']['RULES'][9]['RULE_DESC']   = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyPrescoring('2', '9')) . "'";
            $responseData['2']['RULES'][9]['SCACTION']    = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCAction('2', '9')) . "'";
            $responseData['2']['RULES'][9]['RESULT']      = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyScoreResult('2', '9')) . "'";
            $responseData['2']['RULES'][9]['RESULT_INFO'] = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCResultInfo('2', '9')) . "'";
            $responseData['2']['RULES'][10]['RULE_DESC']   = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyPrescoring('2', '10')) . "'";
            $responseData['2']['RULES'][10]['SCACTION']    = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCAction('2', '10')) . "'";
            $responseData['2']['RULES'][10]['RESULT']      = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicyScoreResult('2', '10')) . "'";
            $responseData['2']['RULES'][10]['RESULT_INFO'] = "'" . $I->grabTextFrom(\GeneralXpathLibrary::getPolicySCResultInfo('2', '10')) . "'";
        }

        $I->wait(2);

        print_r($responseData);

        return $responseData;
    }

    /**
     * Function to update data to DB
     *
     * @param  array     $data        Data to update
     * @param  resource  $connection  Oracle connection
     *
     * @return void
     */
    public function updatePreScoring($data, $connection)
    {

        foreach ($data as $key => $value)
        {
            $policyRules = $value['RULES'];
            unset($value['RULES']);
            $query = "INSERT INTO TPEGA_AUTO_POL_RESULT_MASTER VALUES(" . implode(',', $value) . ")";
            print_r($query);
            $stid  = oci_parse($connection, $query);
            oci_execute($stid);
            oci_commit($connection);

            foreach ($policyRules as $rules)
            {
                $queryRules = "INSERT INTO TPEGA_AUTO_POL_RESULT_DTL VALUES(" . $value['APP_ID'] . ", " . $value['CASE_ID'] . ", " . $value['TYPE'] . ", " . implode(',', $rules) . ", 0)";
                print_r($queryRules);
                $stidRules  = oci_parse($connection, $queryRules);
                oci_execute($stidRules);
                oci_commit($connection);
            }

            $queryUpdate = "UPDATE TPEGA_AUTO_RUN_MASTER SET COMP_DT = SYSDATE WHERE CASE_ID = " . $value['CASE_ID'];
            print_r($queryUpdate);
            $stidUpdate  = oci_parse($connection, $queryUpdate);
            oci_execute($stidUpdate);
            oci_commit($connection);
        }

        return;
    }

    /**
     * Function to fill data to fields
     *
     * @param  string  $field  Field name
     * @param  string  $type   Field type
     * @param  string  $value  Field value
     *
     * @return mixed
     */
    public function fillData($field, $type, $value)
    {
        $I = $this;

        switch ($type) 
        {
            case 'input':
                $I->clearField($field);
                $I->wait(2);
                $I->fillField($field, $value);
                $I->wait(2);
                break;
            case 'dropdownlist':
                $I->wait(2);
                $I->selectOption($field, array('value' => $value));
                break;
        }
    }
}