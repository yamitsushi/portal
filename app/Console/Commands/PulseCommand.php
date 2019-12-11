<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
//use App\Jobs\ProcessPulse;
use App\Events\PulseMessage;

class PulseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pulse:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send 1 pulse Message';

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
     * @return mixed
     */
    public function handle()
    {
        event(new PulseMessage());
        //ProcessPulse::dispatchNow();
        $this->line('Pulse Send');
    }
}
