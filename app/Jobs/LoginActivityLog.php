<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\LoginActivity;

use Carbon\Carbon;

class LoginActivityLog implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $purpose;
    protected $ipAddress;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Request $request, $purpose)
    {
        $this->request   = $request;
        $this->user      = $this->request->user();
        $this->purpose      = $purpose;
        // $this->ipAddress = trim(explode(',', $this->request->header('X-Forwarded-For'))[0]);
        $this->ipAddress = $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            // Log::info('Log Footprint Found...');

            LoginActivity::create([
                'username'    => $this->user ? $this->user->employee_id : null,
                'user_ip'     => $this->ipAddress,
                'purpose'     => $this->purpose,
                'login_date'  => Carbon::now()
            ]);
        }
        catch (\Exception $e){
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__.'@'.__FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');
        }
    }
}
