<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
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
        if($client->is_active == false)
        {
            $client->stamp = Carbon::now();
            $client->is_active = true;
            $client->save();

            $list = json_decode(Storage::get('list.json'), true);
            $list[$client->mac] = [$client->mac, $this->argument('ip')];
            Storage::put('list.json', json_encode($list));

            $stamp = $client->stamp->addSeconds($client->time);
            $date = $stamp->format("yy-m-d");
            $time = $stamp->format("H:i:s");
            shell_exec("sudo iptables -t mangle -I internet -m mac --mac-source ". $this->argument('mac') ." -m time --datestop ". $date ."T". $time ." -j RETURN");
            shell_exec("sudo rmtrack ". $this->argument('ip'));
        }
    }
}
