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
        $dateRange = $this->validate(request(), [
            'startdate-filter' => 'date|date_format:Y-m-d',
            'enddate-filter' => 'date|date_format:Y-m-d',
        ]);

        $data = !empty($dateRange) ?
        $this->bitcoin->setDateRange($dateRange)->getHistoricalData()->getMappedData() :
        $this->bitcoin->getHistoricalData()->getMappedData();

        return view('index', $data);
    }
}
