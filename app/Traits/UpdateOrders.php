<?php
namespace App\Traits;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author soulo
 */
use App\Modules\Order\Models\DailyOrder;
use App\Modules\Order\Models\MonthlyOrder;
use App\Modules\Products\Models\Category;
use Carbon\Carbon;
trait UpdateOrders {
    public function __updateDailyOrder($category_id, $order, $profit) {
        $dailyOrder = DailyOrder::where('order_date', date('Y-m-d'))->first();
        if ($dailyOrder) {
            $dailyOrder->total_order += $order;
            $dailyOrder->total_profit += $profit;
            $dailyOrder->save();
        } else {
            $dailyOrder = new DailyOrder();
            $dailyOrder->order_date = Carbon::now();
            $dailyOrder->total_order = $order;
            $dailyOrder->total_profit = $profit;
            $dailyOrder->save();
        }

        $this->__updateMonthlyOrder($category_id, $order, $profit);
    }

    public function __updateMonthlyOrder($category_id, $order, $profit) {
        $monthlyOrder = MonthlyOrder::where('year', date('Y'))->where('month', date('m'))->first();
        if ($monthlyOrder) {
            $monthlyOrder->total_order += $order;
            $monthlyOrder->total_profit += $profit;
            $monthlyOrder->save();
        } else {
            $monthlyOrder = new MonthlyOrder();
            $monthlyOrder->year = Carbon::now()->format('Y');
            $monthlyOrder->month = Carbon::now()->format('m');
            $monthlyOrder->total_order = $order;
            $monthlyOrder->total_profit = $profit;
            $monthlyOrder->save();
        }
    }
}
