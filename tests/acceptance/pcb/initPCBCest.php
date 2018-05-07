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
     * @param   AcceptanceTester  $I  Acceptance Tester case.
     *
     * @return  void
     */
    protected function executeData($I)
    {
        $listFiles = array_diff(scandir('./PCB/'), array('..', '.'));
        //152107393_NGUYỄN_MINH_CHIẾN_20180402_114457

        foreach ($listFiles as $key => $file)
        {
            print_r($file);
            // Init Data
            // $fileName = '112191100_ĐẶNG_THỊ_THỦY_20180417_113120.xml';
            $path     = './PCB/' . $file;
            $xml      = simplexml_load_file($path);
            $json     = json_encode($xml);
            $data     = json_decode($json, true);

            // Get Data
            $cbSubjectCode              = $this->getCBSubjectCode($data);
            $maxCurrentDebtGroup        = $this->getCurrentDebtGroup($data);
            $maxCurrentDebtGroup5Years  = $this->getCurrentDebtGroup5Years($data);
            $pcbScore                   = $this->getPCBScore($data);
            $nationalID                 = $this->getNationalID($data);
            $fullName                   = $this->getFullName($data);
            $address                    = $this->getAddress($data);
            $mobile                     = $this->getMobile($data);
            $monthlyInstalment          = $this->getMonthlyInstalment($data);
            $creditLimit                = $this->getCreditLimit($data);
            $creditLimitNonInstalment   = $this->getCreditLimitNonInstalment($data);
            $acMonthlyInstalment        = $this->getACMonthlyInstalment($data);
            $acCreditLimit              = $this->getACCreditLimit($data);
            $acCreditLimitNonInstalment = $this->getACCreditLimitNonInstalment($data);

            $initData = array(
                "'" . str_replace("'", " ", $file) . "'",
                "'" . $cbSubjectCode . "'",
                $maxCurrentDebtGroup,
                $maxCurrentDebtGroup5Years,
                $pcbScore,
                "'" . $nationalID . "'",
                "'" . str_replace("'", " ", $fullName) . "'",
                "'" . str_replace("'", " ", $address) . "'",
                "'" . $mobile . "'",
                $monthlyInstalment,
                $creditLimit,
                $creditLimitNonInstalment,
                $acMonthlyInstalment,
                $acCreditLimit,
                $acCreditLimitNonInstalment
            );

            $this->updateData($initData);
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
        $resultInstalments = array();
        $instalmentsData = !empty($xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Instalments']['GrantedContract']) ? $xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Instalments']['GrantedContract'] : array();

        if (!empty($instalmentsData))
        {
            foreach ($instalmentsData as $key => $value)
            {
                if (!empty($value['CommonData']) && $value['CommonData']['ContractPhase'] != 'LV')
                {
                    continue;
                }

                $resultInstalments[$key] = $value;
            }
        }   

        $instalments       = array();
        $instalmentsStatus = 0;

        if (!empty($resultInstalments))
        {
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
                
                if (is_array($values))
                {
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

            $instalmentsStatus = !empty($finalInstalments) ? (int) $finalInstalments[0]['Status'] : 0;
        }

        $resultNotInstalments = array();
        $notInstalmentsData = !empty($xmlArray['RI_Req_Output']['CreditHistory']['Contract']['NonInstalments']['GrantedContract']) ? $xmlArray['RI_Req_Output']['CreditHistory']['Contract']['NonInstalments']['GrantedContract'] : array();

        if (!empty($notInstalmentsData))
        {
            foreach ($notInstalmentsData as $key => $value)
            {
                if (!empty($value['CommonData']) && $value['CommonData']['ContractPhase'] != 'LV')
                {
                    continue;
                }

                $resultNotInstalments[] = $value;
            }
        }

        $notInstalments       = array();
        $notInstalmentsStatus = 0;

        if (!empty($resultNotInstalments))
        {
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
                if (is_array($values))
                {
                    foreach ($values as $value)
                    {
                        $newNotInstalments[$i] = $value;
                        $i++;
                    }    
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

            $notInstalmentsStatus = !empty($finalNotInstalments) ? (int) $finalNotInstalments[0]['Status'] : 0;
        }

        $resultCards = array();
        $cardsData = !empty($xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Cards']['GrantedContract']) ? $xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Cards']['GrantedContract'] : array();

        if (!empty($cardsData) && !empty($cardsData['CommonData']) && $cardsData['CommonData']['ContractPhase'] == 'LV')
        {
            $resultCards[] = $cardsData['Profiles'];
        }

        $cards       = array();
        $cardsStatus = 0;

        if (!empty($resultCards))
        {
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

            $cardsStatus = !empty($cards) ? (int) $cards[0]['Status'] : 0;
        }

        return max(array($instalmentsStatus, $notInstalmentsStatus, $cardsStatus));
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
        $iwsArr = array();
        $instalmentsData = !empty($xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Instalments']['GrantedContract']) ? $xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Instalments']['GrantedContract'] : array();

        if (!empty($instalmentsData))
        {
            if (!empty($instalmentsData['WorstStatus']))
            {
                $iwsArr[] = $instalmentsData['WorstStatus'];
            }

            if (!empty($instalmentsData['Profiles']['Status']))
            {
                $iwsArr[] = $instalmentsData['Profiles']['Status'];
            }

            foreach ($instalmentsData as $key => $value)
            {
                if (!empty($value['WorstStatus']))
                {
                    $iwsArr[] = $value['WorstStatus'];
                }

                if (!empty($value['Profiles']['Status']))
                {
                    $iwsArr[] = $value['Profiles']['Status'];
                }
            }
        }   

        $iws = !empty($iwsArr) ? max($iwsArr) : 0;

        $nwsArr = array();
        $notInstalmentsData = !empty($xmlArray['RI_Req_Output']['CreditHistory']['Contract']['NonInstalments']['GrantedContract']) ? $xmlArray['RI_Req_Output']['CreditHistory']['Contract']['NonInstalments']['GrantedContract'] : array();

        if (!empty($notInstalmentsData))
        {
            if (!empty($notInstalmentsData['WorstStatus']))
            {
                $nwsArr[] = $notInstalmentsData['WorstStatus'];
            }

            if (!empty($notInstalmentsData['Profiles']['Status']))
            {
                $nwsArr[] = $notInstalmentsData['Profiles']['Status'];
            }

            foreach ($notInstalmentsData as $key => $value)
            {
                if (!empty($value['WorstStatus']))
                {
                    $nwsArr[] = $value['WorstStatus'];
                }

                if (!empty($value['Profiles']['Status']))
                {
                    $nwsArr[] = $value['Profiles']['Status'];
                }
            }
        }   

        $nws = !empty($nwsArr) ? max($nwsArr) : 0;

        $cwsArr = array();
        $cardsData = !empty($xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Cards']['GrantedContract']) ? $xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Cards']['GrantedContract'] : array();

        if (!empty($cardsData))
        {
            if (!empty($cardsData['WorstStatus']))
            {
                $cwsArr[] = $cardsData['WorstStatus'];
            }

            if (!empty($cardsData['Profiles']['Status']))
            {
                $cwsArr[] = $cardsData['Profiles']['Status'];
            }

            foreach ($cardsData as $key => $value)
            {
                if (!empty($value['WorstStatus']))
                {
                    $cwsArr[] = $value['WorstStatus'];
                }

                if (!empty($value['Profiles']['Status']))
                {
                    $cwsArr[] = $value['Profiles']['Status'];
                }
            }
        }   

        $cws = !empty($cwsArr) ? max($cwsArr) : 0;

        return max(array($iws, $nws, $cws));
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
        return !empty($xmlArray['RI_Req_Output']['CreditHistory']['Contract']['ScoreProfile']['ScoreDetailst']['ScoreRaw']) ? $xmlArray['RI_Req_Output']['Contract']['ScoreProfile']['ScoreDetailst']['ScoreRaw'] : 0;
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

        $reference  = $xmlArray['RI_Req_Output']['Subject']['Matched']['Person']['Reference'];
        $mobileList = array();
        $mobile     = '';
        $type       = '';

        foreach ($reference as $key => $value)
        {
            if ($key = 'Number')
            {
                $mobile = $value;
            }

            if ($key = 'Type')
            {
                $type = $value;
            }

            if (is_array($value) && ($value['Type'] == 'PN' || $value['Type'] == 'MP'))
            {
                $mobileList['Type']   = $value['Type'];
                $mobileList['Number'] = $value['Number'];
            }
        }

        if (!empty($mobileList))
        {
            $type   = $mobileList['Type'];
            $mobile = $mobileList['Number'];
        }

        return (!empty($mobile) && ($type == 'PN' || $type == 'MP')) ? $mobile : 0;
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
        $resultInstalments = array();
        $instalmentsData = !empty($xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Instalments']['GrantedContract']) ? $xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Instalments']['GrantedContract'] : array();

        if (!empty($instalmentsData))
        {
            foreach ($instalmentsData as $key => $value)
            {
                if (!empty($value['CommonData']) && $value['CommonData']['ContractPhase'] != 'LV')
                {
                    continue;
                }

                $resultInstalments[] = !empty($value['MonthlyInstalmentAmount']) ? $value['MonthlyInstalmentAmount'] : 0;
            }
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
        $resultCards = array();
        $cardsData = !empty($xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Cards']['GrantedContract']) ? $xmlArray['RI_Req_Output']['CreditHistory']['Contract']['Cards']['GrantedContract'] : array();

        if (!empty($cardsData))
        {
            foreach ($cardsData as $key => $value)
            {
                if (!empty($value['CommonData']) && $value['CommonData']['ContractPhase'] != 'LV')
                {
                    continue;
                }

                $resultInstalments[] = !empty($value['CreditLimit']) ? $value['CreditLimit'] : 0;
            }
        }

        return !empty($resultInstalments) ? array_sum($resultInstalments) : 0;
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
        $resultNonInstalments = array();
        $nonInstalmentsData = !empty($xmlArray['RI_Req_Output']['CreditHistory']['Contract']['NotInstalments']['GrantedContract']) ? $xmlArray['RI_Req_Output']['CreditHistory']['Contract']['NotInstalments']['GrantedContract'] : array();

        if (!empty($nonInstalmentsData))
        {
            foreach ($nonInstalmentsData as $key => $value)
            {
                if (!empty($value['CommonData']) && $value['CommonData']['ContractPhase'] != 'LV')
                {
                    continue;
                }

                $resultNonInstalments[] = !empty($value['AmountOfTheCredit']) ? $value['AmountOfTheCredit'] : 0;
            }
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
     * Function to init Data
     *
     * @param   AcceptanceTester  $I         Acceptance Tester case.
     * @param   Scenario          $scenario  Scenario for test.
     *
     * @return  void
     */
    public function initData(AcceptanceTester $I, $scenario)
    {
        $this->executeData($I);
    }
}
