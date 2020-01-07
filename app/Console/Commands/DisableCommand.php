<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class DisableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portal:disable {mac : MAC of the user} {ip : IP of the user}';

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
        $process = new Process("sudo iptables -t mangle -D OUT -m mac --mac-source " . $this->argument('mac') ." -j MARK --set-mark 99");
        $process->run();
        $process = new Process("sudo rmtrack ".$this->argument('ip'));
        $process->run();

    }
}
