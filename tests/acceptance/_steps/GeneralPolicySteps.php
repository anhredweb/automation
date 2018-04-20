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
                break;
            case 'TW':
                $I->click(\GeneralXpathLibrary::$demoDataTWInitApp);            
                break;
            case 'PL':
                // Fill product group
                $I->click(\GeneralXpathLibrary::$productPLGroup);
                $I->wait(1);
                $I->pressKey(\GeneralXpathLibrary::$productPLGroup, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
                $I->wait(1);

                $I->click(\GeneralXpathLibrary::$rowProductPLGroup);
                $I->wait(1);

                // Fill product scheme
                $I->click(\GeneralXpathLibrary::$productScheme);
                $I->wait(1);
                $I->pressKey(\GeneralXpathLibrary::$productScheme, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
                $I->wait(1);

                $I->click(\GeneralXpathLibrary::$rowProductScheme);
                $I->wait(1);

                // Fill DSA code
                $I->click(\GeneralXpathLibrary::$DSACode);
                $I->wait(1);
                $I->pressKey(\GeneralXpathLibrary::$DSACode, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
                $I->wait(1);

                $I->click(\GeneralXpathLibrary::$rowDSACode);
                $I->wait(1);

                // Fill national Id
                $I->executeJS("return jQuery('" . \GeneralXpathLibrary::$nationalId . "').val('" . $data['NATIONAL_ID'] . "')");
                $I->wait(1);

                // Click create data
                $I->click(\GeneralXpathLibrary::$createPLDataInitApp);
                break;
        }

        if (!empty($data['NEW_APP']))
        {
            // Fill fields
            foreach ($data['NEW_APP'] as $key => $value)
            {
                $I->fillData($value['name'], $value['type'], $value['value']);
            }
        }

        $I->wait(2);

        // Click create data
        $I->click(\GeneralXpathLibrary::$createDataInitApp);

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

        if (!empty($data['SHORT_APP']))
        {
            // Fill fields
            foreach ($data['SHORT_APP'] as $key => $value)
            {
                $I->fillData($value['name'], $value['type'], $value['value']);
            }
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
        $I->wait(80);

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
        $I->wait(1);

        $I->selectOption(\GeneralXpathLibrary::$cicReason, array("value" => "CICDR"));
        $I->wait(1);

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
                $I->executeJS("return jQuery('" . $field . "').val('" . $value . "')");
                $I->wait(1);
                break;
            case 'dropdownlist':
                $I->wait(1);
                $I->selectOption($field, array('value' => $value));
                break;
        }
    }
}
