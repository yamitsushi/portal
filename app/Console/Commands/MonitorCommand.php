<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MonitorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portal:monitor {mac : MAC of the user} {ip : IP of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor Sample';

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
        while (@ ob_end_flush());
        $proc = popen("python pulse.py", 'r');
        echo $proc;
        while (!feof($proc))
        {
            fread($proc, 4096);
        }
    }
}
