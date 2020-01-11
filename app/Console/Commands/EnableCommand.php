<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use \Carbon\Carbon;
use App\Client;

class EnableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portal:enable {mac : MAC of the user} {ip : IP of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enable Internet Connection';

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
$stamp = Carbon::now()->addSeconds(300);
        $date = $stamp->format("yy-m-d");
        $time = $stamp->format("H:i:s");
        $process = new Process("sudo iptables -t mangle -I OUT -m mac --mac-source ". $this->argument('mac') ." time --datestop ". $date ."T". $time ."-j MARK --set-mark 99")->run();
        $process = new Process("sudo rmtrack ".$this->argument('ip'));
        $process->run();
        if(!$client->is_monitoring)
        {/*
            popen("python scripts/monitor.py ". $this->argument('mac'), 'r');
            $process = new Process("python monitor.py " . $argument('ip'));
            $process->run();
            $client->is_monitoring = True;
*/
        }
        $client->is_active = True;
        $client->save();
    }
}
