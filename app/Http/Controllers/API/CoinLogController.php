<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Client;
use App\Models\CoinLog;
use \Carbon\Carbon;

class CoinLogController extends Controller
{

	protected $client, $rate;

	public function __construct(Request $request)
	{
		$rate = json_decode(Storage::get('rates.json'), true);

		$arp = explode(" ", exec("getmac"));
		$mac = str_replace('-', ':', $arp[0]);

		$this->rate = collect($rate)->sortBy('pulse')->reverse()->toArray();

		$this->client = $this->stopper(
			Client::firstOrCreate(['mac' => $mac])
		);
	}

	public function index()
	{
		$log = CoinLog::with('client:id,mac')->firstOrCreate(
			['active' => true],
			['client_id' => $this->client->id]
		);

		$timeout = Carbon::parse($log->updated_at)->diffInSeconds(Carbon::now());


		return response()->json([
			'mac' => $log->client->mac,
			'pulse' => (integer) $log->pulse,
			'time' => $this->time($log->pulse),
			'timeout' => $timeout < 30 ? 60 - $timeout : abort(404)
		]);
	}

	public function update(Request $request)
	{
		$log = $this->client->coinlog()->where('active', True)->firstOrFail();

		$this->client->timer += $this->time($log->pulse);
		$this->client->save();

		$log->active = False;
		$log->save();

		return response()->json([
			'pulse' => 0,
			'active' => False
		]);
	}

	private function time($pulse)
	{
		$time=0;

		foreach($this->rate as $temp) {
			if((integer) ($pulse / $temp['pulse']) > 0) {
				$time += $temp['time'] * (integer) ($pulse / $temp['pulse']);
				$pulse = $pulse % $temp['pulse'];
			};
		};

		return $time;
	}

	private function stopper(Client $client)
	{
        $now = Carbon::now();
        $last = Carbon::parse($client->updated_at)->addSeconds($client->timer);

		if($client->active) {
			$client->timer = $now->greaterThan($last) ? 0 : $now->diffInSeconds($last);
			$client->active = False;
			$client->save();
		}

		return $client;
	}
}
