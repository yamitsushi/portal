<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use \Carbon\Carbon;
use App\Client;

class PortalController extends Controller
{
    public function tag(Request $request)
    {
        return response()->json(Client::retrieveUser($request->ip()));
    }

    public function check(Request $request)
    {
        return response()->json(Client::check($request->ip()));
    }

    public function register(Request $request)
    {
        return response()->json(Client::subs());
    }

    public function start(Request $request)
    {
        return response()->json(Client::startInternet($request->ip()));
    }

    public function stop(Request $request)
    {
        return response()->json(Client::stopInternet($request->ip()));
    }
}
