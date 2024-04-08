<?php

namespace App\Functions;

use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\Payroll\Models\GlPl;
use App\Modules\Payroll\Models\Loan;
use App\Modules\Payroll\Models\SalaryAccount;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

/**
 * All the functions will return except MD
 */
class GlPlFunction
{

    public static function getGlOrPLInfo($acNo)
    {

        try {
            $glPlNo = GlPl::where('gl_pl_no', $acNo)->first();
            if (!empty($glPlNo)) {
                if ($glPlNo->head_type == 'P') {
                    $paymentOrDedType = GlPl::select('salary_gl_pl.gl_pl', 'p.description')
                        ->join('pay_type as p', 'salary_gl_pl.head_id', '=', 'p.ptype_id')
                        ->where('salary_gl_pl.gl_pl_no', $acNo)->pluck('description', 'gl_pl');
                } else {
                    $paymentOrDedType = GlPl::select('salary_gl_pl.gl_pl', 'd.description')
                        ->join('deduction_type as d', 'salary_gl_pl.head_id', '=', 'd.dtype_id')
                        ->where('salary_gl_pl.gl_pl_no', $acNo)->pluck('description', 'gl_pl');
                }
            } else {
                $salAcc = SalaryAccount::where('account_no', $acNo)->where('status', 1)->first();
                if (!empty($salAcc)) {
                    $paymentOrDedType = EmployeeFunction::singleEmployeeInfo($salAcc->employee_id);
                } else {
                    $loanAcc = Loan::where('acc_no', $acNo)->where('status', 1)->first();
                    if (!empty($loanAcc)) {
                        $paymentOrDedType = EmployeeFunction::singleEmployeeInfo($loanAcc->employee_id);

                    } else {
                        $paymentOrDedType = 'Employee Salary Account';
                    }
                }

            }


            return empty($paymentOrDedType) ? 'Parking-GL' : $paymentOrDedType;
        } catch (Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    public static function headOfficeGlPlAmount()
    {
        return DB::select("select A.HEAD_ID,
       B.DESCRIPTION,
       CONCAT(A.GL_PL, A.GL_PL_NO)                                                                Debit_Account,
       CONCAT((select CONCAT(GL_PL, GL_PL_NO) from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1),
              '0001')                                                                             Credit_Account,
       FXN_HOFFICE_AMOUNT(A.HEAD_ID, 1)                                                           AMOUNT,
       DECODE(A.HEAD_ID, 1, 1, 2, 2, 10, 3, 12, 4, 4, 5, 9, 6, 3, 7, 8, 8, 11, 10, 14, 11, 13, 9) Sorting,
       CONCAT('SALARY', to_char(sysdate, 'MONYYYY'))                                              Narration
from SALARY_GL_PL A,
     PAY_TYPE B,
     EMP_SAL_PAY_DED_TEMP C
where A.HEAD_ID = B.PTYPE_ID
  AND B.PTYPE_ID = C.TYPE_ID
  AND (A.HEAD_TYPE = 'P' OR A.HEAD_TYPE is null)
  AND C.STATUS = 1
  AND FXN_CBS_BR_CODE(C.BRANCH_ID) = '0001'
  AND C.PAY_OR_DED_TYPE = 1
GROUP BY A.GL_PL_NO, A.GL_PL, B.DESCRIPTION, A.HEAD_ID
ORDER BY To_number(Sorting)");
    }

    public static function specificBranchGlPlAmount($cbsCode)
    {
        return DB::select("select A.HEAD_ID,
       B.DESCRIPTION,
       CONCAT(A.GL_PL, A.GL_PL_NO)                                                                Debit_Account,
       CONCAT((select CONCAT(GL_PL, GL_PL_NO) from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1),
              '$cbsCode')                                                                             Credit_Account,
       SUM(C.PAY_AMOUNT)                                                                          AMOUNT,
       DECODE(A.HEAD_ID, 1, 1, 2, 2, 10, 3, 12, 4, 4, 5, 9, 6, 3, 7, 8, 8, 11, 10, 14, 11, 13, 9) Sorting,
       CONCAT('SALARY', to_char(sysdate, 'MONYYYY'))                                              Narration
from SALARY_GL_PL A,
     PAY_TYPE B,
     EMP_SAL_PAY_DED_TEMP C
where A.HEAD_ID = B.PTYPE_ID
  AND B.PTYPE_ID = C.TYPE_ID
  AND A.HEAD_TYPE = 'P'
  AND C.STATUS = 1
  AND FXN_CBS_BR_CODE(C.BRANCH_ID) = '$cbsCode'
  AND C.PAY_OR_DED_TYPE = 1
GROUP BY A.GL_PL_NO, A.GL_PL, B.DESCRIPTION, A.HEAD_ID
ORDER BY To_number(Sorting)");

    }

    public static function onlyBranchWiseGlPlAmount()
    {
        return DB::select("select A.HEAD_ID,
    B.DESCRIPTION,
       CONCAT(A.GL_PL, A.GL_PL_NO)                                                                Debit_Account,
       CONCAT((select CONCAT(GL_PL, GL_PL_NO) from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1),
              FXN_CBS_BR_CODE(C.BRANCH_ID))                                                       Credit_Account,
       SUM(C.PAY_AMOUNT)                                                                          AMOUNT,
       DECODE(A.HEAD_ID, 1, 1, 2, 2, 10, 3, 12, 4, 4, 5, 9, 6, 3, 7, 8, 8, 11, 10, 14, 11, 13, 9) Sorting,
       CONCAT('SALARY', to_char(sysdate, 'MONYYYY'))                                              Narration
from SALARY_GL_PL A,
     PAY_TYPE B,
     EMP_SAL_PAY_DED_TEMP C
where A.HEAD_ID = B.PTYPE_ID
  AND B.PTYPE_ID = C.TYPE_ID
  AND A.HEAD_TYPE = 'P'
  AND C.STATUS = 1
  AND FXN_CBS_BR_CODE(C.BRANCH_ID) <> '0001'
  AND C.PAY_OR_DED_TYPE = 1
GROUP BY A.GL_PL_NO, A.GL_PL, B.DESCRIPTION, A.HEAD_ID, C.BRANCH_ID
ORDER BY FXN_CBS_BR_CODE(C.BRANCH_ID),To_number(Sorting)");
    }

    public static function allGlPlAmount()
    {
        return DB::select("
        select A.HEAD_ID,
       B.DESCRIPTION,
       CONCAT(A.GL_PL, A.GL_PL_NO)                                                                Debit_Account,
       (select CONCAT(GL_PL, GL_PL_NO) from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1)  Credit_Account,
       SUM(C.PAY_AMOUNT)                                                                          AMOUNT,
       DECODE(A.HEAD_ID, 1, 1, 2, 2, 10, 3, 12, 4, 4, 5, 9, 6, 3, 7, 8, 8, 11, 10, 14, 11, 13, 9) Sorting,
       CONCAT('SALARY', to_char(sysdate, 'MONYYYY'))                                              Narration
from SALARY_GL_PL A,
     PAY_TYPE B,
     EMP_SAL_PAY_DED_TEMP C
where A.HEAD_ID = B.PTYPE_ID
  AND B.PTYPE_ID = C.TYPE_ID
  AND A.HEAD_TYPE = 'P'
  AND C.STATUS = 1
  --AND C.EMPLOYEE_ID <> '20220310001'
  AND C.PAY_OR_DED_TYPE = 1
GROUP BY A.GL_PL_NO, A.GL_PL, B.DESCRIPTION, A.HEAD_ID
ORDER BY To_number(Sorting)
        ");
    }

    /*------------------------------------Salary Notes Section STARTED---------------------------------*/
    /**
     * Pay Type Values add
     *
     */

    public static function payTypeAmountsOfSalNotes(): array
    {
        return
            DB::select("
            select 
       1                                                                                        PAY_OR_DED_TYPE,
       TYPE_ID                                                                                  TYPE_ID,
       SUM(TO_NUMBER(PAY_AMOUNT))                                                               TOTAL_AMOUNT,
       TO_CHAR(PAYMENT_DATE, 'Mon-YYYY')                                                        MONTH_YEAR,
       TO_DATE(PAYMENT_DATE)                                                      PAID_DATE,
       1                                                                                        STATUS,
       DECODE(TYPE_ID, 1, 1, 2, 2, 10, 3, 12, 4, 4, 5, 9, 6, 3, 7, 8, 8, 11, 10, 14, 11, 13, 9,81,12) Sorting
from EMP_SAL_PAY_DED_TEMP
where PAY_OR_DED_TYPE = 1
AND Status <>5
AND PAY_AMOUNT <> 0
group by TYPE_ID, PAYMENT_DATE
ORDER BY FXN_EMP_PAY_OR_DED_TYPE(TYPE_ID, 1)");
    }

    /**
     *
     * Deduction Type Values add
     *
     */

    public static function deductionTypeAmountsOfSalNotes(): array
    {
        return
            DB::select("
            select 
       2                                                                        PAY_OR_DED_TYPE,
       TYPE_ID                                                                  TYPE_ID,
       SUM(TO_NUMBER(PAY_AMOUNT))                                               TOTAL_AMOUNT,
       TO_CHAR(PAYMENT_DATE, 'Mon-YYYY')                                                        MONTH_YEAR,
       TO_DATE(PAYMENT_DATE)                                                      PAID_DATE,
       1                                                                        STATUS,
       DECODE(TYPE_ID, 1, 1, 8, 2, 2, 3, 3, 4, 7, 5, 4, 6, 16, 8, 13, 9, 6, 10,20,11,21,12,39,13,59,14,79,15) SORTING
from EMP_SAL_PAY_DED_TEMP A
where PAY_OR_DED_TYPE = 2
AND Status <>5
AND PAY_AMOUNT <> 0
group by TYPE_ID,PAYMENT_DATE
ORDER BY FXN_EMP_PAY_OR_DED_TYPE(TYPE_ID, 2)");
    }


    public static function provisionAmountsOfSalNotes(): array
    {
        return
            DB::select("
            select 2                                 PAY_OR_DED_TYPE,
       18                                TYPE_ID,
       SUM(TO_NUMBER(PAY_AMOUNT))        TOTAL_AMOUNT,
       TO_CHAR(PAYMENT_DATE, 'Mon-YYYY') MONTH_YEAR,
       TO_DATE(PAYMENT_DATE)             PAID_DATE,
       1                                 STATUS,
       7                                 Sorting
from EMP_SAL_PAY_DED_TEMP
where PAY_OR_DED_TYPE = 1
  AND STATUS = 5
group by PAYMENT_DATE
ORDER BY FXN_EMP_PAY_OR_DED_TYPE(TYPE_ID, 1)");
    }

    /*------------------------------------Salary Notes Section END--------------------------------------*/

    /*------------------------------------HO Salary Section STARTED---------------------------------*/

    /**
     * Head Office Section
     * @return array
     */
    public static function headOfficePlBalanceAdd()
    {
        return DB::select("
       select A.GL_PL_NO                                                                                 ACCOUNTNO,
       B.DESCRIPTION,
       SUM(C.PAY_AMOUNT)                                                                          AMOUNT,
       'DR'                                                                                       DR_CR,
       '0001'                                                                                     TRAN_BR_CODE,
       '0001'                                                                                     AC_BR_CODE,
       '0001' BRANCH_CODE,
       C.PAYMENT_DATE                                                                             PAYMENT_DATE,
       DECODE(A.HEAD_ID, 1, 1, 2, 2, 10, 3, 12, 4, 4, 5, 9, 6, 3, 7, 8, 8, 11, 10, 14, 11, 13, 9) Sorting
from SALARY_GL_PL A,
     PAY_TYPE B,
     EMP_SAL_PAY_DED_TEMP C,
     EMP_PAID_DAY_COUNT D
where A.HEAD_ID = B.PTYPE_ID
  AND B.PTYPE_ID = C.TYPE_ID
  AND C.EMPLOYEE_ID = D.EMPLOYEE_ID
  AND A.HEAD_TYPE = 'P'
  --AND D.STATUS <> 5         -- On Provision
  AND A.ID <> 32            -- 32= Car Maintenance Id in Salary GL PL Excluding
  AND C.PAY_OR_DED_TYPE = 1 -- Pay Type
  --AND C.EMPLOYEE_ID <> '20220310001' --MD
  AND C.EMPLOYEE_ID = '20230201001' --DRIVER
  AND FXN_CBS_BR_CODE(C.BRANCH_ID) = '0001'
  AND C.PAY_OR_DED_TYPE = 1
GROUP BY A.GL_PL_NO, A.HEAD_ID, C.PAYMENT_DATE, B.DESCRIPTION
ORDER BY Sorting");
    }

    public static function headOfficeGlBalanceAdd()
    {
        return DB::select("select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) ACCOUNTNO,
       SUM(C.PAY_AMOUNT)                                                          AMOUNT,
       'CR'                                                                       DR_CR,
       '0001'                                               TRAN_BR_CODE,
       '0001'                                                AC_BR_CODE,
       '0001' BRANCH_CODE,
       C.PAYMENT_DATE                                                             PAYMENT_DATE
from SALARY_GL_PL A,
     EMP_SAL_PAY_DED_TEMP C,EMP_PAID_DAY_COUNT D
where A.HEAD_ID = C.TYPE_ID
  AND C.EMPLOYEE_ID = D.EMPLOYEE_ID
  AND A.HEAD_TYPE = 'P'
  --AND D.STATUS <> 5         -- On Provision
  AND A.ID <> 32            -- 32= Car Maintenance Id in Salary GL PL Excluding
  AND C.PAY_OR_DED_TYPE = 1 -- Pay Type
  --AND C.EMPLOYEE_ID <> '20220310001' --MD
   AND C.EMPLOYEE_ID = '20230201001' --DRIVER
  AND FXN_CBS_BR_CODE(C.BRANCH_ID) = '0001'
GROUP BY  C.PAYMENT_DATE");
    }

    /**
     * PARKING GL AND Car PL TO LFA,HOUSE MAINTENANCE,UTILITY,Car Maintenance (ONLY CASH TYPE) SD Card GL Balance Add
     * @return array
     */
    public static function headOfficeGlPlToSdCardGlAdd()
    {
        return DB::select("
        select DECODE(C.TYPE_ID,11,'8000605',(select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) )                                                                                DEBIT,
       (select GL_PL_NO from SALARY_GL_PL where HEAD_ID = 17)                                     ACCOUNTNO,--17 = SD prepaid Card Head
       B.DESCRIPTION,

       SUM(C.PAY_AMOUNT)                                                                          AMOUNT,
       'CR'                                                                                       DR_CR,
       '0001'                                                                                     TRAN_BR_CODE,
       '0001'                                                                                     AC_BR_CODE,
       '0001' BRANCH_CODE,
       C.PAYMENT_DATE                                                                             PAYMENT_DATE,
       DECODE(A.HEAD_ID, 1, 1, 2, 2, 10, 3, 12, 4, 4, 5, 9, 6, 3, 7, 8, 8, 11, 10, 14, 11, 13, 9) Sorting
from SALARY_GL_PL A,
     PAY_TYPE B,
     EMP_SAL_PAY_DED_TEMP C,
     EMP_PAID_DAY_COUNT D
where A.HEAD_ID = B.PTYPE_ID
  AND B.PTYPE_ID = C.TYPE_ID
  AND C.EMPLOYEE_ID = D.EMPLOYEE_ID
  AND EMP_SENIORITY_ORDER(C.EMPLOYEE_ID) < 15.50
  AND A.ID in (8, 32, 7, 6)          -- 32= Car ,8=LFA,7=Utility,6=House Maintenance
  AND C.PAY_OR_DED_TYPE = 1          -- Pay Type
  AND FXN_CBS_BR_CODE(C.BRANCH_ID) = '0001'
 AND C.EMPLOYEE_ID <> '20220310001' --MD
  AND C.PAY_OR_DED_TYPE = 1
GROUP BY A.GL_PL_NO, A.HEAD_ID, C.PAYMENT_DATE, B.DESCRIPTION, A.ID, C.TYPE_ID
ORDER BY Sorting");
    }


/////////////////////////////

    /**
     * Not Using Now
     * Car Maintenance,LFA,HOUSE MAINTENANCE,UTILITY PL/GL TO CARD GL-1000761
     * @return array
     */
    public static function headOfficeCaLfaHmUtToSdCGlAdd()
    {
        return DB::select("
        select (select GL_PL_NO from SALARY_GL_PL where HEAD_ID = 17)                                          CREDIT_GL, --17 = SD prepaid Card Head
       A.GL_PL_NO                                                                                 ACCOUNTNO,
       B.DESCRIPTION,
       SUM(C.PAY_AMOUNT)                                                                          AMOUNT,
       'DR'                                                                                       DR_CR,
       '0001'                                                               TRAN_BR_CODE,
       '0001'                                                               AC_BR_CODE,
       C.PAYMENT_DATE                                                                             PAYMENT_DATE,
       DECODE(A.HEAD_ID, 1, 1, 2, 2, 10, 3, 12, 4, 4, 5, 9, 6, 3, 7, 8, 8, 11, 10, 14, 11, 13, 9) Sorting
from SALARY_GL_PL A,
     PAY_TYPE B,
     EMP_SAL_PAY_DED_TEMP C,
     EMP_PAID_DAY_COUNT D
where A.HEAD_ID = B.PTYPE_ID
  AND B.PTYPE_ID = C.TYPE_ID
  AND C.EMPLOYEE_ID = D.EMPLOYEE_ID
  AND EMP_SENIORITY_ORDER(C.EMPLOYEE_ID) < 15.50
  AND A.ID in(8,32,7,6)              -- 32= Car ,8=LFA,7=Utility,6=House Maintenance
  AND C.PAY_OR_DED_TYPE = 1 -- Pay Type
  AND FXN_CBS_BR_CODE(C.BRANCH_ID) <> '0001'
  AND C.EMPLOYEE_ID <> '20220310001' --MD
  AND C.PAY_TYPE=2
  AND C.PAY_OR_DED_TYPE = 1
GROUP BY A.GL_PL_NO, A.HEAD_ID, C.PAYMENT_DATE, B.DESCRIPTION, A.ID
ORDER BY  Sorting");
    }
/////////////////////////

    /**
     * ALL Parking GL TO Deduction GL
     * @return array
     */
    public static function headOfficeGlToDedGlAdd()
    {
        return DB::select("
        select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) DEBIT,
       B.DESCRIPTION,
       A.GL_PL_NO                                                                 ACCOUNTNO,
       SUM(C.PAY_AMOUNT)                                                          AMOUNT,
       'CR'                                                                       DR_CR,
      '0001'                                               TRAN_BR_CODE,
       DECODE(A.GL_PL_NO, '0002130000263', '0002', '0001')  AC_BR_CODE,
       '0001' BRANCH_CODE,
       C.PAYMENT_DATE                                                             PAYMENT_DATE
from SALARY_GL_PL A,
     DEDUCTION_TYPE B,
     EMP_SAL_PAY_DED_TEMP C
where A.HEAD_ID = B.DTYPE_ID
  AND B.DTYPE_ID = C.TYPE_ID
  AND A.HEAD_TYPE = 'D'
 -- AND C.EMPLOYEE_ID <> '20220310001' --MD
   AND C.EMPLOYEE_ID = '20230201001' --DRIVER
  AND C.PAY_OR_DED_TYPE = 2
 AND C.PAY_AMOUNT <>0
  AND FXN_CBS_BR_CODE(C.BRANCH_ID) = '0001'
GROUP BY  C.PAYMENT_DATE, A.GL_PL_NO, B.DESCRIPTION");
    }

    /**
     * Head Office GL To PF Member Gl Add
     * @return array
     */
    public static function headOfficeGlToPfGlAdd(): array
    {
        return DB::select("
        select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) DEBIT,
       B.DESCRIPTION,
       (select GL_PL_NO from SALARY_GL_PL where ID=11 and ROWNUM = 1)                                                                 ACCOUNTNO,
       SUM(C.PAY_AMOUNT)                                                          AMOUNT,
       'CR'                                                                       DR_CR,
       '0001'                                                                     TRAN_BR_CODE,
       '0001'                                                                     AC_BR_CODE,
       '0001' BRANCH_CODE,
       C.PAYMENT_DATE                                                             PAYMENT_DATE
from SALARY_GL_PL A,
     PAY_TYPE B,
     EMP_SAL_PAY_DED_TEMP C
where A.HEAD_ID = B.PTYPE_ID
  AND B.PTYPE_ID = C.TYPE_ID
  AND C.TYPE_ID=8
  AND C.PAY_OR_DED_TYPE = 1
  --AND C.EMPLOYEE_ID <> '20220310001' --MD
   AND C.EMPLOYEE_ID = '20230201001' --DRIVER
  AND FXN_CBS_BR_CODE(C.BRANCH_ID) = '0001'
GROUP BY C.PAYMENT_DATE, A.GL_PL_NO, B.DESCRIPTION");
    }
    /*------------------------------------HO Salary Section END--------------------------------------*/

    /*------------------------------------Branch Salary Section Started--------------------------------------*/

    /**
     * Branch Section
     * @return array
     */
    public static function branchPlBalanceAdd(): array
    {
        return DB::select("select A.GL_PL_NO                                                                                 ACCOUNTNO,
       B.DESCRIPTION,
       SUM(C.PAY_AMOUNT)                                                                          AMOUNT,
       'DR'                                                                                       DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                               TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                               AC_BR_CODE,
       C.PAYMENT_DATE                                                                             PAYMENT_DATE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                               BRANCH_CODE,
       DECODE(A.HEAD_ID, 1, 1, 2, 2, 10, 3, 12, 4, 4, 5, 9, 6, 3, 7, 8, 8, 11, 10, 14, 11, 13, 9) Sorting
from SALARY_GL_PL A,
     PAY_TYPE B,
     EMP_SAL_PAY_DED_TEMP C,
     EMP_PAID_DAY_COUNT D
where A.HEAD_ID = B.PTYPE_ID
  AND B.PTYPE_ID = C.TYPE_ID
  AND C.EMPLOYEE_ID = D.EMPLOYEE_ID
  AND A.HEAD_TYPE = 'P'
  --AND D.STATUS <> 5         -- On Provision
  AND A.ID <> 32            -- 32= Car Maintenance Id in Salary GL PL Excluding
  AND C.PAY_OR_DED_TYPE = 1 -- Pay Type
  AND FXN_CBS_BR_CODE(C.BRANCH_ID) <> '0001'
  AND C.PAY_OR_DED_TYPE = 1
GROUP BY A.GL_PL_NO, A.HEAD_ID, C.BRANCH_ID, C.PAYMENT_DATE, B.DESCRIPTION
ORDER BY FXN_CBS_BR_CODE(C.BRANCH_ID), Sorting");
    }

    public static function branchGlBalanceAdd(): array
    {
        return DB::select("
        select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) ACCOUNTNO,
       SUM(C.PAY_AMOUNT)                                                          AMOUNT,
       'CR'                                                                       DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               AC_BR_CODE,
       C.PAYMENT_DATE                                                             PAYMENT_DATE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                               BRANCH_CODE
from SALARY_GL_PL A,
     EMP_SAL_PAY_DED_TEMP C,EMP_PAID_DAY_COUNT D
where A.HEAD_ID = C.TYPE_ID
  AND C.EMPLOYEE_ID = D.EMPLOYEE_ID
  AND A.HEAD_TYPE = 'P'
  --AND D.STATUS <> 5         -- On Provision
  AND A.ID <> 32            -- 32= Car Maintenance Id in Salary GL PL Excluding
  AND C.PAY_OR_DED_TYPE = 1 -- Pay Type
  AND FXN_CBS_BR_CODE(C.BRANCH_ID) <> '0001'
GROUP BY C.BRANCH_ID, C.PAYMENT_DATE
ORDER BY FXN_CBS_BR_CODE(C.BRANCH_ID)");
    }

    /**
     * PARKING GL TO LFA,HOUSE MAINTENANCE,UTILITY (ONLY CASH TYPE) GL
     * @return array
     */
    public static function branchGlPlToSdCardGlAdd(): array
    {
        return DB::select("
        select DECODE(C.TYPE_ID,11,'8000605',(select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) )                                                                                DEBIT,
       (select GL_PL_NO from SALARY_GL_PL where HEAD_ID = 17)                                     ACCOUNTNO,--17 = SD prepaid Card Head
       B.DESCRIPTION,
       SUM(C.PAY_AMOUNT)                                                                          AMOUNT,
       'CR'                                                                                       DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                               TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                               AC_BR_CODE,
       C.PAYMENT_DATE                                                                             PAYMENT_DATE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                               BRANCH_CODE,
       DECODE(A.HEAD_ID, 1, 1, 2, 2, 10, 3, 12, 4, 4, 5, 9, 6, 3, 7, 8, 8, 11, 10, 14, 11, 13, 9) Sorting
from SALARY_GL_PL A,
     PAY_TYPE B,
     EMP_SAL_PAY_DED_TEMP C,
     EMP_PAID_DAY_COUNT D
where A.HEAD_ID = B.PTYPE_ID
  AND B.PTYPE_ID = C.TYPE_ID
  AND C.EMPLOYEE_ID = D.EMPLOYEE_ID
  AND A.ID in(8,7,6,32)              -- 8=LFA,7=Utility,6=House Maintenance,32=Car Maintenance
  AND C.PAY_OR_DED_TYPE = 1 -- Pay Type
  AND FXN_CBS_BR_CODE(C.BRANCH_ID) <> '0001'
  AND C.PAY_TYPE=2
GROUP BY A.GL_PL_NO, A.HEAD_ID, C.BRANCH_ID, C.PAYMENT_DATE, B.DESCRIPTION, A.ID, C.TYPE_ID
ORDER BY FXN_CBS_BR_CODE(C.BRANCH_ID), Sorting");
    }
////////////

    /**
     * Car Maintenance,LFA,HOUSE MAINTENANCE,UTILITY PL/GL TO CARD GL-1000761
     * @return array
     */
    public static function branchCaLfaHmUtToSdCGlAdd()
    {
        return DB::select("
        select (select GL_PL_NO from SALARY_GL_PL where HEAD_ID = 17)                                          CREDIT_GL, --17 = SD prepaid Card Head
       A.GL_PL_NO                                                                                 ACCOUNTNO,
       B.DESCRIPTION,
       SUM(C.PAY_AMOUNT)                                                                          AMOUNT,
       'DR'                                                                                       DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                               TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                               AC_BR_CODE,
       C.PAYMENT_DATE                                                                             PAYMENT_DATE,
       DECODE(A.HEAD_ID, 1, 1, 2, 2, 10, 3, 12, 4, 4, 5, 9, 6, 3, 7, 8, 8, 11, 10, 14, 11, 13, 9) Sorting
from SALARY_GL_PL A,
     PAY_TYPE B,
     EMP_SAL_PAY_DED_TEMP C,
     EMP_PAID_DAY_COUNT D
where A.HEAD_ID = B.PTYPE_ID
  AND B.PTYPE_ID = C.TYPE_ID
  AND C.EMPLOYEE_ID = D.EMPLOYEE_ID
  AND A.ID in(8,32,7,6)              -- 32= Car ,8=LFA,7=Utility,6=House Maintenance
  AND C.PAY_OR_DED_TYPE = 1 -- Pay Type
  AND FXN_CBS_BR_CODE(C.BRANCH_ID) <> '0001'
  AND C.PAY_TYPE=2
  AND C.PAY_OR_DED_TYPE = 1
GROUP BY A.GL_PL_NO, A.HEAD_ID, C.BRANCH_ID, C.PAYMENT_DATE, B.DESCRIPTION, A.ID
ORDER BY FXN_CBS_BR_CODE(C.BRANCH_ID), Sorting");
    }
/////////////////

    /**
     * Branch GL To PF Member Gl Add
     * @return array
     */
    public static function branchGlToPfGlAdd(): array
    {
        return DB::select("
        select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) DEBIT,
       B.DESCRIPTION,
       (select GL_PL_NO from SALARY_GL_PL where ID=11 and ROWNUM = 1)                                                                 ACCOUNTNO,
       SUM(TO_NUMBER(C.PAY_AMOUNT))                                                          AMOUNT,
       'CR'                                                                       DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                                     TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                                     AC_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                               BRANCH_CODE,
       C.PAYMENT_DATE                                                             PAYMENT_DATE
from SALARY_GL_PL A,
     PAY_TYPE B,
     EMP_SAL_PAY_DED_TEMP C
where A.HEAD_ID = B.PTYPE_ID
  AND B.PTYPE_ID = C.TYPE_ID
  AND C.TYPE_ID=8
  AND C.PAY_OR_DED_TYPE = 1
  AND FXN_CBS_BR_CODE(C.BRANCH_ID) <> '0001'
GROUP BY C.PAYMENT_DATE, C.BRANCH_ID,A.GL_PL_NO, B.DESCRIPTION");
    }


    /**
     * ALL Parking GL TO Deduction GL
     * @return array
     */
    public static function branchGlToDedGlAdd(): array
    {
        return DB::select("
        select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) DEBIT,
       B.DESCRIPTION,
       A.GL_PL_NO                                                                 ACCOUNTNO,
       SUM(C.PAY_AMOUNT)                                                          AMOUNT,
       'CR'                                                                       DR_CR,
       DECODE(A.GL_PL_NO, '0002130000263', '0002', '0001')                                               TRAN_BR_CODE,
       DECODE(A.GL_PL_NO, '0002130000263', '0002', FXN_CBS_BR_CODE(C.BRANCH_ID))  AC_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                               BRANCH_CODE,
       C.PAYMENT_DATE                                                             PAYMENT_DATE
from SALARY_GL_PL A,
     DEDUCTION_TYPE B,
     EMP_SAL_PAY_DED_TEMP C
where A.HEAD_ID = B.DTYPE_ID
  AND B.DTYPE_ID = C.TYPE_ID
  AND A.HEAD_TYPE = 'D'
  AND (C.PAY_AMOUNT > 0 AND C.PAY_AMOUNT is not null)
  AND C.PAY_OR_DED_TYPE = 2
  AND FXN_CBS_BR_CODE(C.BRANCH_ID) <> '0001'
GROUP BY C.BRANCH_ID, C.PAYMENT_DATE, A.GL_PL_NO, B.DESCRIPTION
ORDER BY FXN_CBS_BR_CODE(C.BRANCH_ID)");
    }

    /*------------------------------------Branch Salary Section Ended--------------------------------------*/

    /*------------------------------------Common Part Started--------------------------------------*/

    /**
     * CommonPart
     * Provision Gl add
     * @return array
     */

    public static function parkingGLToProvisionGl(): array
    {
        return DB::select("
        select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) DEBIT,
       C.EMPLOYEE_ID,
       (select GL_PL_NO from SALARY_GL_PL where ID = 41)                          ACCOUNTNO,
       SUM(PAY_AMOUNT)                                                            AMOUNT,
       'CR'                                                                       DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID) AC_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                               BRANCH_CODE,
       --SUBSTR(FXN_EMP_SAL_ACC(C.EMPLOYEE_ID), 1, 4)                               AC_BR_CODE,
       C.PAYMENT_DATE                                                             PAYMENT_DATE
from SALARY_GL_PL A,
     EMP_SAL_PAY_DED_TEMP C,
     EMP_PAID_DAY_COUNT B
where A.HEAD_ID = C.TYPE_ID
  AND B.EMPLOYEE_ID = C.EMPLOYEE_ID
  AND B.STATUS = 5          -- On Provision
  AND A.HEAD_TYPE = 'P'
  AND C.PAY_OR_DED_TYPE = 1 -- Pay Type
GROUP BY C.BRANCH_ID, C.PAYMENT_DATE, C.EMPLOYEE_ID
ORDER BY FXN_CBS_BR_CODE(C.BRANCH_ID)");
    }

    /**
     * CommonPart
     * Parking Gl Employee Sal Acc
     * @param $branchCode
     * @param $con
     * @return array
     */
    public static function parkingGLToEmpAcc($branchCode, $con): array
    {
        if (!empty($con)) {
            $code = $branchCode;
        } else {
            $code = '(select CBS_BRANCH_CODE from BRANCH where CBS_BRANCH_CODE is not null and CBS_BRANCH_CODE <>' . $branchCode . ' GROUP BY CBS_BRANCH_CODE)';
        }

        return DB::select("
        select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) DEBIT,
       C.EMPLOYEE_ID,
       FXN_EMP_SAL_ACC(C.EMPLOYEE_ID)                                             ACCOUNTNO,
       NVL(FXN_EMP_NET_SAL(C.EMPLOYEE_ID),0)                                             AMOUNT,
       'CR'                                                                       DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               TRAN_BR_CODE,
       SUBSTR(FXN_EMP_SAL_ACC(C.EMPLOYEE_ID), 1, 4)                               AC_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                               BRANCH_CODE,
       C.PAYMENT_DATE                                                             PAYMENT_DATE
from SALARY_GL_PL A,
     EMP_SAL_PAY_DED_TEMP C,
     EMP_PAID_DAY_COUNT B
where A.HEAD_ID = C.TYPE_ID
  AND B.EMPLOYEE_ID = C.EMPLOYEE_ID
  AND B.STATUS <> 5         -- On Provision
  AND A.HEAD_TYPE = 'P'
  AND A.ID <> 32            -- 32= Car Maintenance Id in Salary GL PL Excluding
  AND C.PAY_OR_DED_TYPE = 1 -- Pay Type
  AND FXN_CBS_BR_CODE(C.BRANCH_ID) in $code
  --AND C.EMPLOYEE_ID <> '20220310001' --this is optional 
 AND C.EMPLOYEE_ID = '20230201001' --DRIVER
GROUP BY C.BRANCH_ID, C.PAYMENT_DATE, C.EMPLOYEE_ID
ORDER BY FXN_CBS_BR_CODE(C.BRANCH_ID)");
    }

    /**
     * This function is used for branch and Ho
     * @param $branchCode
     * @param $con
     * @return array
     */

    public static function sdCardGlToEmpLoanAcc($branchCode, $con): array
    {
        if (!empty($con)) {
            $code = $branchCode;
        } else {
            $code = '(select CBS_BRANCH_CODE from BRANCH where CBS_BRANCH_CODE is not null and CBS_BRANCH_CODE <>' . $branchCode . 'GROUP BY CBS_BRANCH_CODE)';
        }

        return DB::select("
        select (select GL_PL_NO from SALARY_GL_PL where ID = 33 and ROWNUM = 1) DEBIT,
       EMP_NAME(C.EMPLOYEE_ID) EMP_NAME,
       C.EMPLOYEE_ID,
       B.DESCRIPTION,
       FXN_GET_LOAN_ACC(C.EMPLOYEE_ID, 1,C.TYPE_ID)                               ACCOUNTNO,
       SUM(C.PAY_AMOUNT)                                                AMOUNT,
       'CR'                                                             DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                      BRANCH_CODE,
       SUBSTR(FXN_GET_LOAN_ACC(C.EMPLOYEE_ID, 1,C.TYPE_ID), 0, 4)                 AC_BR_CODE,
       C.PAYMENT_DATE                                                   PAYMENT_DATE
from SALARY_GL_PL A,
     DEDUCTION_TYPE B,
     EMP_SAL_PAY_DED_TEMP C,
     EMPLOYEE_LOAN D
where A.HEAD_ID = B.DTYPE_ID
  AND B.DTYPE_ID = C.TYPE_ID
  AND C.EMPLOYEE_ID = D.EMPLOYEE_ID
  AND D.EXE_CAR_LOAN = 2
  AND C.PAY_OR_DED_TYPE = 2
  AND C.TYPE_ID = 3
  AND FXN_CBS_BR_CODE(C.BRANCH_ID) in $code
  AND EMP_STATUS(C.EMPLOYEE_ID) =1
GROUP BY C.PAYMENT_DATE, A.GL_PL_NO, B.DESCRIPTION, C.EMPLOYEE_ID,C.TYPE_ID,C.BRANCH_ID
        ");
    }

    public static function salAccToLoanAcc($branchCode, $con): array
    {
        if (!empty($con)) {
            $code = $branchCode;
        } else {
            $code = '(select CBS_BRANCH_CODE from BRANCH where CBS_BRANCH_CODE is not null and CBS_BRANCH_CODE <>' . $branchCode . 'GROUP BY CBS_BRANCH_CODE)';
        }

        return DB::select("
        select FXN_EMP_SAL_ACC(C.EMPLOYEE_ID)                              DEBIT,
       EMP_NAME(C.EMPLOYEE_ID)                                     EMP_NAME,
       C.EMPLOYEE_ID,
       B.DESCRIPTION,
       FXN_GET_LOAN_ACC(C.EMPLOYEE_ID, 2, C.TYPE_ID)               ACCOUNTNO,
       SUM(C.PAY_AMOUNT)                                           AMOUNT,
       'CR'                                                        DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                      BRANCH_CODE,
       SUBSTR(FXN_GET_LOAN_ACC(C.EMPLOYEE_ID, 2, C.TYPE_ID), 0, 4) AC_BR_CODE,
       C.PAYMENT_DATE                                              PAYMENT_DATE
from DEDUCTION_TYPE B,
     EMP_SAL_PAY_DED_TEMP C,
     EMPLOYEE_LOAN D
where B.DTYPE_ID = C.TYPE_ID
  AND D.DTYPE_ID = B.DTYPE_ID
  AND C.EMPLOYEE_ID = D.EMPLOYEE_ID
  AND D.EXE_CAR_LOAN <> 2
  AND C.PAY_OR_DED_TYPE = 2
  AND B.STATUS = 'L'
  AND C.EMPLOYEE_ID  in('20150118001')   -- Masuk
  AND FXN_CBS_BR_CODE(C.BRANCH_ID) in $code
GROUP BY C.PAYMENT_DATE, B.DESCRIPTION, C.EMPLOYEE_ID, C.TYPE_ID,C.BRANCH_ID
        ");
    }


    /*------------------------------------Common Part Ended--------------------------------------*/


    /*------------------------------------New Process Writing--------------------------------------*/

    public static function regularEmpSalaryProcess($singleEmpId): array
    {

        /**************************** Md Employee Id Taking *****************************/
        /**
         * Need To Change before the next Salary
         */
        $mD = EmployeeDetails::select('EMPLOYEE_ID')->where('EMPLOYEE_ID', '20220310001')->first();

        if (empty($singleEmpId)) {
            $empId = "And C.EMPLOYEE_ID <> $mD->employee_id";
        } else {
            $empId = "And C.EMPLOYEE_ID = $singleEmpId";
        }

        /*----------------------PL DeBit------------------*/
        $salaryProcess['plBalanceDebit'] = DB::select("
        select A.GL_PL_NO                   ACCOUNTNO,
       B.DESCRIPTION,
       SUM(C.PAY_AMOUNT)            AMOUNT,
       'DR'                         DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID) TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID) AC_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID) BRANCH_CODE,
       C.PAYMENT_DATE               PAYMENT_DATE,
       B.SORTING
from SALARY_GL_PL A,
     PAY_TYPE B,
     EMP_SAL_PAY_DED_TEMP C,
     EMP_PAID_DAY_COUNT D
where A.HEAD_ID = B.PTYPE_ID
  AND B.PTYPE_ID = C.TYPE_ID
  AND C.EMPLOYEE_ID = D.EMPLOYEE_ID
  AND A.HEAD_TYPE = 'P'
  AND C.PAY_OR_DED_TYPE = 1          -- Pay Type
  $empId
  --AND C.EMPLOYEE_ID <> '20220310001' --MD
  --AND FXN_CBS_BR_CODE(C.BRANCH_ID) = '0001'
  AND C.PAY_OR_DED_TYPE = 1
GROUP BY A.GL_PL_NO, FXN_CBS_BR_CODE(C.BRANCH_ID), A.HEAD_ID, C.PAYMENT_DATE, B.DESCRIPTION, B.SORTING
ORDER BY TO_NUMBER(FXN_CBS_BR_CODE(C.BRANCH_ID)), B.SORTING
        ");

        /*-------------Parking GL Credit-------------------*/
        $salaryProcess['pGlBalanceCredit'] = DB::select("
        select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) ACCOUNTNO,
               'PARKING-GL'DESCRIPTION,
       SUM(C.PAY_AMOUNT)                                                          AMOUNT,
       'CR'                                                                       DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               AC_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               BRANCH_CODE,
       C.PAYMENT_DATE                                                             PAYMENT_DATE
from SALARY_GL_PL A,
     EMP_SAL_PAY_DED_TEMP C,
     EMP_PAID_DAY_COUNT D
where A.HEAD_ID = C.TYPE_ID
  AND C.EMPLOYEE_ID = D.EMPLOYEE_ID
  AND A.HEAD_TYPE = 'P'
  AND C.PAY_OR_DED_TYPE = 1          -- Pay Type
  --AND C.EMPLOYEE_ID <> '20220310001' --MD
    $empId
GROUP BY C.PAYMENT_DATE, FXN_CBS_BR_CODE(C.BRANCH_ID)
        ");

        /*---------Parking GL Debit And SD Card Gl Credit----------*/
        $salaryProcess['pGlToCardGl'] = DB::select("
      select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) DEBIT,
       (select GL_PL_NO from SALARY_GL_PL where HEAD_ID = 17)                     ACCOUNTNO,--17 = SD prepaid Card Head
       'PARTB+CARMAINTENENCE'                                                     DESCRIPTION,
       SUM(C.PAY_AMOUNT) -
       NVL(FXN_EXE_CAR_LOAN_AMT(FXN_CBS_BR_CODE(C.BRANCH_ID)), 0)                 AMOUNT,   ---Car Loan Deducting Of Executive EMPS
       'CR'                                                                       DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               DEBIT_BR_CODE,
       '0001'                                                                     AC_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               BRANCH_CODE,
       C.PAYMENT_DATE                                                             PAYMENT_DATE
from SALARY_GL_PL A,
     PAY_TYPE B,
     EMP_SAL_PAY_DED_TEMP C,
     EMP_PAID_DAY_COUNT D
where A.HEAD_ID = B.PTYPE_ID
  AND B.PTYPE_ID = C.TYPE_ID
  AND C.EMPLOYEE_ID = D.EMPLOYEE_ID
  AND EMP_SENIORITY_ORDER(C.EMPLOYEE_ID) < 15.50
   $empId
  AND A.ID in (8, 32, 7, 6,101)          -- 32= Car ,8=LFA,7=Utility,6=House Maintenance, 101 =Technical Allowance
  AND C.PAY_OR_DED_TYPE = 1          -- Pay Type
  AND C.PAY_TYPE = 2 -- ONlY Cash Type
  AND C.STATUS <> 5                  -- Provision Balance Excluding
GROUP BY FXN_CBS_BR_CODE(C.BRANCH_ID), C.PAYMENT_DATE
ORDER BY FXN_CBS_BR_CODE(C.BRANCH_ID)");

        /*---------Parking GL Debit And ALL Other Deduction Credit----------*/
        $salaryProcess['pGlToDeductionGl'] = DB::select("select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) DEBIT,
       UPPER(REPLACE(REPLACE(B.DESCRIPTION, '.'), ' '))                           DESCRIPTION,
       A.GL_PL_NO                                                                 ACCOUNTNO,
       SUM(C.PAY_AMOUNT)                                                          AMOUNT,
       'CR'                                                                       DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               DEBIT_BR_CODE,
       '0001'                                                                     AC_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               BRANCH_CODE,
       C.PAYMENT_DATE                                                             PAYMENT_DATE
      from SALARY_GL_PL A,
     DEDUCTION_TYPE B,
     EMP_SAL_PAY_DED_TEMP C
where A.HEAD_ID = B.DTYPE_ID
  AND B.DTYPE_ID = C.TYPE_ID
  AND A.HEAD_TYPE = 'D'
  AND A.HEAD_ID <> 13                ---Pf Loan Installment Excluding
     $empId
  AND C.PAY_OR_DED_TYPE = 2
  AND C.STATUS <> 5                  -- Provision Balance Excluding
  AND C.PAY_AMOUNT <> 0
GROUP BY C.PAYMENT_DATE, FXN_CBS_BR_CODE(C.BRANCH_ID), A.GL_PL_NO, B.DESCRIPTION");

        /*---------Parking GL Debit And PF GL Credit----------*/
        $salaryProcess['pGlToPfGl'] = DB::select("select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) DEBIT,
       UPPER(REPLACE(REPLACE(B.DESCRIPTION, '.'), ' '))                           DESCRIPTION,
       (select GL_PL_NO from SALARY_GL_PL where ID = 11 and ROWNUM = 1)           ACCOUNTNO,
       SUM(C.PAY_AMOUNT)                                                          AMOUNT,
       'CR'                                                                       DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               DEBIT_BR_CODE,
       '0001'                                                                     AC_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               BRANCH_CODE,
       C.PAYMENT_DATE                                                             PAYMENT_DATE
from SALARY_GL_PL A,
     PAY_TYPE B,
     EMP_SAL_PAY_DED_TEMP C
where A.HEAD_ID = B.PTYPE_ID
  AND B.PTYPE_ID = C.TYPE_ID
  AND C.TYPE_ID = 8
  AND C.STATUS <> 5                  -- Provision Balance Excluding
  AND C.PAY_OR_DED_TYPE = 1
  --AND C.EMPLOYEE_ID <> '20220310001' --MD
  $empId
  --AND FXN_CBS_BR_CODE(C.BRANCH_ID) = '0002'
GROUP BY FXN_CBS_BR_CODE(C.BRANCH_ID), C.PAYMENT_DATE, A.GL_PL_NO, B.DESCRIPTION");

        /*---------Parking GL Debit And Provision GL Credit----------*/
        $salaryProcess['pGlToProvisionGl'] = DB::select("select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) DEBIT,
       'PROVISION'                                                                DESCRIPTION,
       C.EMPLOYEE_ID,
       (select GL_PL_NO from SALARY_GL_PL where ID = 41)                          ACCOUNTNO,
       SUM(PAY_AMOUNT) - NVL(FXN_DONATION_PROBATION_AMT_EXCLUDE(FXN_CBS_BR_CODE(C.BRANCH_ID)),0)  AMOUNT,
       'CR'                                                                       DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               DEBIT_BR_CODE,
       '0001'                                                                     AC_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               BRANCH_CODE,

       C.PAYMENT_DATE                                                             PAYMENT_DATE
from SALARY_GL_PL A,
     EMP_SAL_PAY_DED_TEMP C,
     EMP_PAID_DAY_COUNT B
where A.HEAD_ID = C.TYPE_ID
  AND B.EMPLOYEE_ID = C.EMPLOYEE_ID
  AND B.STATUS = 5          -- On Provision
  AND A.HEAD_TYPE = 'P'
   $empId
  AND C.PAY_OR_DED_TYPE = 1 -- Pay Type
GROUP BY C.BRANCH_ID, C.PAYMENT_DATE, C.EMPLOYEE_ID
ORDER BY FXN_CBS_BR_CODE(C.BRANCH_ID)");

        /*---------Branch Parking GL Debit And Head office Parking GL Credit----------*/
        /**
         * This operation will be used only for half day basic donation and It used on March-2024 Month
         */

        $salaryProcess['branchParkingGlToHeadOfficeParkingGl'] = DB::select(
            "
            select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) DEBIT,
       'HALFDAYBASIC'                                                             DESCRIPTION,
       (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) ACCOUNTNO,
       SUM(C.PAY_AMOUNT)                                                          AMOUNT,
       'CR'                                                                       DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               DEBIT_BR_CODE,
       '0001'                                                                     AC_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               BRANCH_CODE,
       C.PAYMENT_DATE                                                             PAYMENT_DATE
from DEDUCTION_TYPE B,
     EMP_SAL_PAY_DED_TEMP C
where B.DTYPE_ID = C.TYPE_ID
    $empId
  AND C.PAY_OR_DED_TYPE = 2
  AND C.TYPE_ID = 79 -- 1/2 Day Basic Deduction
  --AND FXN_CBS_BR_CODE(C.BRANCH_ID) <> '0001'
  AND C.STATUS <> 5  -- Provision Balance Excluding
  AND C.PAY_AMOUNT <> 0
GROUP BY C.PAYMENT_DATE, FXN_CBS_BR_CODE(C.BRANCH_ID), B.DESCRIPTION
            "
        );
        /*---------Parking GL Debit And Employee Salary Acc Credit----------*/
        $salaryProcess['pGlToEmpSalAcc'] = DB::select("select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) DEBIT,
       CONCAT('SALARY', CONCAT('-', TO_CHAR(C.PAYMENT_DATE, 'MONYYYY')))          DESCRIPTION,
       C.EMPLOYEE_ID,
       FXN_EMP_SAL_ACC(C.EMPLOYEE_ID)                                             ACCOUNTNO,
       NVL(FXN_EMP_NET_SAL(C.EMPLOYEE_ID), 0)                                     AMOUNT,
       'CR'                                                                       DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               DEBIT_BR_CODE,
       SUBSTR(FXN_EMP_SAL_ACC(C.EMPLOYEE_ID), 1, 4)                               AC_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               BRANCH_CODE,
       C.PAYMENT_DATE                                                             PAYMENT_DATE
from SALARY_GL_PL A,
     EMP_SAL_PAY_DED_TEMP C,
     EMP_PAID_DAY_COUNT B
where A.HEAD_ID = C.TYPE_ID
  AND B.EMPLOYEE_ID = C.EMPLOYEE_ID
  AND B.STATUS <> 5                  -- On Provision
  AND A.HEAD_TYPE = 'P'
  AND A.ID <> 32                     -- 32= Car Maintenance Id in Salary GL PL Excluding
  AND C.PAY_OR_DED_TYPE = 1          -- Pay Type
  --AND FXN_CBS_BR_CODE(C.BRANCH_ID) in ('0001')
  --AND C.EMPLOYEE_ID <> '20220310001' --this is optional
    $empId
GROUP BY FXN_CBS_BR_CODE(C.BRANCH_ID), C.PAYMENT_DATE, C.EMPLOYEE_ID
ORDER BY FXN_CBS_BR_CODE(C.BRANCH_ID)");

        /*---------Employee Salary Acc Debit And Loan Acc Credit----------*/
        $salaryProcess['empSalAccToLoanAcc'] = DB::select("select FXN_EMP_SAL_ACC(C.EMPLOYEE_ID)                              DEBIT,
       EMP_NAME(C.EMPLOYEE_ID)                                     EMP_NAME,
       CONCAT(UPPER(REPLACE(REPLACE(B.DESCRIPTION, '.'), ' ')),
              CONCAT('-', TO_CHAR(C.PAYMENT_DATE, 'MONYYYY')))     DESCRIPTION,
       C.EMPLOYEE_ID,
       FXN_GET_LOAN_ACC(C.EMPLOYEE_ID, 2, C.TYPE_ID)               ACCOUNTNO,
       SUM(C.PAY_AMOUNT)                                           AMOUNT,
       'CR'                                                        DR_CR,
       SUBSTR(FXN_EMP_SAL_ACC(C.EMPLOYEE_ID), 0, 4)                TRAN_BR_CODE,
       SUBSTR(FXN_EMP_SAL_ACC(C.EMPLOYEE_ID), 0, 4)                DEBIT_BR_CODE,
       SUBSTR(FXN_GET_LOAN_ACC(C.EMPLOYEE_ID, 2, C.TYPE_ID), 0, 4) AC_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                BRANCH_CODE,
       C.PAYMENT_DATE                                              PAYMENT_DATE
from DEDUCTION_TYPE B,
     EMP_SAL_PAY_DED_TEMP C,
     EMPLOYEE_LOAN D
where B.DTYPE_ID = C.TYPE_ID
  AND D.DTYPE_ID = B.DTYPE_ID
  AND C.EMPLOYEE_ID = D.EMPLOYEE_ID
  AND D.EXE_CAR_LOAN <> 2
  AND D.STATUS = 1
  AND C.PAY_OR_DED_TYPE = 2
  AND B.STATUS = 'L'
  --AND C.EMPLOYEE_ID  in('20150118001')   -- Masuk
      $empId
  --AND FXN_CBS_BR_CODE(C.BRANCH_ID) in ('0001')
GROUP BY C.PAYMENT_DATE, B.DESCRIPTION, C.EMPLOYEE_ID, C.TYPE_ID, C.BRANCH_ID");

        /*---------Parking GL Debit And SEVP Executive Car Loan Acc Credit----------*/
        $salaryProcess['pGlToSevpCarLoanAcc'] = DB::select("select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) DEBIT,
       EMP_NAME(C.EMPLOYEE_ID)                                          EMP_NAME,
       CONCAT(UPPER(REPLACE(REPLACE(B.DESCRIPTION, '.'), ' ')),
              CONCAT('-', TO_CHAR(C.PAYMENT_DATE, 'MONYYYY')))          DESCRIPTION,
       C.EMPLOYEE_ID,
       FXN_GET_LOAN_ACC(C.EMPLOYEE_ID, 1, C.TYPE_ID)                    ACCOUNTNO,
       SUM(C.PAY_AMOUNT)                                                AMOUNT,
       'CR'                                                             DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                     TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                     DEBIT_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                     BRANCH_CODE,
       SUBSTR(FXN_GET_LOAN_ACC(C.EMPLOYEE_ID, 1, C.TYPE_ID), 0, 4)      AC_BR_CODE,
       C.PAYMENT_DATE                                                   PAYMENT_DATE
from SALARY_GL_PL A,
     DEDUCTION_TYPE B,
     EMP_SAL_PAY_DED_TEMP C,
     EMPLOYEE_LOAN D
where A.HEAD_ID = B.DTYPE_ID
  AND B.DTYPE_ID = C.TYPE_ID
  AND C.EMPLOYEE_ID = D.EMPLOYEE_ID
  AND D.EXE_CAR_LOAN = 2
  AND C.PAY_OR_DED_TYPE = 2
  AND C.TYPE_ID = 3
    $empId
  --AND FXN_CBS_BR_CODE(C.BRANCH_ID) in 
  AND EMP_STATUS(C.EMPLOYEE_ID) = 1
GROUP BY C.PAYMENT_DATE, A.GL_PL_NO, B.DESCRIPTION, C.EMPLOYEE_ID, C.TYPE_ID, C.BRANCH_ID");

        /*---------Mobile Bill PL Debit and SD Card Gl Credit----------*/
        $salaryProcess['mBillPlToCardGl'] = DB::select("
        select (select GL_PL_NO from SALARY_GL_PL where HEAD_ID = 61) DEBIT,
       'MOBILE-BILL'                                          DESCRIPTION,
       (select GL_PL_NO from SALARY_GL_PL where HEAD_ID = 17) ACCOUNTNO,--17 = SD prepaid Card Head
       SUM(C.BILL_AMOUNT)                                     AMOUNT,
       'CR'                                                   DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                           TRAN_BR_CODE,
       '0001'                                                 AC_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                           BRANCH_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                           DEBIT_BR_CODE,
       D.PAYMENT_DATE                                         PAYMENT_DATE
from EMPLOYEE_BILLS_TMP C,
     EMP_PAID_DAY_COUNT D
where C.EMPLOYEE_ID = D.EMPLOYEE_ID
       $empId
GROUP BY FXN_CBS_BR_CODE(C.BRANCH_ID), D.PAYMENT_DATE
ORDER BY TO_NUMBER(FXN_CBS_BR_CODE(C.BRANCH_ID))
        ");


        /**************************** MD Salary Process *****************************/

        $salaryProcess['plDebitMD'] = DB::select("
        select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1)           ACCOUNTNO,
       DECODE(A.GL_PL_NO, '8000531', '8000501', '8000533', '8000502', '8000550', '8000508') DEBIT,
       B.DESCRIPTION,
       SUM(C.PAY_AMOUNT)                                                                    AMOUNT,
       'CR'                                                                                 DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                         TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                         AC_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                         BRANCH_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                         DEBIT_BR_CODE,
       C.PAYMENT_DATE                                                                       PAYMENT_DATE,
       B.SORTING
from SALARY_GL_PL A,
     PAY_TYPE B,
     EMP_SAL_PAY_DED_TEMP C,
     EMP_PAID_DAY_COUNT D
where A.HEAD_ID = B.PTYPE_ID
  AND B.PTYPE_ID = C.TYPE_ID
  AND C.EMPLOYEE_ID = D.EMPLOYEE_ID
  AND A.HEAD_TYPE = 'P'
  AND C.PAY_OR_DED_TYPE = 1 -- Pay Type
  --AND C.EMPLOYEE_ID = '20220310001'
  $empId
  AND C.PAY_OR_DED_TYPE = 1
GROUP BY A.GL_PL_NO, FXN_CBS_BR_CODE(C.BRANCH_ID), A.HEAD_ID, C.PAYMENT_DATE, B.DESCRIPTION, B.SORTING
ORDER BY TO_NUMBER(FXN_CBS_BR_CODE(C.BRANCH_ID)), B.SORTING
        ");
        $salaryProcess['pToSalAcMD'] = DB::select("
        select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) DEBIT,
       CONCAT('SALARY', CONCAT('-', TO_CHAR(C.PAYMENT_DATE, 'MONYYYY')))          DESCRIPTION,
       C.EMPLOYEE_ID,
       FXN_EMP_SAL_ACC(C.EMPLOYEE_ID)                                             ACCOUNTNO,
       NVL(FXN_EMP_NET_SAL(C.EMPLOYEE_ID), 0)                                     AMOUNT,
       'CR'                                                                       DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               DEBIT_BR_CODE,
       SUBSTR(FXN_EMP_SAL_ACC(C.EMPLOYEE_ID), 1, 4)                               AC_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               BRANCH_CODE,
       C.PAYMENT_DATE                                                             PAYMENT_DATE
from EMP_SAL_PAY_DED_TEMP C
where C.PAY_OR_DED_TYPE = 1 -- Pay Type
  --AND C.EMPLOYEE_ID = '20220310001'
    $empId
GROUP BY FXN_CBS_BR_CODE(C.BRANCH_ID), C.PAYMENT_DATE, C.EMPLOYEE_ID
ORDER BY FXN_CBS_BR_CODE(C.BRANCH_ID)
        ");


        /**************************** Festival Bonus Process *****************************/

        $salaryProcess['plDebitPGlCreditBonus']=DB::select("
        select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) ACCOUNTNO,
       DECODE(C.PAY_TYPE_ID, 48, (select GL_PL_NO from SALARY_GL_PL where ID = 31 and ROWNUM = 1),
              (select GL_PL_NO from SALARY_GL_PL where ID = 81 and ROWNUM = 1))   DEBIT,
       CONCAT(UPPER(REPLACE(D.TYPE, '-')), 'BONUS')                               DESCRIPTION,
       SUM(C.AMOUNT)                                                              AMOUNT,
       'CR'                                                                       DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               AC_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               BRANCH_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               DEBIT_BR_CODE,
       C.PAYMENT_DATE                                                             PAYMENT_DATE
from SALARY_GL_PL A,
     PAY_TYPE B,
     EMP_BONUS C,
     BONUS_TYPE D
where A.HEAD_ID = B.PTYPE_ID
  AND B.PTYPE_ID = C.PAY_TYPE_ID
  AND C.BONUS_TYPE = D.ID
  AND A.HEAD_TYPE = 'P'
  -- AND C.STATUS=1
GROUP BY A.GL_PL_NO, FXN_CBS_BR_CODE(C.BRANCH_ID), A.HEAD_ID, C.PAYMENT_DATE, C.PAY_TYPE_ID, D.TYPE
ORDER BY TO_NUMBER(FXN_CBS_BR_CODE(C.BRANCH_ID)) ");

        $salaryProcess['pToSalAcBonus']= DB::select("
        select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1)                DEBIT,
       CONCAT(UPPER(REPLACE(B.TYPE, '-')), CONCAT('BONUS-', TO_CHAR(C.PAYMENT_DATE, 'MONYYYY'))) DESCRIPTION,
       C.EMPLOYEE_ID,
       FXN_EMP_SAL_ACC(C.EMPLOYEE_ID)                                                            ACCOUNTNO,
       C.AMOUNT                                                                                  AMOUNT,
       'CR'                                                                                      DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                              TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                              DEBIT_BR_CODE,
       SUBSTR(FXN_EMP_SAL_ACC(C.EMPLOYEE_ID), 1, 4)                                              AC_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                                              BRANCH_CODE,
       C.PAYMENT_DATE                                                                            PAYMENT_DATE
from SALARY_GL_PL A,
     BONUS_TYPE B,
     EMP_BONUS C
where A.HEAD_ID = C.PAY_TYPE_ID
  AND B.ID = C.BONUS_TYPE
  AND A.HEAD_TYPE = 'P'
   AND C.STATUS=1
GROUP BY FXN_CBS_BR_CODE(C.BRANCH_ID), C.PAYMENT_DATE, C.EMPLOYEE_ID, B.TYPE, C.AMOUNT
ORDER BY FXN_CBS_BR_CODE(C.BRANCH_ID) ");

        /*---------Parking GL Debit And Provision GL Credit For Bonus----------*/
        $salaryProcess['pGlToProvisionGlBonus'] = DB::select("select (select GL_PL_NO from SALARY_GL_PL where HEAD_TYPE is null and ROWNUM = 1) DEBIT,
       CONCAT(UPPER(REPLACE(B.TYPE, '-')), CONCAT('BONUS-PROBATION', TO_CHAR(C.PAYMENT_DATE, 'MONYYYY'))) DESCRIPTION,
       C.EMPLOYEE_ID,
       (select GL_PL_NO from SALARY_GL_PL where ID = 41)                          ACCOUNTNO,
       SUM(AMOUNT)                                                            AMOUNT,
       'CR'                                                                       DR_CR,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               TRAN_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               DEBIT_BR_CODE,
       '0001'                                                                     AC_BR_CODE,
       FXN_CBS_BR_CODE(C.BRANCH_ID)                                               BRANCH_CODE,

       C.PAYMENT_DATE                                                             PAYMENT_DATE
from SALARY_GL_PL A,
     BONUS_TYPE B,
     EMP_BONUS C
where A.HEAD_ID = C.PAY_TYPE_ID
  AND B.ID = C.BONUS_TYPE
  AND A.HEAD_TYPE = 'P'
   AND C.STATUS=3
GROUP BY FXN_CBS_BR_CODE(C.BRANCH_ID), C.PAYMENT_DATE, C.EMPLOYEE_ID, B.TYPE, C.AMOUNT
ORDER BY FXN_CBS_BR_CODE(C.BRANCH_ID) ");




        return empty($salaryProcess) ? [] : $salaryProcess;
    }

    /*------------------------------------New Process Ended--------------------------------------*/


}