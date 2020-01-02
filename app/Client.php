<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use \Carbon\Carbon;

class Client extends Model
{
    protected $fillable = ['mac', 'time'];

    public static function convertPulse($pulse)
    {
        $left = $pulse;
        $timer = 0;
        $timer += floor($left / 10) * 60;
        $left = $left % 10;
        $timer += floor($left / 5) * 30;
        $left = $left % 5;
        $timer += $left * 5;
        return $timer;
    }

    public static function retrieveUser($ip)
    {
        $arp= 'arp -a ' . $ip;
        $lines=explode(" ", exec($arp));
        return Client::firstOrCreate(['mac' => $lines[3]]);
    }

    public static function check($ip)
    {
        $current = json_decode(Storage::get('paying.json'));
        $client = Client::retrieveUser($ip);

	if(Carbon::parse($current->date)->diffInSeconds(Carbon::now()) >= 60)
        {
            if($current->pulse > 0)
                Client::where('mac', $current->mac)->increments('time', Client::convertPulse($current->pulse));
            $current->mac = $client->mac;
            $current->pulse = 0;
            $current->date = Carbon::now();
            Storage::put('paying.json', json_encode($current));
        }
        $current->date = Carbon::parse($current->date)->toDateTimeString();
        return response()->json($current);
    }

    public static function register($ip)
    {
        abort(403, 'Under Contruction.');
    }

    public static function start($ip)
    {
        abort(403, 'Under Contruction.');
    }

    public static function stop($ip)
    {
        abort(403, 'Under Contruction.');
    }
}
