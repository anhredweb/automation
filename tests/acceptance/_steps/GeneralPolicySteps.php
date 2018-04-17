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
     * @param  array  $data  Data
     *
     * @return  boolean
     */
    public function launchPortal($data)
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

        $I->click(\GeneralXpathLibrary::$createButton);

        $I->waitForElement(\GeneralXpathLibrary::$PLApplication, 2);
        $I->click(\GeneralXpathLibrary::$PLApplication);

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
                $I->executeJS("return jQuery('" . \GeneralXpathLibrary::$nationalId . "').val('" . date('Ymd') . "')");
                $I->wait(1);

                // Click create data
                $I->click(\GeneralXpathLibrary::$createPLDataInitApp);
                break;
        }

        if (!empty($data['NEW_APP']))
        {
            // Fill fields
            foreach ($data['NEW_APP'] as $field => $value)
            {
                $I->fillData($field, $value['type'], $value['value']);
            }
        }

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
        $I->wait(2);

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
            foreach ($data['SHORT_APP'] as $field => $value)
            {
                $I->fillData($field, $value['type'], $value['value']);
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
     * @param  array  $data  Data
     *
     * @return void
     */
    public function fullDataEntry($data)
    {
        $I = $this;

        // Goods Tab
        $I->wait(2);

        // Click demo data
        $I->click(\GeneralXpathLibrary::$demoDataFullDataEntry);
        $I->wait(2);
        $I->click(\GeneralXpathLibrary::$demoDataG11FullDataEntry);
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
        $I->selectOption(\GeneralXpathLibrary::$cicResult, array("value" => "Ok"));
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
        switch ($type) 
        {
            case 'input':
                $I->executeJS("return jQuery('" . $field . "').val('" . $value . "')");
                $I->wait(1);
                break;
            case 'select':
                $I->wait(1);
                $I->selectOption($field, array('value' => $value));
                break;
        }
    }
}
