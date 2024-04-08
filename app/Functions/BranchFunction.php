<?php

namespace App\Functions;

use App\Modules\Branch\Models\Branch;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

/**
 * Created By
 * Pronab Kumer Roy
 * Senior Officer
 * Created on 11-Nov-2022
 *
 */
class BranchFunction
{
    /**
     * This Will Return All Branches Including Active and Inactive
     * @return mixed
     */
    public static function allBranches()
    {
        try {
            return Branch::select(DB::raw("(branch_name) branch_name"), 'id as branch')
                ->pluck('branch_name', 'branch');
        } catch (Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * This Function will Return Either Active or Inactive Branch List Based on Parameter
     * @param $activeStatus
     * @return mixed
     */
    public static function activeOrInactiveBranches($activeStatus)
    {
        try {
            return Branch::select(DB::raw("(branch_name) branch_name"), 'id as branch')
                ->where('active_status', $activeStatus)
                ->pluck('branch_name', 'branch');
        } catch (Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * This Function will return a single Branch Information
     * @param $branchId
     * @return mixed
     */
    public static function singleActiveBranch($branchId)
    {
        try {
            return Branch::select(DB::raw("(branch_name) branch_name"), 'id as branch')
                ->where('id', $branchId)
                ->where('active_status', 1)
                ->pluck('branch_name', 'branch');
        } catch (Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }
    public static function singleActiveBranchGet($branchId)
    {
        try {
            return Branch::select(DB::raw("(branch_name) branch_name"), 'id as branch')
                ->where('id', $branchId)
                ->where('active_status', 1)
                ->first();
        } catch (Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }


    /**
     * This Function will return a single Branch Information
     * @param $branchId
     * @return mixed
     */
    public static function branchNameByCode($branchCode)
    {
        try {
            return Branch::select(DB::raw("(branch_name) branch_name"), 'id as branch')
                ->where('cbs_branch_code', $branchCode)
                ->where('active_status', 1)
                ->pluck('branch_name');
        } catch (Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }

    /**
     * This Function will return all Head Office or Branch Information
     * @param $office
     * @return mixed
     */
    public static function headOfficeOrBranch($office)
    {
        /**
         * Head Office =1
         * Branch = 2
         */
        try {
            return Branch::select(DB::raw("(branch_name) branch_name"), 'id as branch')
                ->where('head_office', $office)
                ->where('active_status', 1)
                ->pluck('branch_name', 'branch');
        } catch (Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }


    /**
     * This Function will return all Head Office or Branch Information
     * @param $branchId
     * @return mixed
     */
    public static function activeSubBranches()
    {
        /**
         * Parent Branch Null =  Branch
         * Parent Branch Null <>  Branch
         */
        try {
            return Branch::select(DB::raw("(branch_name) branch_name"), 'id as branch')
                ->whereNotNull('parent_branch')
                ->where('active_status', 1)
                ->pluck('branch_name', 'branch');
        } catch (Exception $e) {
            return redirect()->back()->with('msg-error', $e->getMessage());
        }
    }


}