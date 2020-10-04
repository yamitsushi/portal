<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RateController extends Controller
{
	public function __invoke()
	{
		return response()->json(json_decode(Storage::get('rates.json'), true));
	}
}
