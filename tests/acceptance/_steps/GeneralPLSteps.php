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
class GeneralPLSteps extends \AcceptanceTester
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
    public function initPLData($data, $product)
    {
        $I = $this;
        $I->wait(2);

        // PEGA System use iframe so need to switch to iframe to access input
        $iframeName = $I->grabAttributeFrom(\GeneralXpathLibrary::$iframeEnviroment, 'name');
        $I->switchToIFrame($iframeName);
        $I->wait(1);

        // Fill product group
        $I->click(\GeneralXpathLibrary::$productPLGroup);
        $I->wait(1);
        $I->executeJS("return jQuery('" . \GeneralXpathLibrary::$productPLGroupJS . "').val('" . $data["PRODUCT_GROUP"] . "')");
        $I->wait(1);
        $I->pressKey(\GeneralXpathLibrary::$productPLGroup, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
        $I->wait(1);

        if ($I->checkElementNotExist(\GeneralXpathLibrary::$rowProductPLGroup))
        {
            $I->skipTestCase($data['NATIONAL_ID']);

            return false;
        }

        $I->click(\GeneralXpathLibrary::$rowProductPLGroup);
        $I->wait(1);

        // Fill product scheme
        $I->click(\GeneralXpathLibrary::$productScheme);
        $I->wait(1);
        $I->executeJS("return jQuery('" . \GeneralXpathLibrary::$productSchemeJS . "').val('" . $data["PRODUCT_SCHEME"] . "')");
        $I->wait(1);
        $I->pressKey(\GeneralXpathLibrary::$productScheme, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
        $I->wait(1);

        if ($I->checkElementNotExist(\GeneralXpathLibrary::$rowProductScheme))
        {
            $I->skipTestCase($data['NATIONAL_ID']);

            return false;
        }

        $I->click(\GeneralXpathLibrary::$rowProductScheme);
        $I->wait(1);

        $data['DSA_CODE'] = 'BAD00002';

        // Fill DSA code
        $I->click(\GeneralXpathLibrary::$DSACode);
        $I->wait(1);
        $I->executeJS("return jQuery('" . \GeneralXpathLibrary::$DSACodeJS . "').val('" . $data["DSA_CODE"] . "')");
        $I->wait(1);
        $I->pressKey(\GeneralXpathLibrary::$DSACode, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
        $I->wait(1);

        if ($I->checkElementNotExist(\GeneralXpathLibrary::$rowDSACode))
        {
            $I->skipTestCase($data['NATIONAL_ID']);

            return false;
        }

        $I->click(\GeneralXpathLibrary::$rowDSACode);
        $I->wait(1);

        // Fill national Id
        $I->executeJS("return jQuery('" . \GeneralXpathLibrary::$nationalId . "').val('" . $data['NATIONAL_ID'] . "')");
        $I->wait(1);

        // Click create data
        $I->click(\GeneralXpathLibrary::$createPLDataInitApp);

        return $I->checkError($data['NATIONAL_ID']);
    }

    /**
     * Function to check documents for PL Application
     *
     * @return boolean
     */
    public function shortApplicationDocumentPL()
    {
        $I = $this;

        $applicationStatus = $I->grabTextFrom(\GeneralXpathLibrary::$applicationStatus);

        print_r($applicationStatus);

        if (trim($applicationStatus) == 'Resolved-Rejected-Hard' || trim($applicationStatus) == 'Resolved-Rejected-Soft')
        {
            return false;
        }

        // Click Scan and Attach Documents
        $I->click(\GeneralXpathLibrary::$dataCheck);
        $I->wait(2);

        // Click demo data
        $I->wait(2);
        $I->click(\GeneralXpathLibrary::$demoPLDataDocument);
        $I->wait(1);

        // Click submit data
        $I->click(\GeneralXpathLibrary::$submitPLDocument);
        $I->wait(2);

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

        // Loan Tab
        if (!empty($data['REQUESTED_AMOUNT']))
        {
            $I->fillField(\GeneralXpathLibrary::$requestedAmount, $data["REQUESTED_AMOUNT"]);
            $I->wait(1);
            $I->executeJS("return jQuery('" . \GeneralXpathLibrary::$requestedAmountJS . "').val('" . $data["REQUESTED_AMOUNT"] . "').attr('data-value', '" . $data["REQUESTED_AMOUNT"] . "')");
            $I->wait(2);
        }

        if (!empty($data['TENOR']))
        {
            $I->executeJS("return jQuery('" . \GeneralXpathLibrary::$tenor . "').val('" . $data["TENOR"] . "')");
        }

        if (!empty($data['LOAN_PURPOSE']))
        {
            $I->click(\GeneralXpathLibrary::$loanPurpose);
            $I->executeJS("return jQuery('" . \GeneralXpathLibrary::$loanPurpose . "').val('" . $data["LOAN_PURPOSE"] . "')");
            $I->wait(2);
            $I->pressKey(\GeneralXpathLibrary::$loanPurpose, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
            $I->wait(2);
            $I->click(\GeneralXpathLibrary::$rowLoanPurpose);
            $I->wait(1);
        }
        
        $I->wait(2);

        $I->generalFullDataEntry($data);

        return $I->checkError($data['NATIONAL_ID']);
    }

    /**
     * Function to update score to DB
     *
     * @param  array   $data        Data to update
     * @param  string  $connection  Oracle connection
     *
     * @return void
     */
    public function updateScore($data, $connection)
    {
        $nationalId = $data['national_id'];
        unset($data['national_id']);
        $setQuery = array();

        foreach ($data as $column => $value)
        {
            $setQuery[] = $column . " = " . "'" . $value . "'";
        }

        $setQuery[] = "STATUS = '1'";

        $query = "UPDATE AUTOMATION_TEST_CASE_PL SET " . implode(',', $setQuery) . " WHERE NATIONAL_ID = " . $nationalId;
        $stid  = oci_parse($connection, $query);
        oci_execute($stid);
        oci_commit($connection);

        return true;
    }

    /**
     * Function to check score and update to DB
     *
     * @param  array   $data        Data to update
     * @param  string  $connection  Oracle connection
     *
     * @return void
     */
    public function checkScore($data, $connection)
    {
        $selectScoreQuery = array(
            'SCORE_USER_AGE',
            'SCORE_USER_CIC_RELATIONSHIP',
            'SCORE_USER_COMPANY',
            'SCORE_USER_PRE_OF_WORK_EXP',
            'SCORE_USER_CUST_SOCIAL_TRUST',
            'SCORE_USER_DISB_APPS',
            'SCORE_USER_DSA',
            'SCORE_USER_EDUCATION',
            'SCORE_USER_GENDER',
            'SCORE_USER_MARITAL_STATUS',
            'SCORE_USER_HOMETOWN',
            'SCORE_USER_REJECTED_APPS',
            'SCORE_USER_TS_APPLY_DAYS',
            'TOTAL_SCORE',
            'SCORE_GROUP',
            'PRODUCT_SCORE_GROUP',
            'SUB_SEGMENT',
            'LEAD_BLACK'
        );
        $selectCheckQuery = array(
            'SCORE_CHECK_AGE'               => "'F'",
            'SCORE_CHECK_CIC_RELATIONSHIP'  => "'F'",
            'SCORE_CHECK_COMPANY'           => "'F'",
            'SCORE_CHECK_PRE_OF_WORK_EXP'   => "'F'",
            'SCORE_CHECK_CUST_SOCIAL_TRUST' => "'F'",
            'SCORE_CHECK_DISB_APPS'         => "'F'",
            'SCORE_CHECK_DSA'               => "'F'",
            'SCORE_CHECK_EDUCATION'         => "'F'",
            'SCORE_CHECK_GENDER'            => "'F'",
            'SCORE_CHECK_MARITAL_STATUS'    => "'F'",
            'SCORE_CHECK_HOMETOWN'          => "'F'",
            'SCORE_CHECK_REJECTED_APPS'     => "'F'",
            'SCORE_CHECK_TS_APPLY_DAYS'     => "'F'",
            'CHECK_TOTAL_SCORE'             => "'F'",
            'CHECK_SCORE_GROUP'             => "'F'",
            'CHECK_PRODUCT_SCORE_GROUP'     => "'F'",
            'CHECK_SUB_SEGMENT'             => "'F'",
            'CHECK_LEAD_BLACK'              => "'F'"
        );
        $query      = "SELECT " . implode(',', $selectScoreQuery) . " FROM AUTOMATION_TEST_CASE_PL WHERE NATIONAL_ID = " . $data['national_id'];
        $stid       = oci_parse($connection, $query);
        oci_execute($stid);
        $rows = oci_fetch_assoc($stid);

        if (empty($rows))
        {
            return false;
        }

        foreach ($rows as $column => $score)
        {
            if ($column == 'SCORE_USER_AGE' && (int) $score == (int) $data['score_robot_age'])
            {
                $selectCheckQuery['SCORE_CHECK_AGE'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_CIC_RELATIONSHIP' && (int) $score == (int) $data['score_robot_cic_relationship'])
            {
                $selectCheckQuery['SCORE_CHECK_CIC_RELATIONSHIP'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_COMPANY' && (int) $score == (int) $data['score_robot_company'])
            {
                $selectCheckQuery['SCORE_CHECK_COMPANY'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_PRE_OF_WORK_EXP' && (int) $score == (int) $data['score_robot_pre_of_work_exp'])
            {
                $selectCheckQuery['SCORE_CHECK_PRE_OF_WORK_EXP'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_CUST_SOCIAL_TRUST' && (int) $score == (int) $data['score_robot_cust_social_trust'])
            {
                $selectCheckQuery['SCORE_CHECK_CUST_SOCIAL_TRUST'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_DISB_APPS' && (int) $score == (int) $data['score_robot_disb_apps'])
            {
                $selectCheckQuery['SCORE_CHECK_DISB_APPS'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_DSA' && (int) $score == (int) $data['score_robot_dsa'])
            {
                $selectCheckQuery['SCORE_CHECK_DSA'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_EDUCATION' && (int) $score == (int) $data['score_robot_education'])
            {
                $selectCheckQuery['SCORE_CHECK_EDUCATION'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_GENDER' && (int) $score == (int) $data['score_robot_gender'])
            {
                $selectCheckQuery['SCORE_CHECK_GENDER'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_MARITAL_STATUS' && (int) $score == (int) $data['score_robot_marital_status'])
            {
                $selectCheckQuery['SCORE_CHECK_MARITAL_STATUS'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_HOMETOWN' && (int) $score == (int) $data['score_robot_hometown'])
            {
                $selectCheckQuery['SCORE_CHECK_HOMETOWN'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_REJECTED_APPS' && (int) $score == (int) $data['score_robot_rejected_apps'])
            {
                $selectCheckQuery['SCORE_CHECK_REJECTED_APPS'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_TS_APPLY_DAYS' && (int) $score == (int) $data['score_robot_ts_apply_days'])
            {
                $selectCheckQuery['SCORE_CHECK_TS_APPLY_DAYS'] = "'P'";
            }
            elseif ($column == 'TOTAL_SCORE' && (int) $score == (int) $data['robot_total_score'])
            {
                $selectCheckQuery['CHECK_TOTAL_SCORE'] = "'P'";
            }
            elseif ($column == 'SCORE_GROUP' && $score == $data['robot_score_group'])
            {
                $selectCheckQuery['CHECK_SCORE_GROUP'] = "'P'";
            }
            elseif ($column == 'PRODUCT_SCORE_GROUP' && $score == $data['robot_product_score_group'])
            {
                $selectCheckQuery['CHECK_PRODUCT_SCORE_GROUP'] = "'P'";
            }
            elseif ($column == 'SUB_SEGMENT' && $score == $data['robot_sub_segment'])
            {
                $selectCheckQuery['CHECK_SUB_SEGMENT'] = "'P'";
            }
             elseif ($column == 'LEAD_BLACK' && strtolower($score) == strtolower($data['robot_lead_black']))
            {
                $selectCheckQuery['CHECK_LEAD_BLACK'] = "'P'";
            }
        }

        $selectedCheckQuery = array();

        foreach ($selectCheckQuery as $column => $value)
        {
            $selectedCheckQuery[] = $column . ' = ' . $value;
        }

        $query = "UPDATE AUTOMATION_TEST_CASE_PL SET " . implode(',', $selectedCheckQuery) . " WHERE NATIONAL_ID = " . $data['national_id'];
        $stid  = oci_parse($connection, $query);
        oci_execute($stid);
        oci_commit($connection);

        return true;
    }

    /**
     * Function to update is run status
     *
     * @param  array   $data        Data to update
     * @param  string  $connection  Oracle connection
     *
     * @return void
     */
    public function updateIsRun($data, $connection)
    {
        $query = "UPDATE AUTOMATION_TEST_CASE_PL SET IS_RUN = 1 WHERE NATIONAL_ID = " . $data['NATIONAL_ID'];
        $stid  = oci_parse($connection, $query);
        oci_execute($stid);
        oci_commit($connection);

        return true;
    }

    /**
     * Function to update is run status
     *
     * @param  array   $data        Data to update
     * @param  string  $connection  Oracle connection
     *
     * @return void
     */
    public function updateNationalId($data, $connection)
    {
        $query = "UPDATE AUTOMATION_TEST_CASE_PL SET NATIONAL_ID = " . $data['TEMP_NATIONAL_ID'] . " WHERE PRODUCT_SCHEME = '" . $data['PRODUCT_SCHEME'] . "' AND NATIONAL_ID = " . $data['NATIONAL_ID'];
        $stid  = oci_parse($connection, $query);
        oci_execute($stid);
        oci_commit($connection);

        return true;
    }
}
