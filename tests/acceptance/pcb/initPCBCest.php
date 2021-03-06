<?php
/**
 * @package     FE Credit
 * @subpackage  Automation Testing
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Class init to check PCB
 *
 * @since  1.0
 */
class initPCBCest
{
    /**
     * Execute Data.
     *
     * @return  void
     */
    protected function executeData()
    {
        $pcbPath   = './PCB_UAT/';
        $listFiles = array_diff(scandir($pcbPath), array('..', '.'));

        foreach ($listFiles as $key => $file)
        {
            print_r($file);

            // Init Data
            $path = $pcbPath . $file;
            $xml  = simplexml_load_file($path);
            $json = json_encode($xml);
            $data = json_decode($json, true);

            // Get Data
            $cbSubjectCode              = $this->getCBSubjectCode($data);
            $maxCurrentDebtGroup        = $this->getCurrentDebtGroup($data);
            $maxCurrentDebtGroup5Years  = $this->getCurrentDebtGroup5Years($data);
            $pcbScore                   = $this->getPCBScore($data);
            $nationalID                 = $this->getNationalID($data);
            $fullName                   = $this->getFullName($data);
            $address                    = $this->getAddress($data);
            $mobile                     = $this->getMobile($data);
            $gender                     = $this->getGender($data);
            $dateOfBirth                = $this->getDateOfBirth($data);
            $monthlyInstalment          = $this->getMonthlyInstalment($data);
            $creditLimit                = $this->getCreditLimit($data);
            $creditLimitNonInstalment   = $this->getCreditLimitNonInstalment($data);
            $acMonthlyInstalment        = $this->getACMonthlyInstalment($data);
            $acCreditLimit              = $this->getACCreditLimit($data);
            $acCreditLimitNonInstalment = $this->getACCreditLimitNonInstalment($data);

            $pcbStatus = 'PCB FOUND';
            $pcbResult = 'NEGATIVE';

            if ($maxCurrentDebtGroup === 1 && $maxCurrentDebtGroup5Years <= 2)
            {
                $pcbStatus = 'PCB FOUND';
                $pcbResult = 'POSITIVE';
            }
            elseif ($maxCurrentDebtGroup === 0 && $maxCurrentDebtGroup5Years === 0)
            {
                $pcbStatus = 'PCB NO RESULT FOUND';
                $pcbResult = 'NEUTRAL';
            }

            $initData = array(
                'file'                           => $this->formatString($file),
                'cb_subject_code'                => $this->formatString($cbSubjectCode),
                'max_current_debt_group'         => $maxCurrentDebtGroup,
                'max_current_debt_group_5_years' => $maxCurrentDebtGroup5Years,
                'pcb_score'                      => $pcbScore,
                'national_id'                    => $this->formatString($nationalID),
                'full_name'                      => $this->formatString($fullName),
                'address'                        => $this->formatString($address),
                'mobile'                         => $this->formatString($mobile),
                'gender'                         => $this->formatString($gender),
                'date_of_birth'                  => $this->formatDate($dateOfBirth),
                'monthly_instalment'             => $monthlyInstalment,
                'credit_limit'                   => $creditLimit,
                'credit_limit_non_instalment'    => $creditLimitNonInstalment,
                'ac_monthly_instalment'          => $acMonthlyInstalment,
                'ac_credit_limit'                => $acCreditLimit,
                'ac_credit_limit_non_instalment' => $acCreditLimitNonInstalment,
                'pcb_status'                     => $pcbStatus,
                'pcb_result'                     => $pcbResult
            );

            // $this->updateData($initData);
            print_r($key);
            print_r($initData);
        }
    }

    /**
     * Get Current Debt Group
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  integer
     */
    protected function getCurrentDebtGroup($xmlArray)
    {
        $instalmentsStatus    = $this->getInstalmentsDebtGroup($xmlArray);
        $notInstalmentsStatus = $this->getNonInstalmentsDebtGroup($xmlArray);
        $cardsStatus          = $this->getCardsDebtGroup($xmlArray);

        return max(array($instalmentsStatus, $notInstalmentsStatus, $cardsStatus));
    }

    /**
     * Get Instalments Debt Group
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  integer
     */
    protected function getInstalmentsDebtGroup($xmlArray)
    {
        $resultInstalments = array();
        $instalmentsData = $this->getInstalmentsData($xmlArray);

        if (empty($instalmentsData))
        {
            return 0;
        }   

        foreach ($instalmentsData as $key => $value)
        {
            if (!empty($value['CommonData']) && $value['CommonData']['ContractPhase'] != 'LV')
            {
                continue;
            }

            $resultInstalments[$key] = $value;
        }

        $instalments = array();

        if (empty($resultInstalments))
        {
            return 0;
        }

        foreach ($resultInstalments as $key => $value)
        {
            if (empty($value['Profiles']))
            {
                continue;
            }

            $instalments[] = $value['Profiles'];
        }

        $newInstalments = array();
        $i = 0;

        foreach ($instalments as $key => $values)
        {
            
            if (!is_array($values))
            {
                 continue; 
            }

            if (!empty($values['ReferenceYear']))
            {
                $newInstalments[$i] = $values;
                $i++;
            }
            else
            {
                foreach ($values as $value)
                {
                    $newInstalments[$i] = $value;
                    $i++;
                }
            }
        }

        $finalInstalments = array();

        foreach ($newInstalments as $key => $value)
        {
            if (!is_array($value))
            {
                continue;
            }

            $value['Status'] = (int) $value['Status'];
            $value['ReferenceYearMonth'] = $value['ReferenceYear'] . $value['ReferenceMonth'] . $value['Status'];
            $finalInstalments[] = $value;
        }

        usort($finalInstalments, function($a, $b){
            return ($a['ReferenceYearMonth'] < $b['ReferenceYearMonth']);
        });

        return !empty($finalInstalments) ? (int) $finalInstalments[0]['Status'] : 0;
    }

    /**
     * Get Non-Instalments Debt Group
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  integer
     */
    protected function getNonInstalmentsDebtGroup($xmlArray)
    {
        $resultNotInstalments = array();
        $notInstalmentsData = $this->getNonInstalmentsData($xmlArray);

        if (empty($notInstalmentsData))
        {
            return 0;
        }

        foreach ($notInstalmentsData as $key => $value)
        {
            if (!empty($value['CommonData']) && $value['CommonData']['ContractPhase'] != 'LV')
            {
                continue;
            }

            $resultNotInstalments[] = $value;
        }

        $notInstalments = array();

        if (empty($resultNotInstalments))
        {
            return 0;
        }

        foreach ($resultNotInstalments as $key => $value)
        {
            if (empty($value['Profiles']))
            {
                continue;
            }

            $notInstalments[] = $value['Profiles'];
        }

        $newNotInstalments = array();
        $i = 0;

        foreach ($notInstalments as $key => $values)
        {
            if (!is_array($values))
            {
                continue;
            }

            foreach ($values as $value)
            {
                $newNotInstalments[$i] = $value;
                $i++;
            }
        }

        $finalNotInstalments = array();

        foreach ($newNotInstalments as $key => $value)
        {
            if (!is_array($value))
            {
                continue;
            }

            $value['Status'] = (int) $value['Status'];
            $value['ReferenceYearMonth'] = $value['ReferenceYear'] . $value['ReferenceMonth'] . $value['Status'];
            $finalNotInstalments[] = $value;
        }

        usort($finalNotInstalments, function($a, $b){
            return ($a['ReferenceYearMonth'] < $b['ReferenceYearMonth']);
        });

        return !empty($finalNotInstalments) ? (int) $finalNotInstalments[0]['Status'] : 0;
    }

    /**
     * Get Cards Debt Group
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  integer
     */
    protected function getCardsDebtGroup($xmlArray)
    {
        $resultCards = array();
        $cardsData = $this->getCardsData($xmlArray);

        if (empty($cardsData))
        {
            return 0;
        }

        if (!empty($cardsData['CommonData']))
        {
            $resultCards = $cardsData['Profiles'];
        }
        else
        {
            foreach ($cardsData as $key => $value)
            {
                if (empty($value['CommonData']) && $value['CommonData']['ContractPhase'] != 'LV')
                {
                    continue;
                }

                $resultCards[] = $value['Profiles'];
            }
        }

        if (empty($resultCards))
        {
            return 0;
        }

        $cards = array();

        if (!empty($cardsData['CommonData']))
        {
            $resultCards = array($resultCards);
        }

        foreach ($resultCards as $key => $value)
        {
            $cards = $value;

            if (!empty($cards['ReferenceYear']))
            {
                $cards['Status'] = (int) $cards['Status'];
                $cards['ReferenceYearMonth'] = $cards['ReferenceYear'] . $cards['ReferenceMonth'] . $cards['Status'];
            }
        }

        if (empty($cards['ReferenceYear']))
        {
            foreach ($cards as $key => $value)
            {
                $value['Status'] = (int) $value['Status'];
                $cards[$key]['ReferenceYearMonth'] = $value['ReferenceYear'] . $value['ReferenceMonth'] . $value['Status'];
            }
        }

        if (empty($cards['ReferenceYearMonth']))
        {
            usort($cards, function($a, $b){
                return $a['ReferenceYearMonth'] < $b['ReferenceYearMonth'];
            });
        }
        else
        {
            $cards = array($cards);
        }

        return !empty($cards) ? (int) $cards[0]['Status'] : 0;
    }

    /**
     * Get Current Debt Group 5 Years
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  integer
     */
    protected function getCurrentDebtGroup5Years($xmlArray)
    {

        $iws = $this->getIWS($xmlArray);
        $nws = $this->getNWS($xmlArray); 
        $cws = $this->getCWS($xmlArray); 

        return max(array($iws, $nws, $cws));
    }

    /**
     * Get Instalments
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  integer
     */
    protected function getIWS($xmlArray)
    {
        $iwsArr = array();
        $instalmentsData = $this->getInstalmentsData($xmlArray);

        if (empty($instalmentsData))
        {
            return 0;
        }   

        $iwsArr[] = !empty($instalmentsData['WorstStatus']) ? $instalmentsData['WorstStatus'] : 0;
        $iwsArr[] = !empty($instalmentsData['Profiles']['Status']) ? $instalmentsData['Profiles']['Status'] : 0;

        foreach ($instalmentsData as $key => $value)
        {
            $iwsArr[] = !empty($value['WorstStatus']) ? $value['WorstStatus'] : 0;
            $iwsArr[] = !empty($value['Profiles']['Status']) ? $value['Profiles']['Status'] : 0;
        }

        return !empty($iwsArr) ? max($iwsArr) : 0;
    }

    /**
     * Get Non-Instalments
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  integer
     */
    protected function getNWS($xmlArray)
    {
        $nwsArr = array();
        $notInstalmentsData = $this->getNonInstalmentsData($xmlArray);

        if (empty($notInstalmentsData))
        {
            return 0;
        }   

        $nwsArr[] = !empty($notInstalmentsData['WorstStatus']) ? $notInstalmentsData['WorstStatus'] : 0;
        $nwsArr[] = !empty($notInstalmentsData['Profiles']['Status']) ? $notInstalmentsData['Profiles']['Status'] : 0;

        foreach ($notInstalmentsData as $key => $value)
        {
            $nwsArr[] = !empty($value['WorstStatus']) ? $value['WorstStatus'] : 0;
            $nwsArr[] = !empty($value['Profiles']['Status']) ? $value['Profiles']['Status'] : 0;
        }

        return !empty($nwsArr) ? max($nwsArr) : 0;
    }

    /**
     * Get Cards
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  integer
     */
    protected function getCWS($xmlArray)
    {
        $cwsArr = array();
        $cardsData = $this->getCardsData($xmlArray);

        if (empty($cardsData))
        {
            return 0;
        }

        $cwsArr[] = !empty($cardsData['WorstStatus']) ? $cardsData['WorstStatus'] : 0;
        $cwsArr[] = !empty($cardsData['Profiles']['Status']) ? $cardsData['Profiles']['Status'] : 0;

        foreach ($cardsData as $key => $value)
        {
            $cwsArr[] = !empty($value['WorstStatus']) ? $value['WorstStatus'] : 0;
            $cwsArr[] = !empty($value['Profiles']['Status']) ? $value['Profiles']['Status'] : 0;
        }

        return !empty($cwsArr) ? max($cwsArr) : 0;
    }

    /**
     * Get Non-Instalments Data
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  array
     */
    protected function getInstalmentsData($xmlArray)
    {
        return !empty($xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Instalments']['GrantedContract']) ? $xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Instalments']['GrantedContract'] : array();
    }

    /**
     * Get Instalments Data
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  array
     */
    protected function getNonInstalmentsData($xmlArray)
    {
        return !empty($xmlArray['RI_Req_Output']['CreditHistory']['Contract']['NonInstalments']['GrantedContract']) ? $xmlArray['RI_Req_Output']['CreditHistory']['Contract']['NonInstalments']['GrantedContract'] : array();
    }

    /**
     * Get Cards Data
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  array
     */
    protected function getCardsData($xmlArray)
    {
        return !empty($xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Cards']['GrantedContract']) ? $xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Cards']['GrantedContract'] : array();
    }

    /**
     * Get CB Subject Code
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  integer
     */
    protected function getCBSubjectCode($xmlArray)
    {
        return !empty($xmlArray['RI_Req_Output']['Subject']['Inquired']['CBSubjectCode']) ? $xmlArray['RI_Req_Output']['Subject']['Inquired']['CBSubjectCode'] : 0;
    }

    /**
     * Get PCB Score
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  integer
     */
    protected function getPCBScore($xmlArray)
    {
        return !empty($xmlArray['RI_Req_Output']['CreditHistory']['Contract']['ScoreProfile']['ScoreDetail']['ScoreRaw']) ? $xmlArray['RI_Req_Output']['CreditHistory']['Contract']['ScoreProfile']['ScoreDetail']['ScoreRaw'] : 0;
    }

    /**
     * Get National ID
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  integer
     */
    protected function getNationalID($xmlArray)
    {
        return !empty($xmlArray['RI_Req_Output']['Subject']['Inquired']['Person']['IDCard']) ? $xmlArray['RI_Req_Output']['Subject']['Inquired']['Person']['IDCard'] : 0;
    }

    /**
     * Get Full name
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  string
     */
    protected function getFullName($xmlArray)
    {
        return !empty($xmlArray['RI_Req_Output']['Subject']['Inquired']['Person']['Name']) ? $xmlArray['RI_Req_Output']['Subject']['Inquired']['Person']['Name'] : '';
    }

    /**
     * Get Address
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  string
     */
    protected function getAddress($xmlArray)
    {
        return !empty($xmlArray['RI_Req_Output']['Subject']['Matched']['Person']['Address']['Main']['FullAddress']) ? $xmlArray['RI_Req_Output']['Subject']['Matched']['Person']['Address']['Main']['FullAddress'] : '';
    }

    /**
     * Get Gender
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  string
     */
    protected function getGender($xmlArray)
    {
        return !empty($xmlArray['RI_Req_Output']['Subject']['Matched']['Person']['Gender']) ? $xmlArray['RI_Req_Output']['Subject']['Matched']['Person']['Gender'] : '';
    }

    /**
     * Get Date of Birth
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  string
     */
    protected function getDateOfBirth($xmlArray)
    {
        $dateOfBirth = !empty($xmlArray['RI_Req_Output']['Subject']['Matched']['Person']['DateOfBirth']) ? $xmlArray['RI_Req_Output']['Subject']['Matched']['Person']['DateOfBirth'] : '';

        $day = substr($dateOfBirth, 0, 2);
        $month = substr($dateOfBirth, 2, 2);
        $year = substr($dateOfBirth, 4, 4);

        return $day . '/' . $month . '/' . $year;
    }

    /**
     * Get Mobile
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  integer
     */
    protected function getMobile($xmlArray)
    {
        if (empty($xmlArray['RI_Req_Output']['Subject']['Matched']['Person']['Reference']))
        {
            return 0;
        }

        $reference = $xmlArray['RI_Req_Output']['Subject']['Matched']['Person']['Reference'];
        $mobile    = 0;

        if (isset($reference['Number']))
        {
            return (!empty($reference['Type']) && ($reference['Type'] == 'PN' || $reference['Type'] == 'MP')) ? $reference['Number'] : 0;
        }

        foreach ($reference as $key => $value)
        {
            if (!is_array($value) && !empty($value['Type']) && ($value['Type'] != 'PN' || $value['Type'] != 'MP'))
            {
                continue;
            }

            $mobile = $value['Number'];
        }

        return $mobile;
    }

    /**
     * Get Monthly instalment
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  integer
     */
    protected function getMonthlyInstalment($xmlArray)
    {
        $instalmentsData = $this->getInstalmentsData($xmlArray);

        if (empty($instalmentsData))
        {
            return 0;
        }

        if (!empty($instalmentsData['MonthlyInstalmentAmount']))
        {
            return $instalmentsData['MonthlyInstalmentAmount'];
        }

        $resultInstalments = array();

        foreach ($instalmentsData as $key => $value)
        {
            if ((!empty($value['CommonData']) && $value['CommonData']['ContractPhase'] != 'LV') || empty($value['MonthlyInstalmentAmount']))
            {
                continue;
            }

            $resultInstalments[] = $value['MonthlyInstalmentAmount'];
        }

        return !empty($resultInstalments) ? array_sum($resultInstalments) : 0;
    }

    /**
     * Get Credit limit
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  integer
     */
    protected function getCreditLimit($xmlArray)
    {
        $cardsData = $this->getCardsData($xmlArray);

        if (empty($cardsData))
        {
            return 0;
        }

        if (!empty($cardsData['CreditLimit']))
        {
           return $cardsData['CreditLimit'];
        }

        $resultCards = array();

        foreach ($cardsData as $key => $value)
        {
            if ((!empty($value['CommonData']) && $value['CommonData']['ContractPhase'] != 'LV') || empty($value['CreditLimit']))
            {
                continue;
            }

            $resultCards[] = $value['CreditLimit'];
        }

        return !empty($resultCards) ? array_sum($resultCards) : 0;
    }

    /**
     * Get Monthly Non-instalment
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  integer
     */
    protected function getCreditLimitNonInstalment($xmlArray)
    {
        $nonInstalmentsData = $this->getNonInstalmentsData($xmlArray);

        if (empty($nonInstalmentsData))
        {
            return 0;
        }

        if (!empty($nonInstalmentsData['AmountOfTheCredits']))
        {
            return $nonInstalmentsData['AmountOfTheCredits'];
        }

        $resultNonInstalments = array();

        foreach ($nonInstalmentsData as $key => $value)
        {
            if ((!empty($value['CommonData']) && $value['CommonData']['ContractPhase'] != 'LV') || empty($value['AmountOfTheCredits']))
            {
                continue;
            }

            $resultNonInstalments[] = $value['AmountOfTheCredits'];
        }

        return !empty($resultNonInstalments) ? array_sum($resultNonInstalments) : 0;
    }

    /**
     * Get AC Monthly instalment
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  integer
     */
    protected function getACMonthlyInstalment($xmlArray)
    {
        return !empty($xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Instalments']['ACInstAmounts']['MonthlyInstalmentsAmount']) ? $xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Instalments']['ACInstAmounts']['MonthlyInstalmentsAmount'] : 0;
    }

    /**
     * Get AC Credit Limit
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  integer
     */
    protected function getACCreditLimit($xmlArray)
    {
        return !empty($xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Cards']['ACCardAmounts']['LimitOfCredit']) ? $xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Cards']['ACCardAmounts']['LimitOfCredit'] : 0;
    }

    /**
     * Get AC Monthly Non-instalment
     *
     * @param  $xmlArray  array  XML Array
     *
     * @return  integer
     */
    protected function getACCreditLimitNonInstalment($xmlArray)
    {
        return !empty($xmlArray['RI_Req_Output']['CreditHistory']['Contract']['NonInstalments']['ACNoInstAmounts']['CreditLimit']) ? $xmlArray['RI_Req_Output']['CreditHistory']['Contract']['NonInstalments']['ACNoInstAmounts']['CreditLimit'] : 0;
    }

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
        return oci_connect("COMMON", "Common_Risk_0616", $db, 'AL32UTF8');
    }

    /**
     * Connect to Oracle F1_UAT05.
     *
     * @return  mixed
     */
    protected function connectOracleUAT05()
    {
        $db = "(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.30.110.93)(PORT = 1521)))(CONNECT_DATA = (SERVICE_NAME = finnuat5.fecredit.com.vn)))" ;

        // Create connection to Oracle
        return oci_connect("MULCASTRANS", "ANSF1UAT05", $db, 'AL32UTF8');
    }

    /**
     * Function to update is run status
     *
     * @param  array  $data  Data to update
     *
     * @return void
     */
    protected function updateData($data)
    {
        $query = "INSERT INTO TBL_POL_SIS_PCB_FIELDMAPPING VALUES(" . implode(',', $data) . ")";
        $stid  = oci_parse($this->connectOracle(), $query);
        oci_execute($stid);
        oci_commit($this->connectOracle());

        return;
    }

    /**
     * Function to format string
     *
     * @param  string  $string  String to format
     *
     * @return string
     */
    protected function formatString($string)
    {
        return "'" . str_replace("'", " ", $string) . "'";
    }

    /**
     * Function to format date
     *
     * @param  string  $date  Date to format
     *
     * @return string
     */
    protected function formatDate($date)
    {
        return "TO_DATE(" . $this->formatString($date) . ", 'DD/MM/YYYY')";
    }

    /**
     * Function to init Data
     *
     * @return  void
     */
    public function initData()
    {
        $this->executeData();
    }
}

