<?php

namespace App\Http\Requests;


class MobileNumberValidator
{
    /**
     * Validate local/international Mobile No
     *
     *
    valid number format: [
    '+8801822141954',
    '01199098893',
    '8801571750328',
    '1571750328',
    ],
     */


    private $local_regex = '/\+?(88)?0?[1,4][13-9][0-9]{8}\b$/';

    // reference: https://stackoverflow.com/a/6967885
    private $international_regex = '/^(\+|00){0,2}(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|2[98654321]\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)\d{1,14}$/';


    private $international_regex_ext = '/(\+|00)(297|93|244|1264|358|355|376|971|54|374|1684|1268|61|43|994|257|32|229|226|880|359|973|1242|387|590|375|501|1441|591|55|1246|673|975|267|236|1|61|41|56|86|225|237|243|242|682|57|269|238|506|53|5999|61|1345|357|420|49|253|1767|45|1809|1829|1849|213|593|20|291|212|34|372|251|358|679|500|33|298|691|241|44|995|44|233|350|224|590|220|245|240|30|1473|299|502|594|1671|592|852|504|385|509|36|62|44|91|246|353|98|964|354|972|39|1876|44|962|81|76|77|254|996|855|686|1869|82|383|965|856|961|231|218|1758|423|94|266|370|352|371|853|590|212|377|373|261|960|52|692|389|223|356|95|382|976|1670|258|222|1664|596|230|265|60|262|264|687|227|672|234|505|683|31|47|977|674|64|968|92|507|64|51|63|680|675|48|1787|1939|850|351|595|970|689|974|262|40|7|250|966|249|221|65|500|4779|677|232|503|378|252|508|381|211|239|597|421|386|46|268|1721|248|963|1649|235|228|66|992|690|993|670|676|1868|216|90|688|886|255|256|380|598|1|998|3906698|379|1784|58|1284|1340|84|678|681|685|967|27|260|263)(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|2[98654321]\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)\d{4,20}$/';


    private $prefix_regex = '/^(\+88|88|0088)?(01[135-9])/';


    /**
     * Validate the number
     * @param $mobile_no
     * @return array
     *      is_valid: true/false
     *      validation type: local, international, null
     *      operator_code: 017/018/016
     */
    public function validate($mobile_no)
    {
        $mobile_no = preg_replace("/[^0-9+]/", '', $mobile_no); //removing all non numeric characters

        $returnable = [
            'is_valid'          => false,
            'type'              => '',
        ];


        if(empty($mobile_no)) {
            $returnable = [
                'is_valid'      => false,
                'type'          => 'empty',
            ];
            return $returnable;
        }

        $prefix = [
            'operator_code'     => '',
            'country_code'      => '',
        ];


        if (preg_match($this->local_regex, $mobile_no, $match)) { // checking local number

            $mobile_no = strlen($mobile_no) == 10 ? str_pad($mobile_no,11,0,STR_PAD_LEFT) : $mobile_no;

            if (preg_match($this->prefix_regex, $mobile_no, $getPrefix)) {
                $prefix = [
                    'operator_code' => $getPrefix[2],
                    'country_code'  => $getPrefix[1],
                ];
            }

            $returnable = [
                    'is_valid'      => true,
                    'type'          => 'local',
                    'mobile_no'     => $this->__mobileNo($mobile_no),
                ] + $prefix;


        } elseif (preg_match($this->international_regex, $mobile_no)) {  // checking international number
            $returnable = [
                    'is_valid'      => true,
                    'type'          => 'international',
                    'mobile_no'     => $mobile_no,
                ]+$prefix;
        }elseif (preg_match($this->international_regex_ext, $mobile_no)) {  // checking international number
            $returnable = [
                    'is_valid'      => true,
                    'type'          => 'international',
                    'mobile_no'     => $mobile_no,
                ]+$prefix;
        }

        return $returnable;
    }

    /**
     * It will return last 11 digit of mobile number with associated check its valid number or not
     *
     * @param $mobile_no
     * @return string last 11 digits of input string
     */
    private function __mobileNo($mobile_no)
    {
        return substr($mobile_no,-11);
    }
}

/**
 * Uses:
 *
 * $mobile_no = '+8801822 141954';
 * return (new \App\Http\Requests\MobileNumberValidator())->validate($mobile_no);
 */