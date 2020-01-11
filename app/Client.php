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
        return $timer * 60;
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

	if(Carbon::parse($current->date)->diffInSeconds(Carbon::now()) >= 60)
        {
            if($current->pulse > 0)
                Client::where('mac', $current->mac)->increment('time', Client::convertPulse($current->pulse));
            $client = Client::retrieveUser($ip);
            $current->mac = $client->mac;
            $current->pulse = 0;
            $current->date = Carbon::now();
            Storage::put('paying.json', json_encode($current));
        }
        if($current->mac == Client::retrieveUser($ip)->mac)
        {
            $current->date = Carbon::parse($current->date)->toDateTimeString();
            return $current;
        } else abort(403, 'Portal in use.');
    }

    public static function subs()
    {
        $current = json_decode(Storage::get('paying.json'));
        Client::where('mac', $current->mac)->increment('time', Client::convertPulse($current->pulse));
        $current->pulse = 0;
        $current->date = Carbon::yesterday();
        Storage::put('paying.json', json_encode($current));
        return Client::where('mac', $current->mac)->first();
    }

    public static function startInternet($ip)
    {
        $client = Client::retrieveUser($ip);
        \Artisan::call('portal:enable '.$client->mac.' '.$ip);
        exit();
    }

    public static function stopInternet($ip)
    {
        $client = Client::retrieveUser($ip);
        \Artisan::call('portal:disable '.$client->mac.' '.$ip);
        exit();
    }
}
