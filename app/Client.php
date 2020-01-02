<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Client extends Model
{
    protected $fillable = ['mac', 'time'];

    public static function retrieveUser($ip)
    {
        $arp= 'arp -a ' . $ip;
        $lines=explode(" ", exec($arp));
        return Client::firstOrCreate(['mac' => $lines[3]]);
    }

    public static function check($ip)
    {
        abort(403, 'Under Contruction.');
        $current = json_encode(Storage::get('paying.json'));
        $client = Client::retrieveUser($ip);
        //$current = Client::where('mac', $paying->mac
        //$client->date = Carbon::now();
        //Storage::put('paying.json', json_encode($client));
        $current = Carbon::now();
        return $current->diffInSeconds($client->date);
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
