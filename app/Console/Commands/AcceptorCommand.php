<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AcceptorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portal:acceptor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Coin Acceptor';

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
        exec("python scripts/pulse.py > /dev/null &");
        /*
        $spec = array(
            0 => array("pipe", "r"),
            1 => array("pipe", "w"),
            2 => array("pipe", "w")
        );
        flush();
        $process = proc_open($cmd, $spec, $pipes);
        while($s = fgets($pipes[1]))
        {
            $this->line($s);
            flush();
        };
        /*
        $handle = popen("python scripts/pulse.py", "r");
        while (!feof($handle)) {
            echo fgets($handle);
            flush();
            ob_flush();
        }
        pclose($handle);
        */
    }
}
