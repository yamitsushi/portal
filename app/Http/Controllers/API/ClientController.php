<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Listeners\ActivateInternet;
use App\Models\Client;
use \Carbon\Carbon;

class ClientController extends Controller
{

    protected $mac;

    public function __construct(Request $request)
    {
        $arp = explode(" ", exec("getmac"));
        $this->mac = str_replace('-', ':', $arp[0]);
    }

    public function index(Request $request)
    {
        $now = Carbon::now();
        $client = Client::firstOrCreate(['mac' => $this->mac]);
        $last = Carbon::parse($client->updated_at)->addSeconds($client->timer);

        if($client->active) {
            $client->timer = $now->greaterThan($last) ? 0 : $now->diffInSeconds($last);
            if($client->timer == 0) {
                $client->active = False;
                $client->save();
            }
        };

        return response()->json([
            'ip' => $request->ip(),
            'mac' => $client->mac,
            'timer' => (integer) $client->timer,
            'active' => (boolean) $client->active
        ]);
    }
    
    public function update(Request $request)
    {
        $now = Carbon::now();
        $client = Client::firstOrCreate(['mac' => $this->mac]);
        $last = Carbon::parse($client->updated_at)->addSeconds($client->timer);

        if($client->active) {
            $client->timer = $now->greaterThan($last) ? 0 : $now->diffInSeconds($last);
            $client->active = False;
            $client->save();

            event(new ActivateInternet($client->rule, False));
        } else {
            if($client->timer > 0) {
                $client->active = True;
                $client->rule = "mac --mac-source ". $this->mac .
                    " time --datestop ". $last->isoFormat('YYYY-MM-DD\THH:mm') ." ";

                $client->save();


                event(new ActivateInternet($client->rule, True));
            }
        };

        return response()->json([
            'timer' => (integer) $client->timer,
            'active' => (boolean) $client->active
        ]);
    }
}
