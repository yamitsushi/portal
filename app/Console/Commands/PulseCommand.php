<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\PulseMessage;
use Illuminate\Support\Facades\Storage;
use \Carbon\Carbon;

class PulseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portal:pulse';

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
        $paying = json_decode(Storage::get('paying.json'));
       // if(Carbon::now()->diffInSeconds(Carbon::parse($paying->date)) >= 60)
       // {
            $paying->pulse+= 1;
            $paying->date= Carbon::now()->toDateTimeString();
            Storage::put('paying.json', json_encode($paying));
            event(new PulseMessage());
       // }
        $this->line('Pulse Send');
    }
}
