<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use \Carbon\Carbon;
use App\Client;

class DisableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portal:disable {mac : MAC of the user} {--monitor: Disabled by monitor}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable Internet Connection';

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
        $client = Client::where('mac', $this->argument('mac'))->first();
        $stamp = Carbon::parse($client->updated_at)->addSeconds($client->time);
        $date = $stamp->format("yy-m-d");
        $time = $stamp->format("H:i:s");

        $process = new Process("sudo iptables -t mangle -D OUT -m mac --mac-source ". $this->argument('mac') ." time --datestop ". $date ."T". $time ."-j MARK --set-mark 99");
        $process->run();
        $process = new Process("sudo rmtrack ".$this->argument('ip'));
        $process->run();

        $client->is_active = False;
        $client->is_monitoring = $this->argument('--monitor') ? False : True;
        $client->save();
    }
}
