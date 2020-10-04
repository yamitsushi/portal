<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Storage;
use App\Listeners\ActivateInternet;
use App\Models\Client;
use \Carbon\Carbon;

class CheckInternet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:internet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checking Internet Connection';

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
        exec('ping 8.8.8.8 -n 1', $output, $failed);
        if($failed) {
            $this->info("show");
            $now = Carbon::now();
            $active = Client::where('active', True)->get();
            foreach($active as $temp)
            {
                $last = Carbon::parse($temp->updated_at)->addSeconds($temp->timer);

                $timer = $now->greaterThan($last) ? 0 : $now->diffInSeconds($last);

                Client::find($temp->id)->update([
                    'timer' => $timer,
                    'active' => False
                ]);

                event(new ActivateInternet($temp->rule, False));
            }
        }
    }
}