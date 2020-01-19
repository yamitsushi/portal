<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use \Carbon\Carbon;
use App\Client;

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
        $client = Client::where('mac', $this->argument('mac'))->first();
        if($client->is_active == true)
        {
            $stamp = Carbon::parse($client->stamp);
            $stamp = $stamp->addSeconds($client->time);
            $now = Carbon::now();

            if($stamp > $now)
                $client->time = $now->diffInSeconds($stamp);
            else
                $client->time = 0;
            $client->is_active = false;
            $client->save();

            $list = json_decode(Storage::get('list.json'), true);
            unset($list[$client->mac]);
            Storage::put('list.json', json_encode($list));

            $date = $stamp->format("yy-m-d");
            $time = $stamp->format("H:i:s");
            shell_exec("sudo iptables -t mangle -D internet -m mac --mac-source ". $this->argument('mac') ." -m time --datestop ". $date ."T". $time ." -j RETURN");
            shell_exec("sudo rmtrack ".$this->argument('ip'));
        }
    }
}
