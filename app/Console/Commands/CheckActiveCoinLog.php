<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Storage;
use App\Models\CoinLog;
use \Carbon\Carbon;

class CheckActiveCoinLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:coinlog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'submit active coinglog when expired';

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
        $current = CoinLog::where('active', true)->first();
        $time = Carbon::parse($current->updated_at)->diffInSeconds(Carbon::now());

        if($time >= 60)
        {
            $rate = json_decode(Storage::get('rates.json'), true);
            $sorted = collect($rate)->sortBy('pulse')->reverse()->toArray();

            $pulse = $current->pulse;
            foreach($sorted as $temp) {
                if((integer) ($pulse / $temp['pulse']) > 0) {
                    $time += $temp['time'] * (integer) ($pulse / $temp['pulse']);
                    $pulse = $pulse % $temp['pulse'];
                };
            };
            CoinLog::where('active', true)->update(['active'=>false]);
        }
    }
}
