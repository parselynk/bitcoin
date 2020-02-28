<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\ApiInterface;

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
            'start-date' => 'required|date|date_format:Y-m-d|before_or_equal:end-date',
            'end-date' => 'required|date|date_format:Y-m-d|before_or_equal:today',
        ]);
        $data = !empty($dateRange) ?
        $this->bitcoin->setDateRange($dateRange)->getHistoricalData()->getMappedData() :
        $this->bitcoin->getHistoricalData()->getMappedData();

        return view('index', $data);
    }
}
