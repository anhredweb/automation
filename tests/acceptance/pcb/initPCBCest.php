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
     * @return  array
     */
    protected function executeData($I)
    {
        //152107393_NGUYỄN_MINH_CHIẾN_20180402_114457
        $fileName                  = '364023242_NGUYỄN_VĂN_ÚT_20180404_175302.xml';
        $maxCurrentDebtGroup       = $this->currentDebtGroup($fileName);
        $maxCurrentDebtGroup5Years = $this->currentDebtGroup5Years($fileName);

        return 
            array(
                'File name'                  => $fileName,
                'Current Debt Group'         => $maxCurrentDebtGroup,
                'Current Debt Group 5 Years' => $maxCurrentDebtGroup5Years
            );
    }

    /**
     * Get Current Debt Group
     *
     * @param  $fileName  string  file name
     *
     * @return  integer
     */
    protected function currentDebtGroup($fileName)
    {
        $path  = './PCB/' . $fileName;
        $xml   = simplexml_load_file($path);
        $json  = json_encode($xml);
        $array = json_decode($json, true);

        $resultInstalments = array();

        if (!empty($array['RI_Req_Output']['CreditHistory']['Contract']['Instalments']['GrantedContract']))
        {
            foreach ($array['RI_Req_Output']['CreditHistory']['Contract']['Instalments']['GrantedContract'] as $key => $value)
            {
                if (!empty($value['CommonData']) && $value['CommonData']['ContractPhase'] != 'LV')
                {
                    continue;
                }

                $resultInstalments[] = $value;
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

                $value['ReferenceYearMonth'] = $value['ReferenceYear'] . $value['ReferenceMonth'] . (int) $value['Status'];
                $finalInstalments[] = $value;
            }

            usort($finalInstalments, function($a, $b){
                return ($a['ReferenceYearMonth'] < $b['ReferenceYearMonth']);
            });

            $instalmentsStatus = !empty($finalInstalments) ? $finalInstalments[0]['Status'] : 0;
        }

        $resultNotInstalments = array();

        if (!empty($array['RI_Req_Output']['CreditHistory']['Contract']['NonInstalments']['GrantedContract']))
        {
            foreach ($array['RI_Req_Output']['CreditHistory']['Contract']['NonInstalments']['GrantedContract'] as $key => $value)
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

                $value['ReferenceYearMonth'] = $value['ReferenceYear'] . $value['ReferenceMonth'] . $value['Status'];
                $finalNotInstalments[] = $value;
            }

            usort($finalNotInstalments, function($a, $b){
                return ($a['ReferenceYearMonth'] < $b['ReferenceYearMonth']);
            });

            $notInstalmentsStatus = !empty($finalNotInstalments) ? $finalNotInstalments[0]['Status'] : 0;
        }

        $resultCards = array();

        if (!empty($array['RI_Req_Output']['CreditHistory']['Contract']['Cards']['GrantedContract']))
        {
            $data = $array['RI_Req_Output']['CreditHistory']['Contract']['Cards']['GrantedContract'];

            if (!empty($data['CommonData']) && $data['CommonData']['ContractPhase'] == 'LV')
            {
                $resultCards[] = $data['Profiles'];
            }
        }

        $cards       = array();
        $cardsStatus = 0;

        if (!empty($resultCards))
        {
            foreach ($resultCards as $key => $value)
            {
                $cards = $value;
            }

            usort($cards, function($a, $b){
                return ($a['ReferenceYear'] < $b['ReferenceYear'] && $a['ReferenceMonth'] < $b['ReferenceMonth']);
            });

            $cardsStatus = !empty($cards) ? $cards[0]['Status'] : 0;
        }

        $creditHistory = array($instalmentsStatus, $notInstalmentsStatus, $cardsStatus);

        return max($creditHistory);
    }

    /**
     * Get Current Debt Group 5 Years
     *
     * @param  $fileName  string  file name
     *
     * @return  integer
     */
    protected function currentDebtGroup5Years($fileName)
    {
        $path  = './PCB/' . $fileName;
        $xml   = simplexml_load_file($path);
        $json  = json_encode($xml);
        $array = json_decode($json, true);

        $iwsArr = array();
        $instalmentsData = !empty($array['RI_Req_Output']['CreditHistory']['Contract']['Instalments']['GrantedContract']) ? $array['RI_Req_Output']['CreditHistory']['Contract']['Instalments']['GrantedContract'] : array();

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

        $iws = 0;

        if (!empty($iwsArr))
        {
            $iws = max($iwsArr);
        }

        $nwsArr = array();
        $notInstalmentsData = !empty($array['RI_Req_Output']['CreditHistory']['Contract']['NonInstalments']['GrantedContract']) ? $array['RI_Req_Output']['CreditHistory']['Contract']['NonInstalments']['GrantedContract'] : array();

        if (!empty($notInstalmentsData))
        {
            if (!empty($notInstalmentsData['WorstStatus']))
            {
                $iwsArr[] = $notInstalmentsData['WorstStatus'];
            }

            if (!empty($notInstalmentsData['Profiles']['Status']))
            {
                $iwsArr[] = $notInstalmentsData['Profiles']['Status'];
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

        $nws = 0;

        if (!empty($nwsArr))
        {
            $nws = max($nwsArr);
        }

        $cwsArr = array();
        $cardsData = !empty($array['RI_Req_Output']['CreditHistory']['Contract']['Cards']['GrantedContract']) ? $array['RI_Req_Output']['CreditHistory']['Contract']['Cards']['GrantedContract'] : array();

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

        $cws = 0;

        if (!empty($cwsArr))
        {
            $cws = max($cwsArr);
        }

        $creditHistory = array($iws, $nws, $cws);

        return max($creditHistory);
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
        $initData = $this->executeData($I);

        print_r($initData);
    }
}
