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
        $fileName                  = '034174001091_LÊ_THỊ_THỦY_20180420_094343.xml';
        $maxCurrentDebtGroup       = $this->currentDebtGroup($fileName);
        $maxCurrentDebtGroup5Years = $this->currentDebtGroup5Years($fileName);

        print_r(
            array(
                'File name'                  => $fileName,
                'Current Debt Group'         => $maxCurrentDebtGroup,
                'Current Debt Group 5 Years' => $maxCurrentDebtGroup5Years
            )
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

                $value['ReferenceYearMonth'] = $value['ReferenceYear'] . $value['ReferenceMonth'] . $value['Status'];
                $finalInstalments[] = $value;
            }

            usort($finalInstalments, function($a, $b){
                return ($a['ReferenceYearMonth'] < $b['ReferenceYearMonth']);
            });

            $instalmentsStatus = $finalInstalments[0]['Status'];
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

            $notInstalmentsStatus = $finalNotInstalments[0]['Status'];
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

            $cardsStatus = $cards[0]['Status'];
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

        if (!empty($array['RI_Req_Output']['CreditHistory']['Contract']['Instalments']['GrantedContract']))
        {
            foreach ($array['RI_Req_Output']['CreditHistory']['Contract']['Instalments']['GrantedContract'] as $key => $value)
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

        if (!empty($array['RI_Req_Output']['CreditHistory']['Contract']['NonInstalments']['GrantedContract']))
        {
            foreach ($array['RI_Req_Output']['CreditHistory']['Contract']['NonInstalments']['GrantedContract'] as $key => $value)
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

        if (!empty($array['RI_Req_Output']['CreditHistory']['Contract']['Cards']['GrantedContract']))
        {
            foreach ($array['RI_Req_Output']['CreditHistory']['Contract']['Cards']['GrantedContract'] as $key => $value)
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
     * Function to login
     *
     * @param   AcceptanceTester  $I         Acceptance Tester case.
     * @param   Scenario          $scenario  Scenario for test.
     *
     * @return  void
     */
    public function initData(AcceptanceTester $I, $scenario)
    {
        $initData = $this->executeData($I);
    }
}
