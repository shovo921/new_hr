<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Modules\Tickets\Models\TicketAllocation;
use App\Modules\Invoice\Models\Invoice;
use Log;
use Carbon\Carbon;

class ReleaseHoldTickets extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'release:holdTickets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Release all tickets that have been held for more than 15 min';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $invoices = Invoice::where('created_at', '<', Carbon::now()->subMinutes(10)->toDateTimeString())
                ->where('status', 'pending')
                ->get();
        if (!$invoices) {
            return;
        }

        foreach ($invoices as $invoice) {
            
                $invoiceDetails = $invoice->details;
                foreach ($invoiceDetails as $invDet) {
                    $ticketAllocation = $invDet->ticketAllocation;
                    $ticketAllocation->hold_qty = $ticketAllocation->hold_qty - $invDet->qty;
                    $ticketAllocation->save();
                }
                $invoice->status = 'auto-cancel';
                $invoice->save();
        }
    }

}
