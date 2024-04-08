<?php

namespace App\Modules\Payroll\Http\Controllers;


use App\Functions\BranchFunction;
use App\Functions\EmployeeFunction;
use App\Functions\GlPlFunction;
use App\Http\Controllers\Controller;
use App\Modules\Branch\Models\Branch;
use App\Modules\Employee\Models\EmployeeDetails;
use App\Modules\EmployeeIncrement\Models\SalaryDedSlip;
use App\Modules\FestivalBonus\Models\FestivalBonus;
use App\Modules\FestivalBonus\Models\FestivalBonusArchive;
use App\Modules\Payroll\Models\Bills\EmployeeBillsArchive;
use App\Modules\Payroll\Models\Bills\EmployeeBillsTmp;
use App\Modules\Payroll\Models\Bills\EmployeeBillsTmpView;
use App\Modules\Payroll\Models\DeductionType;
use App\Modules\Payroll\Models\EmpBonusTransactionArchive;
use App\Modules\Payroll\Models\EmployeePaymentArchive;
use App\Modules\Payroll\Models\EmployeePayOrDedTemp;
use App\Modules\Payroll\Models\EmployeeSalaryStop;
use App\Modules\Payroll\Models\Loan;
use App\Modules\Payroll\Models\PaidDay;
use App\Modules\Payroll\Models\PaidDayArchive;
use App\Modules\Payroll\Models\PayType;
use App\Modules\Payroll\Models\SalaryNotes;
use App\Modules\Payroll\Models\SalaryProcess;
use App\Modules\Payroll\Models\TransactionArchive;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;


class SalaryProcessController extends Controller
{
    public function __construct()
    {
        $_SESSION["MenuActive"] = "Payroll";
    }

    public function regularEmpSalary($date): array
    {
//        dd('test');
        return DB::select("
        select V.EMPLOYEE_ID,
                                TO_DATE('$date', 'YYYY-MM-DD')                  PAYMENT_DATE,
                                TO_CHAR(sysdate, 'Mon-YYYY')                       YEAR_MONTH,
                                CASE
                                    WHEN TO_DATE(V.JOINING_DATE, 'DD/MM/YYYY') < trunc(sysdate, 'MM')
                                        THEN trunc(sysdate, 'MM')
                                    ELSE TO_DATE(V.JOINING_DATE, 'DD/MM/YYYY') END DEFAULT_DATE,
                                FXN_EMP_SALARY_DAY_COUNT(V.EMPLOYEE_ID)            DAY_COUNT,
                                TO_DATE(LAST_DAY(SYSDATE))                         END_DATE,
                                1 EMP_STATUS
                         from EMPLOYEE_DETAILS V
                         WHERE FXN_EMP_STATUS_AND_TYPE(EMPLOYEE_ID) = 1 
                                AND V.EMPLOYEE_ID not in (select EMPLOYEE_ID from EMP_STOP_SAL where STATUS in (4))
                           --AND EMPLOYEE_ID='20230206001'
                           ");
    }

    public function resignedEmpSalary($date): array
    {
        $firstAndLastDay = DB::Select("select trunc(sysdate, 'MM') firstDay,LAST_DAY(SYSDATE) lastDay from dual");
        $firstDay = date('Y-m-d', strtotime($firstAndLastDay[0]->firstday));
        $lastDay = date('Y-m-d', strtotime($firstAndLastDay[0]->lastday));
        return DB::select("
                                select V.EMPLOYEE_ID,
                                 TO_DATE('$date', 'YYYY-MM-DD')                  PAYMENT_DATE,
                                 TO_CHAR(sysdate, 'Mon-YYYY')                              YEAR_MONTH,
                                 trunc(sysdate, 'MM')              DEFAULT_DATE,
                                 CAST(TO_DATE(TO_CHAR(RELEASE_DATE), 'DD-MM-YYYY')-trunc(sysdate, 'MM')
                                       as INT)+1 DAY_COUNT,
                                 TO_DATE(TO_CHAR(RELEASE_DATE), 'DD-MM-YYYY')                                END_DATE,
                                 2 EMP_STATUS
                          from RESIGNATION V
                          WHERE FXN_EMP_STATUS_AND_TYPE(EMPLOYEE_ID)=2
                            AND V.STATUS=1
                            AND V.EMPLOYEE_ID not in (select EMPLOYEE_ID from EMP_STOP_SAL where STATUS in (4))
                          AND TO_DATE(TO_CHAR(RELEASE_DATE), 'DD-MM-YYYY') between '$firstDay' and '$lastDay'
                          ");
    }

    public function allFunctions(): array
    {
        $data['allEmployees'] = EmployeeFunction::allEmployees();
        $data['allBranches'] = BranchFunction::allBranches();
        $data['activeBranches'] = BranchFunction::activeOrInactiveBranches(1);
        $data['inactiveBranches'] = BranchFunction::activeOrInactiveBranches(2);
        $data['branch'] = BranchFunction::headOfficeOrBranch(2);
        $data['empCondition'] = array(
            '' => 'Please Select',
            '1' => 'Regular',
            '2' => 'Resigned',
        );
        $data['hoOrBranchOrBoth'] = [
            '' => 'Please Select',
            '1' => 'Regular(HO+BR)',
            '2' => 'Managing Director',
            '3' => 'Festival Bonus'

        ];
        return $data;
    }

    public function salFunctions($empCondition, $date): ?array
    {

        $paidDayTableCheck = PaidDay::where([['payment_date', $date], ['emp_status', $empCondition]])->get();

        if ($empCondition == 1) {
            if (isset($paidDayTableCheck)) {
                $dataSet['regularEmpSalary'] = $this->regularEmpSalary($date);
            } else {
                $dataSet['regularEmpSalary'] = $paidDayTableCheck->toarray();
            }

        } else {
            if (isset($paidDayTableCheck)) {
                $dataSet['resignedEmpSalary'] = $this->resignedEmpSalary($date);
            } else {
                $dataSet['resignedEmpSalary'] = $paidDayTableCheck->toarray();
            }
        }
        return empty($dataSet) ? null : $dataSet;
    }

    /**
     * Display the module welcome screen
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(Request $request)
    {

        $_SESSION["SubMenuActive"] = "payroll-salary-process";
        $allFunctions = $this->allFunctions();

        $data['empCondition'] = $allFunctions['empCondition'];
        $data['empSal'] = [''];

        $salDate = date('Y-m-d', strtotime($request->payment_date));
        $data['paidDay'] = PaidDay::where('payment_date', $salDate)->where('emp_status', $request->empCondition)->first();

        try {
            switch ($request->submit) {
                case 'Search':
                    if (!empty($data['paidDay']->payment_date)) {
                        $data['empSal'] = PaidDay::where('payment_date', $salDate)->where('emp_status', $request->empCondition)->get();
                    } else {
                        if ($request->empCondition == 1) {

                            $data['empSal'] = $this->regularEmpSalary($salDate);
                        } else {
                            $data['empSal'] = $this->resignedEmpSalary($salDate);
                        }
                    }
                    break;
                case 'Process':
                    $this->paidDayProcess($request);

                    break;
                case 'FinalProcess':
                    $this->finalPaidDayProcess();
                    $this->employeeBillGenerate();
                    $this->makeOrArchiveSalaryNote('');
                    break;
            }
        } catch (\Exception $e) {
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }


        return view('Payroll::SalaryProcess/view', compact('data'));
    }

    public function glPlMapIndex(Request $request)
    {
        $glPlFunction = $this->glPlFunctions($request->cbsCode, $request->branchCode);

        $data['allGlPlAmount'] = $glPlFunction['allGlPlAmount'];
        return View('Payroll::SalaryProcess/salaryProcessView', compact('data'));
    }


    public function paidDayProcessData($employee_id, $payment_date, $year_month, $default_date, $day_count, $end_date, $emp_status): array
    {
        return array(
            'employee_id' => $employee_id,
            'payment_date' => date('Y-m-d', strtotime($payment_date)),
            'year_month' => $year_month,
            'default_date' => date('Y-m-d', strtotime($default_date)),
            'day_count' => (int)$day_count,
            'end_date' => date('Y-m-d', strtotime($end_date)),
            'emp_status' => $emp_status
        );

    }

    public function paidProcessFunction($salData, $empCondition, $date)
    {


        $salFunctions = $this->salFunctions($empCondition, $date);

        if (!empty($salFunctions[$salData])) {
            foreach ($salFunctions[$salData] as $regular) {
                $paidDay = new PaidDay();

                $currentUnpaidEmp = PaidDay::where('employee_id', $regular->employee_id)->first();

                if (!empty($currentUnpaidEmp->employee_id) && !empty($currentUnpaidEmp->payment_date)) {
                    if ($regular->employee_id == $currentUnpaidEmp->employee_id && $regular->payment_date == $currentUnpaidEmp->payment_date) {
                        $data = $this->paidDayProcessData($regular->employee_id, $regular->payment_date, $regular->year_month, $regular->default_date, $regular->day_count, $regular->end_date, $regular->emp_status);
                        $paidDay->findOrFail($currentUnpaidEmp->id)->fill($data)->save();
                    } else {
                        $data = $this->paidDayProcessData($regular->employee_id, $regular->payment_date, $regular->year_month, $regular->default_date, $regular->day_count, $regular->end_date, $regular->emp_status);
                        $paidDay->fill($data)->save();
                    }
                } else {
                    $data = $this->paidDayProcessData($regular->employee_id, $regular->payment_date, $regular->year_month, $regular->default_date, $regular->day_count, $regular->end_date, $regular->emp_status);
                    $paidDay->fill($data)->save();

                }

            }
        } else {
            return null;
        }


    }

    public function paidDayProcess(Request $request): RedirectResponse
    {

        try {
            $salDate = date('Y-m-d', strtotime($request->payment_date));

            if ((int)$request->empCondition == 1) {
                $regular = $this->paidProcessFunction('regularEmpSalary', $request->empCondition, $salDate);

                if (!empty($regular)) {
                    return Redirect()->back()->with('msg-success', 'No Data Found');
                }
                return Redirect()->back()->with('msg-success', 'Information Updated Successfully');


            } else {
                $resign = $this->paidProcessFunction('resignedEmpSalary', $request->empCondition, $salDate);
                if (!empty($resign)) {
                    return Redirect()->back()->with('msg-success', 'No Data Found');
                }
                return Redirect()->back()->with('msg-success', 'Information Inserted Successfully');

            }
        } catch (\Exception $e) {
            \Log::info('SalaryProcessController-paidDayProcess-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    public function employeeBillGenerate(): RedirectResponse
    {
        $paidEmpS = PaidDay::select('EMP_PAID_DAY_COUNT.EMPLOYEE_ID')
            ->join('V_EMP_BILL_TEMP as V', 'V.EMPLOYEE_ID', '=', 'EMP_PAID_DAY_COUNT.EMPLOYEE_ID')
            ->get();
        foreach ($paidEmpS as $paidEmp) {
            $tmpBills = EmployeeBillsTmpView::where('employee_id', $paidEmp->employee_id)->first();
            $billInfo = [
                'employee_id' => $tmpBills->employee_id,
                'bill_amount' => $tmpBills->bill_amount,
                'status' => $tmpBills->status,
                'remarks' => $tmpBills->remarks,
                'branch_id' => $tmpBills->branch_id,
                'created_by' => auth()->user()->id
            ];
            $tmpBill = new EmployeeBillsTmp();
            $duplicateCheck = EmployeeBillsTmp::where('employee_id', $tmpBills->employee_id)->first();
            if (empty($duplicateCheck)) {
                $tmpBill->fill($billInfo)->save();
            } else {
                $tmpBill->findOrFail($duplicateCheck->id)->update($billInfo);
            }

        }

        return Redirect()->back()->with('msg-success', 'Information Updated Successfully');
    }

    public function finalPaidDayProcessData($status, $day_paid, $remarks): array
    {
        return array(
            'status' => $status,
            'day_paid' => $day_paid,
            'remarks' => $remarks,
            'ready_to_pay' => 2
        );
    }

    /**
     * This Function will update emp_paid_day_cont
     * we will update only when the
     * ---------Ready To Pay------------
     * 1 = No
     * 2 = Yes
     * 3 = LWP(Leave Without Pay)
     * Information Will update status,day_paid,remarks
     * --------Status-----
     * 1 = Full
     * 2 = Partial
     * 3 = Partial Joining
     * 4 = Stop
     * 5 = On Provision
     * @return RedirectResponse
     */

    public function finalPaidDayProcess(): RedirectResponse
    {
        try {
            $totalDaysOfCurrentMonth = DB::select("select CAST(TO_CHAR(LAST_DAY(sysdate), 'DD') AS number) totalMonthDay from dual");
            $totalDays = (int)$totalDaysOfCurrentMonth[0]->totalmonthday;
            $empPaidDays = PaidDay::where('ready_to_pay', 1)->get();


            foreach ($empPaidDays as $empPaidDay) {
                $updatePaidDay = new PaidDay();
                $empJoiningDate = EmployeeDetails::select('joining_date')->where('employee_id', $empPaidDay->employee_id)->first();
                $dateJoin = str_replace('/', '-', $empJoiningDate->joining_date);
                $salProvisionEmpS = EmployeeSalaryStop::where('employee_id', $empPaidDay->employee_id)->where('status', 5)->first();

                if (empty($salProvisionEmpS)) {

                    if ($empPaidDay->status != 1) {

                        $updateData = $this->finalPaidDayProcessData($empPaidDay->status, (int)$empPaidDay->day_paid, $empPaidDay->remarks);
                    } else {
                        if ((int)$empPaidDay->day_count == $totalDays) {
                            $updateData = $this->finalPaidDayProcessData(1, (int)$empPaidDay->day_count, 'Full');
                        } else {
                            if (date('Y-m-d', strtotime($empPaidDay->default_date)) == date('Y-m-d', strtotime($dateJoin))) {
                                $updateData = $this->finalPaidDayProcessData(3, (int)$empPaidDay->day_count, 'Partial Joining');
                            } else {
                                $updateData = $this->finalPaidDayProcessData(2, (int)$empPaidDay->day_count, 'Partial');
                            }

                        }
                    }

                } else {

                    $updateData = $this->finalPaidDayProcessData(5, (int)$empPaidDay->day_count, 'On Provision');
                }
                $updatePaidDay->findOrFail($empPaidDay->id)->fill($updateData)->save();
            }

            return Redirect()->back()->with('msg-success', 'Information Updated Successfully');
        } catch (\Exception $e) {
            \Log::info('SalaryProcessController-finalPaidDayProcess-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    public function makeSalaryNoteData($SalNotesData): array
    {
        foreach ($SalNotesData as $request) {
            $requestData[] = [
                'pay_or_ded_type' => $request->pay_or_ded_type,
                'type_id' => $request->type_id,
                'total_amount' => $request->total_amount,
                'month_year' => $request->month_year,
                'paid_date' => $request->paid_date,
                'status' => $request->status,
                'sorting' => $request->sorting,
            ];
        }

        return !empty($requestData) ? $requestData : [];
    }

    public function salNoteData(): array
    {
        $data['payTypeAmountsOfSalNotes'] = GlPlFunction::payTypeAmountsOfSalNotes();
        $data['deductionTypeAmountsOfSalNotes'] = GlPlFunction::deductionTypeAmountsOfSalNotes();
        $data['provisionAmountsOfSalNotes'] = GlPlFunction::provisionAmountsOfSalNotes();

        $noteData['payType'] = $this->makeSalaryNoteData($data['payTypeAmountsOfSalNotes']);
        $noteData['deductionType'] = $this->makeSalaryNoteData($data['deductionTypeAmountsOfSalNotes']);
        $noteData['provision'] = $this->makeSalaryNoteData($data['provisionAmountsOfSalNotes']);

        return !empty($noteData) ? $noteData : [];
    }

    public function makeOrArchiveSalaryNote($makeOrArchive): RedirectResponse
    {
        try {
            $allData = $this->salNoteData();

            if (!empty($allData)) {

                foreach ($allData as $notes) {

                    foreach ($notes as $note) {

                        $salNotes = new SalaryNotes();
                        $duplicateCheck = $salNotes->where('pay_or_ded_type', $note['pay_or_ded_type'])
                            ->where('type_id', $note['type_id'])
                            ->where('month_year', $note['month_year'])
                            ->where('paid_date', $note['paid_date'])
                            ->where('status', $note['status'])->first();
                        if (empty($makeOrArchive)) {

                            if (empty($duplicateCheck)) {

                                $salNotes->fill($note)->save();
                            } else {

                                $salNotes->findOrFail($duplicateCheck->id)->fill($note)->save();
                            }
                        } else {

                            $salNotes->findOrFail($duplicateCheck->id)->fill(['status' => 2])->save();
                        }
                    }
                }
            } else {
                \Log::info('SalaryProcessController-makeSalaryNote-' . 'NUll Error');
            }
            return Redirect()->back()->with('msg-success', 'Data Updated');

        } catch (\Exception $e) {
            \Log::info('SalaryProcessController-makeSalaryNote-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /*--------------------------------Salary Process Section Started--------------------------------------*/
    /**
     * @param $allRequests
     * @return array
     */
    public function finalSalProcessData($allRequests): array
    {

        foreach ($allRequests as $index => $allRequest) {
            foreach ($allRequest as $request) {
                $accountNo = empty($request->accountno) ? (empty($request['accountno']) ? $request->accountno : $request['accountno']) : $request->accountno;
                //$amount = (float)(empty($request->amount) ? (empty($request['amount']) ? $request->amount : $request['amount']) : $request->amount);
                if (is_object($request)) {
                    $amount = (float)(empty($request->amount) ? $request->amount : $request->amount);
                } else {
                    $amount = (float)(empty($request['amount']) ? $request['amount'] : $request['amount']);
                }
                $debitCredit = empty($request->dr_cr) ? (empty($request['dr_cr']) ? $request->dr_cr : $request['dr_cr']) : $request->dr_cr;
                $trnBrCode = empty($request->tran_br_code) ? (empty($request['tran_br_code']) ? $request->tran_br_code : $request['tran_br_code']) : $request->tran_br_code;
                $trnBrCode = empty($request->tran_br_code) ? (empty($request['tran_br_code']) ? $request->tran_br_code : $request['tran_br_code']) : $request->tran_br_code;
                $acBrCode = empty($request->ac_br_code) ? (empty($request['ac_br_code']) ? $request->ac_br_code : $request['ac_br_code']) : $request->ac_br_code;
                $payDate = empty($request->payment_date) ? (empty($request['payment_date']) ? $request->payment_date : $request['payment_date']) : $request->payment_date;
                $branchCode = empty($request->branch_code) ? (empty($request['branch_code']) ? $request->branch_code : $request['branch_code']) : $request->branch_code;
                $description = empty($request->description) ? empty($request['remarks']) ? $request->description . '-' . $debitCredit : $request['remarks'] : $request->description . '-' . $debitCredit;
                $remarks = $description;

                $requestData[] = array(
                    'accountno' => $accountNo,
                    'amount' => !empty($amount) ? $amount : 0,
                    'dr_cr' => $debitCredit,
                    'tran_br_code' => $trnBrCode,
                    'ac_br_code' => $acBrCode,
                    'payment_date' => date('Y-m-d', strtotime($payDate)),
                    'remarks' => strtoupper(preg_replace('/\s+/', '', $remarks)),
                    'branch_code' => $branchCode,
                    'process_index' => $index,
                    'created_by' => auth()->user()->id
                );

            }

        }

        return !empty($requestData) ? $requestData : [];
    }

    /**
     * @param $requests
     * @return array
     */
    public function glDebitArray($requests): array
    {
        foreach ($requests as $request) {
            if (isset($request->debit)) {
                $requestData[] = array(
                    'accountno' => $request->debit,
                    'amount' => $request->amount,
                    'dr_cr' => 'DR',
                    'tran_br_code' => $request->tran_br_code,
                    'ac_br_code' => $request->debit_br_code,
                    'payment_date' => date('Y-m-d', strtotime($request->payment_date)),
                    'remarks' => strtoupper($request->description . '-DR'),
                    'branch_code' => $request->branch_code,
                );

            } else {
                return ['Employee Account Not Found'];
            }

        }
        return !empty($requestData) ? $requestData : [];

    }

    public function regularSalary($singleEmpId): array
    {
        $regularSal['allProcess'] = GlPlFunction::regularEmpSalaryProcess($singleEmpId);

        $data['plBalanceDebit'] = $regularSal['allProcess']['plBalanceDebit'];

        $data['pGlBalanceCredit'] = $regularSal['allProcess']['pGlBalanceCredit'];

        $data['pGlToCardGlDr'] = $this->glDebitArray($regularSal['allProcess']['pGlToCardGl']);
        $data['pGlToCardGlCr'] = $regularSal['allProcess']['pGlToCardGl'];

        $data['pGlToDeductionGlDr'] = $this->glDebitArray($regularSal['allProcess']['pGlToDeductionGl']);
        $data['pGlToDeductionGlCr'] = $regularSal['allProcess']['pGlToDeductionGl'];

        /**
         * This operation will be used only for half day basic donation and It used on March-2024 Month
         */
        $data['branchParkingGlToHeadOfficeParkingGlDr'] = $this->glDebitArray($regularSal['allProcess']['branchParkingGlToHeadOfficeParkingGl']);
        $data['branchParkingGlToHeadOfficeParkingGlCr'] = $regularSal['allProcess']['branchParkingGlToHeadOfficeParkingGl'];

        $data['pGlToPfGlDr'] = $this->glDebitArray($regularSal['allProcess']['pGlToPfGl']);
        $data['pGlToPfGlCr'] = $regularSal['allProcess']['pGlToPfGl'];

        $data['pGlToProvisionGlDr'] = $this->glDebitArray($regularSal['allProcess']['pGlToProvisionGl']);
        $data['pGlToProvisionGlCr'] = $regularSal['allProcess']['pGlToProvisionGl'];


        $data['pGlToEmpSalAccDr'] = $this->glDebitArray($regularSal['allProcess']['pGlToEmpSalAcc']);
        $data['pGlToEmpSalAccCr'] = $regularSal['allProcess']['pGlToEmpSalAcc'];

        $data['empSalAccToLoanAccDr'] = $this->glDebitArray($regularSal['allProcess']['empSalAccToLoanAcc']);
        $data['empSalAccToLoanAccCr'] = $regularSal['allProcess']['empSalAccToLoanAcc'];

        $data['pGlToSevpCarLoanAccDr'] = $this->glDebitArray($regularSal['allProcess']['pGlToSevpCarLoanAcc']);
        $data['pGlToSevpCarLoanAccCr'] = $regularSal['allProcess']['pGlToSevpCarLoanAcc'];

        $data['mBillPlToCardGlDr'] = $this->glDebitArray($regularSal['allProcess']['mBillPlToCardGl']);
        $data['mBillPlToCardGlCr'] = $regularSal['allProcess']['mBillPlToCardGl'];


        return empty($data) ? [] : $data;
    }

    public function mdSalary($singleEmpId): array
    {
        $regularSal['mdProcess'] = GlPlFunction::regularEmpSalaryProcess($singleEmpId);


        $data['plBalanceDebitMDDr'] = $this->glDebitArray($regularSal['mdProcess']['plDebitMD']);
        $data['plBalanceDebitMDCr'] = $regularSal['mdProcess']['plDebitMD'];

        $data['pGlToDeductionGlMDDr'] = $this->glDebitArray($regularSal['mdProcess']['pGlToDeductionGl']);
        $data['pGlToDeductionGlMDCr'] = $regularSal['mdProcess']['pGlToDeductionGl'];

        $data['pToSalAcMDDr'] = $this->glDebitArray($regularSal['mdProcess']['pToSalAcMD']);
        $data['pToSalAcMDCr'] = $regularSal['mdProcess']['pToSalAcMD'];

        return empty($data) ? [] : $data;

    }

    public function festivalBonus($singleEmpId): array
    {
        $festivalBonus['festivalBonusProcess'] = GlPlFunction::regularEmpSalaryProcess($singleEmpId);

        $data['plDebitPGlCreditBonusDr'] = $this->glDebitArray($festivalBonus['festivalBonusProcess']['plDebitPGlCreditBonus']);
        $data['plDebitPGlCreditBonusCr'] = $festivalBonus['festivalBonusProcess']['plDebitPGlCreditBonus'];

        $data['pToSalAcBonusDr'] = $this->glDebitArray($festivalBonus['festivalBonusProcess']['pToSalAcBonus']);
        $data['pToSalAcBonusCr'] = $festivalBonus['festivalBonusProcess']['pToSalAcBonus'];

        $data['pGlToProvisionGlBonusDr'] = $this->glDebitArray($festivalBonus['festivalBonusProcess']['pGlToProvisionGlBonus']);
        $data['pGlToProvisionGlBonusCr'] = $festivalBonus['festivalBonusProcess']['pGlToProvisionGlBonus'];

        return empty($data) ? [] : $data;

    }

    /**
     * @param $hoOrBr
     * @return array
     */
    public function hoOrBranchProcess($hoOrBr): array
    {
        if (!empty($hoOrBr)) {
            if ($hoOrBr == 1) {
                $data = $this->regularSalary('');

            } elseif ($hoOrBr == 3) {
                $data = $this->festivalBonus('');
            } else {
                /**
                 * Need To Change before the next Salary
                 */
                $mD = EmployeeDetails::select('EMPLOYEE_ID')->where('EMPLOYEE_ID', '20220310001')->first();
                $data = $this->mdSalary($mD->employee_id);
            }
        } else {
            $data = [];
        }

        return $data;

    }

    /**
     * @param Request $request
     * @return Application|Factory|RedirectResponse|View
     */
    public function finalSalProcessIndex(Request $request)
    {
        $allData['bonus'] = FestivalBonus::all();
        try {
            $allFunctions = $this->allFunctions();
            switch ($request->submit) {
                case 'Search':
                    if (!empty($request->hoOrBr)) {
                        $data = $this->hoOrBranchProcess($request->hoOrBr);
                        $allData['sal'] = $this->finalSalProcessData($data);
                    } else {
                        $allData = [];
                    }
                    break;
                case 'Process':
                    if ($request->hoOrBr == 1) {
                        $data = $this->hoOrBranchProcess($request->hoOrBr);
                        $allData['sal'] = $this->finalSalProcessData($data);
                        foreach ($allData['sal'] as $salData) {
                            $salaryProcess = new SalaryProcess();
                            $salaryProcess->fill($salData)->save();
                        }
                        $regularProcess = SalaryProcess::where('process_index', 'NOT LIKE', '%Loan%')->get();
                        $loanProcess = SalaryProcess::where('process_index', 'LIKE', '%Loan%')->get();
                        $billProcess = SalaryProcess::where('process_index', 'LIKE', '%Bill%')->get();

                        foreach ($regularProcess as $process) {
                            $salaryProcess = new SalaryProcess();
                            $salaryProcess->findOrFail($process->id)->update(['process_id' => 1]);
                        }
                        foreach ($loanProcess as $process) {
                            $salaryProcess = new SalaryProcess();
                            $salaryProcess->findOrFail($process->id)->update(['process_id' => 2]);
                        }
                        foreach ($billProcess as $process) {
                            $salaryProcess = new SalaryProcess();
                            $salaryProcess->findOrFail($process->id)->update(['process_id' => 3]);
                        }
                    } elseif ($request->hoOrBr == 3) {
                        $data = $this->hoOrBranchProcess($request->hoOrBr);
                        $allData['sal'] = $this->finalSalProcessData($data);
                        foreach ($allData['sal'] as $salData) {
                            $salaryProcess = new SalaryProcess();
                            $salaryProcess->fill($salData)->save();
                        }
                        $festivalBonusProcess = SalaryProcess::where('process_index', 'LIKE', '%Bonus%')->get();
                        foreach ($festivalBonusProcess as $process) {
                            $salaryProcess = new SalaryProcess();
                            $salaryProcess->findOrFail($process->id)->update(['process_id' => 5]);
                        }
                    } elseif ($request->hoOrBr == 2) {
                        $data = $this->hoOrBranchProcess($request->hoOrBr);
                        $allData['sal'] = $this->finalSalProcessData($data);
                        foreach ($allData['sal'] as $salData) {
                            $salaryProcess = new SalaryProcess();
                            $salaryProcess->fill($salData)->save();
                        }

                        $mdProcess = SalaryProcess::where('process_index', 'LIKE', '%MD%')->get();
                        foreach ($mdProcess as $process) {
                            $salaryProcess = new SalaryProcess();
                            $salaryProcess->findOrFail($process->id)->update(['process_id' => 4]);
                        }
                    } else {
                        return Redirect()->back()->with('msg-error', 'Else Block Selected');
                    }
                    return Redirect()->back()->with('msg-success', 'Information Updated');
                    break;
                case 'FinalProcess':
                    $this->empPaidDayArchive();
                    $this->glPlTransactionsArchive();
                    $this->payOrDedTempArchiveProcess();
                    $this->loanBillArchAndDeductionAccumulation();
                    return Redirect()->back()->with('msg-success', 'Information Updated');
                    break;
                case 'FestivalBonus':

                    $this->BonusglPlTransactionsArchive();
                    $this->empBonusArchive();
                    return Redirect()->back()->with('msg-success', 'FestivalBonus Information Updated');
                    break;
            }

            $allData['hoOrBranchOrBoth'] = $allFunctions['hoOrBranchOrBoth'];

            return View('Payroll::SalaryProcess/finalSpView', compact('allData'));
        } catch (\Exception $e) {
            \Log::info('SalaryProcessController-finalSalProcessIndex-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /*-----------------------------Salary Process Section Ended--------------------------------------*/


    /*-----------------------------Archive Section Started--------------------------------------*/

    /*--------------------------------------EMP Pay Or Ded Temp Archive-----------------------------*/

    /**
     * @param $payOrDed
     * @param $typeId
     * @return mixed
     */
    public function getPaymentOrDeductionType($payOrDed, $typeId)
    {
        if ($payOrDed == 1) {
            $paymentOrDedType = PayType::select('description')->where('ptype_id', $typeId)->first();
        } else {
            $paymentOrDedType = DeductionType::select('description')->where('dtype_id', $typeId)->first();
        }

        return $paymentOrDedType->toarray();

    }

    /**
     * @param $payOrDed
     * @param $type_id
     * @param $pay_amount
     * @param $payType
     * @return array
     */
    public function payOrDedArray($payOrDed, $type_id, $pay_amount, $payType): array
    {
        return [
            'type_id' => number_format($type_id),
            'type_name' => $this->getPaymentOrDeductionType($payOrDed, $type_id)['description'],
            'pay_amount' => number_format($pay_amount, 2),
            'pay_type' => $payType,
        ];
    }

    /**
     * @param $employeeId
     * @return false|string
     */
    public function finalSalArchive($employeeId)
    {
        $currentData = EmployeePayOrDedTemp::where('employee_id', $employeeId)->get();
        foreach ($currentData as $data) {
            $empInfo = EmployeeDetails::where('employee_id', $data['employee_id'])->first();
            $commonData = [
                'employee_id' => $empInfo->employee_id,
                'employee_name' => $empInfo->employee_name,
                'designation_id' => $empInfo->designation_id,
                'designation_name' => $empInfo->designation,
                'branch_id' => $data['branch_id'],
                'branch_name' => $empInfo->branch_name,
                'payment_date' => date('Y-m-d', strtotime($data['payment_date']))
            ];

            if (!empty($data['pay_or_ded_type'])) {
                if ($data['pay_or_ded_type'] == 1) {
                    $payType[] = $this->payOrDedArray(1, $data['type_id'], $data['pay_amount'], $data['pay_type']);
                }
                if ($data['pay_or_ded_type'] == 2) {
                    /* Pay Type  = 3 Means Bank will take the amount as deduction*/
                    $dedType[] = $this->payOrDedArray(2, $data['type_id'], $data['pay_amount'], empty($data['pay_type']) ? 3 : $data['pay_type']);
                }
            }

        }

        $archiveData['employeeInfo'] = empty($commonData) ? null : $commonData;
        $archiveData['payType'] = empty($payType) ? null : $payType;
        $archiveData['dedType'] = empty($dedType) ? null : $dedType;


        return json_encode($archiveData, JSON_PRETTY_PRINT);
    }

    public function payOrDedTempArchiveProcess(): RedirectResponse
    {

        try {

            $payOrDedEmployees = EmployeePayOrDedTemp::select(DB::raw("DISTINCT employee_id"))->pluck('employee_id');

            foreach ($payOrDedEmployees as $payOrDedEmployee) {

                $paymentArchive = new EmployeePaymentArchive();
                $paymentArchiveData = $this->finalSalArchive($payOrDedEmployee);
                $paymentDate = json_decode($paymentArchiveData)->employeeInfo;


                $paymentArchive->fill(array(
                    'employee_id'=> $payOrDedEmployee,
                    'payment_date'=> $paymentDate->payment_date,
                    'payment_info' => $paymentArchiveData
                ))->save();
                EmployeePayOrDedTemp::where('employee_id', $payOrDedEmployee)->delete();
            }
            \Log::info('SalaryProcessController-payOrDedTempArchiveProcess-' . 'payOrDedTempArchiveProcess Data Updated');
            return Redirect()->back()->with('msg-success', 'payOrDedTempArchiveProcess Data Updated');
        } catch (\Exception $e) {
            \Log::info('SalaryProcessController-payOrDedTempArchiveProcess-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /*--------------------------------------EMP Pay Or Ded Temp Archive End-----------------------------*/

    /*--------------------------------------EMP Sal Process Archive-----------------------------*/

    public function finalEmpSalProcessArchive($branchCode)
    {
        $tranInfo = SalaryProcess::where('branch_code', $branchCode)->get();
        foreach ($tranInfo as $singleTransaction) {
            $transactionData [] = [
                'accountno' => $singleTransaction->accountno,
                'amount' => $singleTransaction->amount,
                'dr_cr' => $singleTransaction->dr_cr,
                'tran_br_code' => $singleTransaction->tran_br_code,
                'ac_br_code' => $singleTransaction->ac_br_code,
                'payment_date' => $singleTransaction->payment_date,
                'remarks' => $singleTransaction->remarks,
                'process_index' => $singleTransaction->process_index,
                'created_at' => $singleTransaction->created_at,
                'created_by' => $singleTransaction->created_by,
            ];

        }

        $archiveData['transactionInfo'] = empty($transactionData) ? null : $transactionData;
        return json_encode($archiveData, JSON_PRETTY_PRINT);
    }

    public function glPlTransactionsArchive(): RedirectResponse
    {
        try {
            $branchCodes = Branch::select('cbs_branch_code')
                ->groupby('cbs_branch_code')
                ->orderby('cbs_branch_code')->get();
            foreach ($branchCodes as $branchCode) {
                $transactionArchive = new TransactionArchive();
                $transactionData = $this->finalEmpSalProcessArchive($branchCode->cbs_branch_code);
                $transactionArchive->fill([
                    'branch_code' => $branchCode->cbs_branch_code,
                    'transaction_info' => $transactionData
                ])->save();
                SalaryProcess::where('branch_code', $branchCode->cbs_branch_code)->delete();
            }
            \Log::info('SalaryProcessController-glPlTransactionsArchive-' . 'glPlTransactionsArchive Data Updated');
            return Redirect()->back()->with('msg-success', 'glPlTransactionsArchive Data Updated');
        } catch (\Exception $e) {
            \Log::info('SalaryProcessController-glPlTransactionsArchive-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /*--------------------------------------EMP Sal Process Archive End-----------------------------*/
    /*--------------------------------------EMP Sal for festival bonus Process Archive start-----------------------------*/
    public function BonusglPlTransactionsArchive(): RedirectResponse
    {
        try {
            $branchCodes = Branch::select('cbs_branch_code')
                ->groupby('cbs_branch_code')
                ->orderby('cbs_branch_code')->get();
            foreach ($branchCodes as $branchCode) {
                $transactionArchive = new EmpBonusTransactionArchive();
                $transactionData = $this->finalEmpSalProcessArchive($branchCode->cbs_branch_code);
                $transactionArchive->fill([
                    'branch_code' => $branchCode->cbs_branch_code,
                    'transaction_info' => $transactionData
                ])->save();
                SalaryProcess::where('branch_code', $branchCode->cbs_branch_code)->delete();
            }
            \Log::info('SalaryProcessController-glPlTransactionsArchive-' . 'glPlTransactionsArchive Data Updated');
            return Redirect()->back()->with('msg-success', 'glPlTransactionsArchive Data Updated');
        } catch (\Exception $e) {
            \Log::info('SalaryProcessController-glPlTransactionsArchive-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /*--------------------------------------EMP Sal for festival bonus Process Archive end-----------------------------*/

    public function empPaidDayArchive(): RedirectResponse
    {
        try {
            $currentData = PaidDay::get();
            foreach ($currentData as $data) {

                $empPaidDayArchive = new PaidDayArchive();
                if ($data->status == 4 || $data->status == 5) {
                    $isPaid = 1;
                } else {
                    $isPaid = 2;
                }

                $updatedInfo = ['employee_id' => $data->employee_id,
                    'payment_date' => date('Y-m-d', strtotime($data->payment_date)),
                    'year_month' => $data->year_month,
                    'default_date' => date('Y-m-d', strtotime($data->default_date)),
                    'day_count' => (int)$data->day_count,
                    'day_paid' => (int)$data->day_paid,
                    'is_paid' => $isPaid, /****1 = Is Not Paid & 2 = Paid ****/
                    'status' => (int)$data->status,
                    'ready_to_pay' => (int)$data->ready_to_pay,
                    'remarks' => $data->remarks,
                    'end_date' => date('Y-m-d', strtotime($data->end_date))];
                $empPaidDayArchive->fill($updatedInfo)->save();

            }
            \Log::info('SalaryProcessController-empPaidDayArchive-' . 'empPaidDayArchive Data Updated');
            return Redirect()->back()->with('msg-success', 'empPaidDayArchive Data Updated');
        } catch (\Exception $e) {
            \Log::info('SalaryProcessController-empPaidDayArchive-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }


    /*-------------------Archive Section Ended--------------------------------------------------*/

    /*--------------------------------------EMP sal for EMPbonus table Archive -----------------------------*/

    public function empBonusArchive(): RedirectResponse
    {
        try {
            $currentData = FestivalBonus::get();
            foreach ($currentData as $data) {
                $empbonusArchive = new FestivalBonusArchive();
                $updatedInfo = [
                    'employee_id' => $data->employee_id,
                    'branch_id' => $data->branch_id,
                    'bonus_type' => $data->bonus_type,
                    'pay_type_id' => $data->pay_type_id,
                    'amount' => $data->amount,
                    'status' => $data->status,
                    'payment_date' => date('Y-m-d', strtotime($data->payment_date)),
                ];

                $empbonusArchive->fill($updatedInfo)->save();
                FestivalBonus::where('employee_id', $data->employee_id)->delete();
            }

            \Log::info('SalaryProcessController-empPaidDayArchive-' . 'empPaidDayArchive Data Updated');
            return Redirect()->back()->with('msg-success', 'empPaidDayArchive Data Updated');
        } catch (\Exception $e) {
            \Log::info('SalaryProcessController-empPaidDayArchive-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }


    /*-------------------EMP sal for EMPbonus table Archive Section Ended--------------------------------------------------*/


    /*-------------------Loan ,Bills Archive and Other Accumulation Calculation Started-------------------------------------*/

    public function loanBillArchAndDeductionAccumulation(): RedirectResponse
    {
        try {
            $currentPaidEmpS = PaidDay::get();
            foreach ($currentPaidEmpS as $currentPaidEmp) {
                $allLoanInfo = Loan::where('employee_id', $currentPaidEmp->employee_id)
                    ->where('status', 1)->get();
                $deductionInfo = SalaryDedSlip::where('emp_id', $currentPaidEmp->employee_id)
                    ->get();
                /*********************loan Update***********************/
                foreach ($allLoanInfo as $singleLoanInfo) {
                    $updateLoan = new Loan();
                    $updateLoan->findOrFail($singleLoanInfo->id)->update([
                        'recover_amt' => (float)$singleLoanInfo->recover_amt + (float)$singleLoanInfo->rate,
                    ]);
                }
                /*********************Salary Deduction Update***********************/
                foreach ($deductionInfo as $singleDeductionInfo) {
                    $updateDeduction = new SalaryDedSlip();
                    $updateDeduction->where('emp_id', $singleDeductionInfo->emp_id)
                        ->where('dtype_id', $singleDeductionInfo->dtype_id)
                        ->update([
                            'accumulation' => (float)$singleDeductionInfo->accumulation + (float)$singleDeductionInfo->rate,
                        ]);
                }

                PaidDay::findOrFail($currentPaidEmp->id)->delete();
            }

            /********************* Bill Archive ***********************/
            $billsTemp = EmployeeBillsTmp::get();
            foreach ($billsTemp as $bill) {
                $archiveBills = new EmployeeBillsArchive();
                $data = ['employee_id' => $bill->employee_id,
                    'bill_amount' => $bill->bill_amount,
                    'remarks' => $bill->remarks];
                $archiveBills->fill($data)->save();
                EmployeeBillsTmp::findOrFail($bill->id)->delete();
            }

            \Log::info('SalaryProcessController-loanBillArchAndDeductionAccumulation-' . 'loanBillArchAndDeductionAccumulation Data Updated');
            return Redirect()->back()->with('msg-success', 'loanAndDeductionAccumulation Data Updated');
        } catch (\Exception $e) {
            \Log::info('SalaryProcessController-loanAndDeductionAccumulation-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }

    }

    /*-------------------Loan and Other Accumulation Calculation End-------------------------------------*/


    /**
     * Remove the specified resource from storage.
     *
     * @return Application|Factory|View
     */
    public function salNotes()
    {
        $sal_notes = SalaryNotes::all();
        return view('Payroll::SalaryNotes/view', compact('sal_notes'));
    }


    public function createOrEdit($id)
    {
        $paidDayEdit = empty($id) ? null : PaidDay::findOrFail($id);
        $allEmployees = EmployeeFunction::allEmployees();
        $ready_to_pay = array(
            '' => '-- Please Select --',
            '1' => 'No',
            '2' => 'Yes',
            '3' => 'LWP'
        );

        $status = array(
            '' => '-- Please Select --',
            '1' => 'Full',
            '2' => 'Partial',
            '3' => 'Partial Join',
            '4' => 'Stop',
            '5' => 'On Provision'
        );
        $empStatus = [
            '' => '-- Please Select --',
            '1' => 'Regular',
            '2' => 'Resigned',
        ];

        return view('Payroll::SalaryProcess/edit', compact('paidDayEdit', 'empStatus', 'allEmployees', 'ready_to_pay', 'status'));
    }

    public function storeOrUpdate(Request $request)
    {
        $inputs = $request->all();


        $validator = \Validator::make($inputs, array(
            'employee_id' => ['required', Rule::unique('emp_paid_day_count')->ignore($request->id)],
            'day_paid' => 'required',
            'status' => 'required',
            'ready_to_pay' => 'required',
            'remarks' => 'required'
        ));

        if ($validator->fails()) {
            return Redirect()->back()->withErrors($validator)->withInput();
        }

        $data = array(
            'day_paid' => (int)$request->day_paid,
            'status' => (int)$request->status,
            'ready_to_pay' => (int)$request->ready_to_pay,
            'remarks' => $request->remarks,
        );

        $paidDay = new PaidDay();

        try {
            if (!empty($request->id)) {
                $paidDay->findOrFail($request->id)->update($data);
            } else {
                $paidDay->fill([
                    'employee_id' => $request->employee_id,
                    'payment_date' => date('Y-m-d', strtotime($request->payment_date)),
                    'year_month' => $request->year_month,
                    'default_date' => date('Y-m-d', strtotime($request->default_date)),
                    'end_date' => date('Y-m-d', strtotime($request->end_date)),
                    'day_count' => (int)$request->day_count,
                    'day_paid' => (int)$request->day_paid,
                    'status' => (int)$request->status,
                    'ready_to_pay' => (int)$request->ready_to_pay,
                    'remarks' => $request->remarks,
                    'emp_status' => (int)$request->emp_status,
                ])->save();
            }

        } catch (\Exception $e) {
            \Log::info('SalaryProcessController-storeOrUpdate-' . $e->getMessage());
            return Redirect()->back()->with('msg-error', $e->getMessage());
        }


        return Redirect()->back()->with('msg-success', 'Employee Salary Process Successfully Updated');
    }


}
