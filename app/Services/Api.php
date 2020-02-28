<?php

namespace App\Services;

use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Services\Contracts\ApiInterface;

class Api implements ApiInterface
{
    protected $today;
    protected $client;
    protected $endDate;
    protected $response;
    protected $startDate;

    const BPI_INDEX = 'bpi';
    const DEFAULT_DAYS_AGO = 10;
    const DATE_FORMAT = 'Y-m-d';
    const URI = 'historical/close.json?';

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->today = Carbon::today();
        $this->setDateRange();
    }

    public function getHistoricalData()
    {

        $this->response = $this->client->get($this->getUri());
        return $this;
    }
    
    public function setDateRange(array $dateRange = [])
    {
        $this->endDate = $dateRange['end-date'] ?? $this->today->format(self::DATE_FORMAT);
        $this->startDate = $dateRange['start-date'] ?? $this->today->subDays(self::DEFAULT_DAYS_AGO)->format(self::DATE_FORMAT);
        return $this;
    }
    
    public function getResponse()
    {
        return $this->response;
    }

    protected function getBpiArray()
    {
        return json_decode($this->response->getBody()->getContents(), true)[self::BPI_INDEX];
    }

    public function getMappedData()
    {
        $bpi = $this->getBpiArray();
        $dates = json_encode(array_keys($bpi));
        $values = json_encode(array_values($bpi));

        return compact('dates', 'values');
    }
    
    protected function getUri()
    {
        return self::URI . 'start=' .  $this->startDate . '&end=' . $this->endDate;
    }
}
