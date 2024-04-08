<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Otp;
use App\OtpCount;
use Log;
class RemoveExpiredOpt extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:otp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove Expired Otp form database';

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
        
        $dateTime = Carbon::now()->subDays(1)->toDateTimeString();
        Otp::where('created_at', '<=', $dateTime)->delete();
        Log::info('Otp Deleted '.$dateTime);
        OtpCount::where('created_at', '<=', $dateTime)->delete();
        Log::info('Otp Count Deleted '.$dateTime);
       
    }

}
