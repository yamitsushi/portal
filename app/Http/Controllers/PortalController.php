<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;

class PortalController extends Controller
{
    public function tag(Request $request)
    {
        $arp= 'arp -a ' . $request->ip();
        $lines=explode(" ", exec($arp));
        return response()->json(Client::firstOrCreate(['mac' => $lines[3]]));
    }
}
