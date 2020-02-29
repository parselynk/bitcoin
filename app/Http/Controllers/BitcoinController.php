<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7;
use Illuminate\Http\Request;
use App\Services\Contracts\ApiInterface;
use GuzzleHttp\Exception\RequestException;

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
            'start-date' => 'date|date_format:Y-m-d|before_or_equal:end-date',
            'end-date' => 'date|date_format:Y-m-d|before_or_equal:today',
        ]);

        try {
            $data = !empty($dateRange) ?
            $this->bitcoin->setDateRange($dateRange)->getHistoricalData()->getMappedData() :
            $this->bitcoin->getHistoricalData()->getMappedData();
            return view('index', $data);
        } catch (RequestException $e) {
            return back()->withErrors([
                "message" => $e->getMessage()
            ]);
        }
    }
}
