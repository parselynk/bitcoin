<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\ApiInterface;
use App\Repositories\Contracts\BitcoinInterface;

class BitcoinController extends Controller
{
    protected $bitcoin;

    public function __construct(ApiInterface $api)
    {
        $this->bitcoin = $api;
    }

    public function index()
    {
        return response()->json($this->bitcoin->getHistoricalData()->getMappedData());
    }
}
