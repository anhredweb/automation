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
        $I->wait(5);

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
        $I->fillField(\GeneralXpathLibrary::$productPLGroup, '');
        $I->wait(1);
        $I->fillField(\GeneralXpathLibrary::$productPLGroup, $data['PRODUCT_GROUP']);
        $I->pressKey(\GeneralXpathLibrary::$productPLGroup, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
        $I->wait(1);
        $I->click(\GeneralXpathLibrary::$rowProductPLGroup);
        $I->wait(1);

        // Fill product scheme
        $I->fillField(\GeneralXpathLibrary::$productScheme, '');
        $I->wait(1);
        $I->fillField(\GeneralXpathLibrary::$productScheme, $data['PRODUCT_SCHEME']);
        $I->wait(1);
        $I->pressKey(\GeneralXpathLibrary::$productScheme, \Facebook\WebDriver\WebDriverKeys::ARROW_DOWN);
        $I->wait(1);
        $I->click(\GeneralXpathLibrary::$rowProductScheme);
        $I->wait(1);

        // Fill DSA code
        $I->fillField(\GeneralXpathLibrary::$DSACode, '');
        $I->wait(1);
        $I->fillField(\GeneralXpathLibrary::$DSACode, $data['DSA_CODE']);
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

        return $I->checkError($data['NATIONAL_ID']);
    }

    /**
     * Function to check documents for PL Application
     *
     * @return void
     */
    public function shortApplicationDocumentPL()
    {
        $I = $this;

        // Click demo data
        $I->wait(2);
        $I->click(\GeneralXpathLibrary::$demoPLDataDocument);
        $I->wait(1);

        // Click submit data
        $I->click(\GeneralXpathLibrary::$submitPLDocument);
        $I->wait(2);
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
            'SCORE_USER_GENDER',
            'SCORE_USER_WORK_EXPERIENCE',
            'SCORE_USER_AGE',
            'SCORE_USER_INTEREST_RATE',
            'SCORE_USER_DIST_OFFICE_ADD',
            'SCORE_USER_PROVINCE',
            'SCORE_USER_DISBURSE_DATE',
            'SCORE_USER_DPD_NO_DISB_APPS',
            'SCORE_USER_REJECTION',
            'TOTAL_SCORE',
            'SCORE_GROUP',
            'PRODUCT_SCORE_GROUP',
            'RANDOM_NUMBER'
        );
        $selectCheckQuery = array(
            'SCORE_CHECK_GENDER'           => "'F'",
            'SCORE_CHECK_WORK_EXPERIENCE'  => "'F'",
            'SCORE_CHECK_AGE'              => "'F'",
            'SCORE_CHECK_INTEREST_RATE'    => "'F'",
            'SCORE_CHECK_DIST_OFFICE_ADD'  => "'F'",
            'SCORE_CHECK_PROVINCE'         => "'F'",
            'SCORE_CHECK_DISBURSE_DATE'    => "'F'",
            'SCORE_CHECK_DPD_NO_DISB_APPS' => "'F'",
            'SCORE_CHECK_REJECTION'        => "'F'",
            'CHECK_TOTAL_SCORE'            => "'F'",
            'CHECK_SCORE_GROUP'            => "'F'",
            'CHECK_PRODUCT_SCORE_GROUP'    => "'F'",
            'CHECK_RANDOM_NUMBER'          => "'F'"
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
            if ($column == 'SCORE_USER_GENDER' && $score == $data['score_robot_gender'])
            {
                $selectCheckQuery['SCORE_CHECK_GENDER'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_WORK_EXPERIENCE' && $score == $data['score_robot_work_experience'])
            {
                $selectCheckQuery['SCORE_CHECK_WORK_EXPERIENCE'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_AGE' && $score == $data['score_robot_age'])
            {
                $selectCheckQuery['SCORE_CHECK_AGE'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_INTEREST_RATE' && $score == $data['score_robot_interest_rate'])
            {
                $selectCheckQuery['SCORE_CHECK_INTEREST_RATE'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_DIST_OFFICE_ADD' && $score == $data['score_robot_dist_office_add'])
            {
                $selectCheckQuery['SCORE_CHECK_DIST_OFFICE_ADD'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_PROVINCE' && $score == $data['score_robot_province'])
            {
                $selectCheckQuery['SCORE_CHECK_PROVINCE'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_DISBURSE_DATE' && $score == $data['score_robot_disburse_date'])
            {
                $selectCheckQuery['SCORE_CHECK_DISBURSE_DATE'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_DPD_NO_DISB_APPS' && $score == $data['score_robot_dpd_no_disb_apps'])
            {
                $selectCheckQuery['SCORE_CHECK_DPD_NO_DISB_APPS'] = "'P'";
            }
            elseif ($column == 'SCORE_USER_REJECTION' && $score == $data['score_robot_rejection'])
            {
                $selectCheckQuery['SCORE_CHECK_REJECTION'] = "'P'";
            }
            elseif ($column == 'TOTAL_SCORE' && $score == $data['robot_total_score'])
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

            elseif ($column == 'RANDOM_NUMBER' && $score == $data['robot_random_number'])
            {
                $selectCheckQuery['CHECK_RANDOM_NUMBER'] = "'P'";
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
}
