<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ExpireOtps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:otps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire OTPs older than 5 minutes';
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::where('expires_at', '<', now()->subMinutes(5))->update(['otp' => null]);
    }
}
