<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\PulseMessage;
use App\Models\CoinLog;

class PulseReceive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pulse:send {pulse}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Pulse';

    /**
     * Create a new command instance.
     *
     * @return void
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
        $active = CoinLog::where('active', True)->first();
        
        $active->pulse+= $this->argument('pulse');
        $active->save();

        event(new PulseMessage($active->id));
    }
}
